<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors:  Alan Knowles <alan@akbkhome>                               |
// +----------------------------------------------------------------------+
//
// $Id$
 
/**
* A standard HTML Tag = eg. Table/Body etc.
*
* @abstract 
* This is the generic HTML tag 
* a simple one will have some attributes and a name.
*
*/

class HTML_Template_Flexy_Token_Tag extends HTML_Template_Flexy_Token {
        
    /**
    * HTML Tag: eg. Body or /Body
    *
    * @var string
    * @access public
    */
    var $tag = '';
    /**
    * Associative array of attributes.
    *
    * key is the left, value is the right..
    * note:
    *     values are raw (eg. include "")
    *     valuse can be 
    *                text = standard
    *                array (a parsed value with flexy tags in)
    *                object (normally some PHP code that generates the key as well..)
    *
    *
    * @var array
    * @access public
    */

    var $attributes = array();
    /**
    * postfix tokens 
    * used to add code to end of tags
    *
    * @var array
    * @access public
    */
    var $postfix = '';
     /**
    * prefix tokens 
    * used to add code to beginning of tags TODO
    *
    * @var array
    * @access public
    */
    var $prefix = '';
    
        
    /**
    * Alias to closing tag (built externally).
    * used to add < ? } ? > code to dynamic tags.
    * @var object alias
    * @access public
    */
    var $close; // alias to closing tag.
    
    
    
    /**
    * Setvalue - gets name, attribute as an array
    * @see parent::setValue()
    */
  
    function setValue($value) {
        global $_HTML_TEMPLATE_FLEXY_TOKEN;
        $this->tag = $value[0];
        $this->UCtag = strtoupper($value[0]);
        if (isset($value[1])) {
            $this->attributes = $value[1];
        }
        // hey one day PHP will be case sensitive :)
        
        
       
    }
    /**
    * toString - display tag, attributes, postfix and any code in attributes.
    * Note first thing it does is call any parseTag Method that exists..
    *
    * 
    * @see parent::toString()
    */
    function toString() {
    
        $method = 'parseTag'.ucfirst(strtolower($this->tag));
        if (method_exists($this,$method)) {
            $this->$method();
        }
    
        $ret = '';
        if ($foreach = $this->getAttribute('foreach')) {
            $foreachObj =  $this->factory('Foreach',
                    explode(',',$foreach),
                    $this->line);
            $ret = $foreachObj->toString();
            // does it have a closetag?
            
            $this->close->postfix = array($this->factory("End",
                    '',
                    $this->line));
        
        }
    
        $ret .=  "<". $this->tag;
        foreach ($this->attributes as $k=>$v) {
            if ($v === null) {
                $ret .= " $k";
                continue;
            }
            if (is_string($v)) {
                $ret .=  " {$k}={$v}";
                continue;
            }
            if (is_object($v)) {
                $ret .= " " .$v->toString();
                continue;
            }
                
            
            $ret .=  " {$k}=";
            foreach($v as $item) {
                if (is_string($item)) {
                    $ret .= $item;
                    continue;
                }
                $ret .= $item->toString();
            }
        }
        $ret .= ">";
        if ($this->postfix) {
            foreach ($this->postfix as $e) {
                $ret .= $e->toString();
            }
        }
        $ret .= $this->childrentoString();
        if ($this->close) {
            $ret .= $this->close->toString();
        }
        return $ret;
    }
    
    /**
    * Reads an Input tag and converts it to show variables based on the current form name
    *
    * Eg. filling in the value with  $this->{fieldname}, adding in 
    * echo $this->errors['fieldname'] at the end.
    * TODO : formating using DIV tags, and support for 'required tag'
    *
    * @return   none
    * @access   public
    */
  
