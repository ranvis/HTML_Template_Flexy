

<h2>Looping</h2>


<p>a loop <?php if (is_array($t->loop)  || is_object($t->loop)) foreach($t->loop as $a) {?> <?php echo htmlspecialchars($a);?> <?php }?></p>
<p>a loop with 2 vars <?php if (is_array($t->loop)  || is_object($t->loop)) foreach($t->loop as $a => $b) {?> 
    <?php echo htmlspecialchars($a);?> , 
    <?php echo htmlspecialchars($b);?>
<?php }?></p>

Bug #84
<?php if (is_array($t->list)  || is_object($t->list)) foreach($t->list as $i) {?>
  <?php if (isset($t) && method_exists($t,'method')) echo htmlspecialchars($t->method($i));?>
<?php }?>

<?php if (is_array($t->list)  || is_object($t->list)) foreach($t->list as $i => $j) {?>
    <?php echo htmlspecialchars($i);?>:<?php echo htmlspecialchars($j);?>
<?php }?>

<table>
    <?php if (is_array($t->xyz)  || is_object($t->xyz)) foreach($t->xyz as $abcd => $def) {?><tr>
        <td><?php echo htmlspecialchars($abcd);?>, <?php if (isset($t) && method_exists($t,'test')) echo htmlspecialchars($t->test($def));?></td>
    </tr><?php }?>
</table>


<h2>HTML tags example using foreach=&quot;loop,a,b&quot; or the tr</h2>
<table width="100%" border="0">
  <?php if (is_array($t->loop)  || is_object($t->loop)) foreach($t->loop as $a => $b) {?><tr> 
    <td><?php echo htmlspecialchars($a);?></td>
    <td><?php echo htmlspecialchars($b);?></td>
  </tr><?php }?>
</table>

<h2>HTML tags example using foreach=&quot;loop,a&quot; or the tr using a highlight class.</h2>
<table width="100%" border="0">
  <?php if (is_array($t->loop)  || is_object($t->loop)) foreach($t->loop as $a) {?><tr class="<?php echo htmlspecialchars($a->hightlight);?>"> 
    <td>a is</td>
    <?php if ($a->showtext)  {?><td><?php echo htmlspecialchars($a->text);?></td><?php }?>
    <?php if (!$a->showtext)  {?><td><?php echo number_format($a->price,2,'.',',');?></td><?php }?>
  </tr><?php }?>
</table>
