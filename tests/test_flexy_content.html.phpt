--TEST--
Template Test: flexy_content.html
--FILE--
<?php
require_once 'testsuite.php';
compilefile('flexy_content.html');

--EXPECTF--
===Compiling flexy_content.html===



===Compiled file: flexy_content.html===
<div><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'method'))) echo htmlspecialchars($t->method("1:23:45"));?></div>
<div><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'method'))) echo $t->method("1:23:45");?></div>


===With data file: flexy_content.html===
<div></div>
<div></div>