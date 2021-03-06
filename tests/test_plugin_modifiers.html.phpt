--TEST--
Template Test: plugin_modifiers.html
--FILE--
<?php
require_once 'testsuite.php';
compilefile('plugin_modifiers.html', 
	array(
		'numbertest' =>  10000.123,
		'datetest' =>  '2004-01-12'
	), 
	array('plugins'=>array('Savant'))
);

$errorFileName = 'flexy_raw_with_element.html';
ob_start('stripErrorFilePath');
compilefile('flexy_raw_with_element.html', 
	array( ), 
	array( )
 
);
function stripErrorFilePath($data) {
	global $errorFileName;
	$errorTemplate = "Error:/path/to/" . $errorFileName . " on Line ";
	$errorMessage = str_replace('/path/to/', dirname(__FILE__) . "/templates" . DIRECTORY_SEPARATOR, $errorTemplate);
	return str_replace($errorMessage, $errorTemplate, $data);
}
--EXPECTF--
===Compiling plugin_modifiers.html===



===Compiled file: plugin_modifiers.html===
<H1>Testing Plugin Modifiers</H1>


<?php echo $this->plugin("dateformat",$t->datetest);?>

<?php echo $this->plugin("numberformat",$t->numbertest);?>


Bug #3946 - inside raw!
 
<input type="checkbox" name="useTextarea3" <?php if ($this->options['strict'] || (isset($t->person) && method_exists($t->person, 'useTextarea'))) echo $this->plugin("checked",$t->person->useTextarea());?>>

 

===With data file: plugin_modifiers.html===
<H1>Testing Plugin Modifiers</H1>


12 Jan 2004
10,000.12

Bug #3946 - inside raw!
 
<input type="checkbox" name="useTextarea3" >

 

===Compiling flexy_raw_with_element.html===

Error:/path/to/flexy_raw_with_element.html on Line 5 in Tag &lt;INPUT&gt;:<BR>
Flexy:raw can only be used with flexy:ignore, to prevent conversion of html elements to flexy elements