--TEST--
Template Test: gettext.html
--FILE--
<?php
require_once 'testsuite.php';

class Translation2 {
	function setLang($locale) {
		$this->locale = $locale;
	}
	function setPageID() {
	}
	function get($string) {
		return $this->locale . '(' . $string . ')';
	}
}

$options = array(
	'Translation2' => new Translation2,
);

compilefile('gettext.html', array(), $options);

--EXPECTF--


===Compiling gettext.html===



===Compiled file: gettext.html===
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>en(title test)</title>
</head>
<body title="en(body title)">
<p title="en(p title)">
	en(paragraph text) <img src="image.png" alt="en(img alt)">
	<a href="url" title="en(a title)">en(a text)</a>
</p>
<div title="en(div title)">
	<object data="url" type="image/jpeg" standby="en(object standby)">en(object content)</object>
</div>
<form action="post">
<div>
	<map name="map">
		<area coords="0,0,1,1" href="url" alt="en(area alt)">
	</map>
	<?php echo $this->elements['text']->toHtml();?>
	<?php echo $this->elements['password']->toHtml();?>
	<?php echo $this->elements['checkbox']->toHtml();?>
	<?php 
                    $_element = $this->elements['radio_input radio value'];
                    if (isset($this->elements['radio'])) {
                        $_element = $this->mergeElement($_element,$this->elements['radio']);
                    }
                    echo  $_element->toHtml();?>
	<input type="submit" value="en(input submit value)">
	<input type="reset" value="en(input reset value)">
	<?php echo $this->elements['button']->toHtml();?>
	<table summary="en(table summary)"><tr><th abbr="en(th abbr)">en(th content)</th>
	<td abbr="en(td abbr)">
	<?php echo $this->elements['submit2']->toHtml();?>
	<?php echo $this->elements['reset2']->toHtml();?>
	<?php echo $this->elements['button2']->toHtml();?>
	</td></tr></table>
	<input type="submit" name="submit3" value="en(input submit 3 value)">
	<input type="reset" name="reset3" value="en(input reset 3 value)">
	<input type="button" name="button3" value="en(input button 3 value)">
	<?php echo $this->elements['file']->toHtml();?>
	<?php echo $this->elements['hidden']->toHtml();?>
	<input type="image" src="image.png" alt="en(input image alt)">
	<select name="select" title="en(select title)">
		<optgroup label="en(optgroup label)" title="en(optgroup title)">
			<option>en(option content)</option>
			<option value="option 2 value">en(option 2 content)</option>
			<option label="en(option 3 label)">en(option 3 content)</option>
		</optgroup>
	</select>
	<button value="button value">en(button content)</button>
</div>
</form>

===With data file: gettext.html===
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>en(title test)</title>
</head>
<body title="en(body title)">
<p title="en(p title)">
	en(paragraph text) <img src="image.png" alt="en(img alt)">
	<a href="url" title="en(a title)">en(a text)</a>
</p>
<div title="en(div title)">
	<object data="url" type="image/jpeg" standby="en(object standby)">en(object content)</object>
</div>
<form action="post">
<div>
	<map name="map">
		<area coords="0,0,1,1" href="url" alt="en(area alt)">
	</map>
	<input type="text" name="text" value="input text value">	<input type="password" name="password" value="input password value">	<input type="checkbox" name="checkbox" value="input checkbox value">	<input type="radio" name="radio" value="input radio value">	<input type="submit" value="en(input submit value)">
	<input type="reset" value="en(input reset value)">
	<input type="button" name="button" value="en(input button value)">	<table summary="en(table summary)"><tr><th abbr="en(th abbr)">en(th content)</th>
	<td abbr="en(td abbr)">
	<input type="submit" name="submit2" value="en(input submit 2 value)">	<input type="reset" name="reset2" value="en(input reset 2 value)">	<input type="button" name="button2" value="en(input button 2 value)">	</td></tr></table>
	<input type="submit" name="submit3" value="en(input submit 3 value)">
	<input type="reset" name="reset3" value="en(input reset 3 value)">
	<input type="button" name="button3" value="en(input button 3 value)">
	<input type="file" name="file" title="en(input file title)">	<input type="hidden" name="hidden" value="input hidden value">	<input type="image" src="image.png" alt="en(input image alt)">
	<select name="select" title="en(select title)">
		<optgroup label="en(optgroup label)" title="en(optgroup title)">
			<option>en(option content)</option>
			<option value="option 2 value">en(option 2 content)</option>
			<option label="en(option 3 label)">en(option 3 content)</option>
		</optgroup>
	</select>
	<button value="button value">en(button content)</button>
</div>
</form>