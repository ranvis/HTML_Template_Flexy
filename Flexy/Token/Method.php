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
//
 /**
* Class to handle method calls
*  *
*
*/

class HTML_Template_Flexy_Token_Method extends HTML_Template_Flexy_Token { 
    /**
    * variable modifier (h = raw, u = urlencode, none = htmlspecialchars)
    * TODO
    * @var char
    * @access public
    */
    var $modifier;
    /**
    * Method name
    *
    * @var char
    * @access public
    */
    var $method;
    /**
    * is it in if statement with a method?
    *
    * @var boolean
    * @access public
    */
    var $isConditional;
    /**
    * if the statement is negative = eg. !somevar..
    * @var string
    * @access public
    */
    var $isNegative = '';
 
    /**
    * arguments, either variables or literals eg. #xxxxx yyyy#
    * 
    * @var array
    * @access public
    */
    var $args= array();
    /**
    * setvalue - at present array method, args (need to add modifier)
    * @see parent::setValue()
    */
    
    function setValue($value) {
        // var_dump($value);
        if (!is_array($value)) {
            $value = $this->parseAndSetIf($value);
            $modifier = strrpos($value,':');
            if ($modifier !== false) {
                $this->modifier = substr($value,$modifier+1);
                $value = substr($value,0,$modifier);
            } else
                $modifier = null;
            $parenOpen = strpos($value,'(');
            $method = substr($value,0,$parenOpen);
            $value = substr($value,$parenOpen+1,-1);
            $args = $this->parseMethodArguments($value);
        } else {
            $method = $this->parseAndSetIf($value[0]);
            $args = $value[1];
            if (strpos($method,":")) {
                list($method,$this->modifier) = explode(':',$method);
            }
        }
        
        $this->method = $method;
        
        $this->args = $args;
    }
  

    /**
    * parseIf - parse if: or if:! and set isConditional, isNegative
    * @access private
    */

    function parseAndSetIf($value) {
        if (substr($value,0,3) == 'if:') {
            $this->isConditional = true;
            if ($value{3} == '!') {
                $this->isNegative = '!';
                $value = substr($value,4);
            } else {
                $value = substr($value,3);
            }
        }
        return $value;
    }
  

    /**
    * parseMethodArguments - parse method arguments, either variables or literals
    * @access private
    */

    function parseMethodArguments($value) {
        $args = array();
        while ($value != '') {
            // check for quotes
            if ($value{0} == '#') {
                $hashClose = strpos($value,'#',1);
                if ($hashClose !== false && $hashClose == strlen($value)-1 || $value{$hashClose+1} == ',') {
                    $args[] = substr($value,0,$hashClose+1);
                    $value = substr($value,$hashClose+2);
                    continue;
                }
            }
            $delimiterPosition = strcspn($value,',');
            $args[] = substr($value,0,$delimiterPosition);
            $value = substr($value,$delimiterPosition+1);
        }
        return $args;
    }

}


 
   