<?php


/**
* Compiler That deals with any internal functions
* This is BETA - a better method for doing this needs to be thought through..
* I guess this class should deal with the main namespace
* and the parent (standard compiler can redirect other namespaces to other classes.
*
* one instance of these exists for each namespace.
*
*
* @version    $Id$
*/

class HTML_Template_Flexy_Compiler_Standard_Functions extends HTML_Template_Flexy_Compiler_Standard {

        
    /**
    * Parent Compiler for 
    *
    * @var  object  HTML_Template_Flexy_Compiler  
    * 
    * @access public
    */
    var $compiler;
     
   
    /**
    * counstructor method 
    * 
    * 
    * @param   object   HTML_Template_Flexy_Compiler  
    * 
    *
    * @return    object    functions compiler
    * @access   public
    */
    
    function &handle(&$compiler,$element) {
        $class = __CLASS__;
        $ret = new $class;
        $ret->compiler = &$compiler;
        return $ret->_handle($element);
        
        /*
        there should be hooks in here for loading user defined methods...
        based on config variables....
        
        by default they will be off.. - eg. marginally securer..
        */
        
    }
    /**
    * handle a {method(....)} call...
    * 
    * 
    * @param   object   HTML_Template_Flexy_Tag
    * 
    *
    * @return    object    functions compiler
    * @access   public
    * @static
    */
        
        
    function _handle($element) {
    
         
        // steps:
        // a) internal handlers
        // b) registered handlers.. LATER..
        // default - $t->method...
        
        list($prefix,$suffix) = $this->getModifierWrapper($element);
        
        // add the '!' to if
        
        if ($element->isConditional) {
            $prefix = 'if ('.$element->isNegative;
            $element->pushState();
            $suffix = ')';
        }  
        
        
        
        
        $body = false;
        
        // to use any of the internal functions, they must be listed in the config
        // eg. valid_functions = "include date printf" ... etc.
        
        $valid = @$this->compiler->options['valid_functions'];
        if ($valid && in_array(strtolower($method),preg_split('/\s+/',strtolower($valid)))) {
            
            if (method_exists($this,'handle'.$method)) {
               $body =  $this->{'handle'.$method}($element);
            } 
            
            // b) !!! BETA!!!
            $handlerClasses =  @$this->compiler->options['function_handlers'];
            if ($body === false && $handlerClasses ) {

                $handlerClasses  = preg_split('/\s+/',strtolower($handlerClasses));
                foreach ($handlerClasses  as $classname) {
                    if (is_callable(array($classname,'handle'.$method))) {
                        $x = new $classname;
                        $body = $x->{'handle'.$method}($element);
                        break;
                    }
                }
            }
            
            // return if we've set body alread..
            
            if ($body !== false) {
                $ret .= $prefix . $body . $suffix;
                 if ($element->isConditional) {
                    $ret .= ' { ';
                } else {
                    $ret .= ";";
                }
                return $this->appendPhp($ret);
             
                
            }
        }
        
        // good ole default behaviour..
        
        
        
        
        // check that method exists..
        // if (method_exists($object,'method');
        $bits = explode('.',$element->method);
        $method = array_pop($bits);
        
        $object = implode('.',$bits);
        
        $prefix = 'if (isset('.$element->toVar($object).
            ') && method_exists('.$element->toVar($object) .",'{$method}')) " . $prefix;
        
        
        
        $ret  =  $prefix;
        $ret .=  $element->toVar($element->method) . "(";
        $s =0;
         
        foreach($element->args as $a) {
             
            if ($s) {
                $ret .= ",";
            }
            $s =1;
            if ($a{0} == '#') {
                $ret .= '"'. addslashes(substr($a,1,-1)) . '"';
                continue;
            }
            $ret .= $element->toVar($a);
            
        }
        $ret .= ")" . $suffix;
        
        if ($element->isConditional) {
            $ret .= ' { ';
        } else {
            $ret .= ";";
        }
        
        
        
        return $this->appendPhp($ret);
        
    
    
    }
    
    
    
    function handleInclude($element) {
        // this is disabled by default...
        
    
    
    
        $arg = $element->args[0];
        // only literals handled...!!!
        if ($arg{0} != '#') {
            return false;
        }
        
        // compile the child template....
        // output... include $this->options['compiled_templates'] . $arg . $this->options['locale'] . '.php'
        return "\$x = new HTML_Template_Flexy;\$x->compile('{$arg}');" .
               "include \$this->compiler->options['compiled_templates']/{$arg}.{$this->options['locale']}.php'";
    
    }
    
    

}

?>