<?php 
function _html_template_flexy_compiler_flexy_flexy_test1($t,$this) {
?>this is the contents of test1<?php 
}
?>
<H1>Example of function block definitions</H1>


<?php if ($t->false)  {?><table>
<tr><td>
    
</td></tr>
</table><?php }?>
<table>
<tr><td>
   <?php if (function_exists('_html_template_flexy_compiler_flexy_flexy_test1'))  _html_template_flexy_compiler_flexy_flexy_test1($t,$this);?>
   <?php if (function_exists('_html_template_flexy_compiler_flexy_flexy_'.$t->a_value)) call_user_func_array('_html_template_flexy_compiler_flexy_flexy_'.$t->a_value,array($t,$this));?>
</td></tr>
</table>

    