    function parseTagInput() 
    {
        global $_HTML_TEMPLATE_FLEXY_TOKEN;
        // form elements : format:
        //value - fill out as PHP CODE
        
        $name =    $this->getAttribute('name');
        if ($_HTML_TEMPLATE_FLEXY_TOKEN['activeForm']) {
            $name = $_HTML_TEMPLATE_FLEXY_TOKEN['activeForm'] .'.'.$name;
        }
        
        $type = strtoupper($this->getAttribute('type'));
        $thisvar = str_replace(']','',$name);
        $thisvar = str_replace('[','.',$thisvar);
        
        $posterror = array(
            $this->factory("PHP", "<?php if (isset(\$this->errors['".urlencode($thisvar)."'])) { ".
                "echo  htmlspecialchars(\$this->errors['".urlencode($thisvar). "']); } ?>",$this->line));
        
        
        switch ($type) {
            case "CHECKBOX":
                $this->attributes['checked'] = 
                    $this->factory("PHP",
                    "<?php if (". $this->toVar($thisvar).") { ?>CHECKED<?php } ?>",
                    $this->line);
                $this->postfix = $posterror;
                break;
                
            case "SUBMIT":
                return;
 




            case "HIDDEN":
                $this->attributes['value'] = array(
                    "\"",
                    $this->factory("Var",$thisvar.":u",$this->line),
                    "\"");
                return;
            
            default:
                $this->attributes['value'] = array(
                    "\"",
                    $this->factory("Var",$thisvar.":u",$this->line),
                    "\"");
               
               $this->postfix = $posterror;
               return;
            
        }
        
        
        $this->postfix = $posterror;
        // this should use <div name="form.error"> or something...
            
        
    }
    
    /**
    * Deal with a TextArea tag - empty the contents (eg. flag ignoreChildren), and add code..
    *
    * Eg. filling in the value with  $this->{fieldname}, adding in 
    * echo $this->errors['fieldname'] at the end.
    * TODO : formating using DIV tags, and support for 'required tag'
    *
    * @return   none
    * @access   public
    */
  
    function parseTagTextArea() 
    {
        global $_HTML_TEMPLATE_FLEXY_TOKEN;
        // form elements : format:
        //value - fill out as PHP CODE
        
        $name =    $this->getAttribute('name');
        if ($_HTML_TEMPLATE_FLEXY_TOKEN['activeForm']) {
            $name = $_HTML_TEMPLATE_FLEXY_TOKEN['activeForm'] .'.'.$name;
        }
         
        $thisvar = str_replace(']','',$name);
        $thisvar = str_replace('[','.',$thisvar);
        
        $posterror = array(
            $this->factory("PHP", "<?php if (isset(\$this->errors['".urlencode($thisvar)."'])) { ".
                "echo  htmlspecialchars(\$this->errors['".urlencode($thisvar). "']); } ?>",$this->line));
        
        
        $this->postfix = array(
            $this->factory("Var",$thisvar ,$this->line)
            );
        $this->close->postfix = $posterror;
        $this->children = array();
        return;
 
            
        
        
    }
    
     /**
    * Reads an Form tag and stores the current name (used as a prefix for input
    * in the form.
    *
    
    * Eg. 
    * <form name="theform"><input name="an_input">
    * gets converted to:
    * <form name="theform"><input name="an_input" value="<? echo htmlspecialchars($t->theform->an-input); ?>">
    *
    * @return   none
    * @access   public
    */
  
    function parseTagForm() 
    {
        global $_HTML_TEMPLATE_FLEXY_TOKEN;
     
        if ($name = $this->getAttribute('name')) {
            $_HTML_TEMPLATE_FLEXY_TOKEN['activeForm'] = $name;
        }
        
    
    }
    /**
    * getAttribute = reads an attribute value and strips the quotes 
    *
    * TODO : sort out case issues...
    * does not handle valuse with flexytags in
    *
    * @return   none
    * @access   string
    */
    function getAttribute($key) {
        // really need to do a foreach/ strtoupper
        if (!isset($this->attributes[$key])) {
            return '';
        }
        $v = $this->attributes[$key];
        switch($v{0}) {
            case "\"":
            case "'":
                return substr($v,1,-1);
            default:
                return $v;
        }
    }
    
    
        
}

 
 
   
?>