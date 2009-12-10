--TEST--
Template Test: replacechildren.html
--FILE--
<?php
require_once 'testsuite.php';

class TestData {
	var $true = true;
	var $var = "<variable>";
	var $var2 = "<variable-2>\n<variable-2>";
	var $array = array(1, 2, 3);
	var $param = '<param>';
	function TestData($createChild) {
		if ($createChild) {
			$this->object = new TestData(false);
		}
	}
	function method() {
		return "<method>";
	}
	function method2() {
		return "<method2>";
	}
}

$data = new TestData(true);

compilefile('replacechildren.html', $data, array('strict'=>true));

--EXPECTF--
===Compiling replacechildren.html===



===Compiled file: replacechildren.html===
<?php if ($t->true)  {?><p>test</p><?php }?>
<?php if ($t->true)  {?><p>test</p><?php }?>

<p><?php echo htmlspecialchars($t->var);?></p>
<p><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'method'))) echo htmlspecialchars($t->method());?></p>
<div><?php echo nl2br(htmlspecialchars($t->var2));?></div>
<div><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'method2'))) echo nl2br(htmlspecialchars($t->method2()));?></div>

<?php echo htmlspecialchars($t->var);?>
<?php echo $t->var2;?>
<?php echo htmlspecialchars($t->object->var);?>
<?php echo htmlspecialchars($t->array[0]);?>
<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'method'))) echo htmlspecialchars($t->method());?>
<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'method2'))) echo $t->method2();?>
<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'method'))) echo htmlspecialchars($t->method($t->param,"param2"));?>
<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'method2'))) echo $t->method2($t->param,"param2");?>
<?php if ($this->options['strict'] || (isset($t->object) && method_exists($t->object, 'method'))) echo htmlspecialchars($t->object->method());?>
<?php if ($this->options['strict'] || (isset($t->object) && method_exists($t->object, 'method2'))) echo htmlspecialchars($t->object->method2($t->param,"param2"));?>


===With data file: replacechildren.html===
<p>test</p><p>test</p>
<p>&lt;variable&gt;</p>
<p>&lt;method&gt;</p>
<div>&lt;variable-2&gt;<br />
&lt;variable-2&gt;</div>
<div>&lt;method2&gt;</div>

&lt;variable&gt;<variable-2>
<variable-2>&lt;variable&gt;1&lt;method&gt;<method2>&lt;method&gt;<method2>&lt;method&gt;&lt;method2&gt;
