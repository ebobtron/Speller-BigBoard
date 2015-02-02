<!--
*
*   table.php  -- Display table of submissions and links --
*
*   copyright 2015 Robert Clark(aka ebobtron), et al.
*
*   an expansion of my edX.org CS50x final project
*   winter/spring 2014  with Launch Code
************************************************************   -->

<div class="div-table">

  <h4 style="margin:0px">all times in seconds</h4>
  <div class="div-col b" style="width:8%">id</div>
  <div class="div-col left b" style="width:20%">name</div>
  <div class="div-col b" style="width:9%">total</div>
  <div class="div-col b" style="width:9%">load</div>
  <div class="div-col b" style="width:9%">check</div>
  <div class="div-col b" style="width:9%">size</div>
  <div class="div-col b" style="width:9%">unload</div>
  <div class="div-col b" style="width:12%">heap</div>
  <div class="div-col b left" style="width:13%">&nbsp;&nbsp;&nbsp;type</div> 

  <!-- the clear:both stops the following elements from wrapping around
       the last div above the efect is a new line   -->
  <div style="clear:both;margin:0"></div>
</div>

<div class="d-sub">

    <? $loop = 0; ?>
    <? $class = null; ?>     
    <? foreach($rows as $row): ?>
    <? if($loop % 2 == 0): ?>
      <? $class = 'row'; ?> 
    <? else: ?>
      <? $class = null; ?>
    <? endif; ?>

    <div class="div-col <?=$class?>" style="width:8%">
        <?  printf('%04d', $row['id'])?></div>

    <div class="div-col <?=$class?> left" style="width:20%">
      <a href="comment?comment=<?=$row['name']?>" class="name"
         title="click for user comments or reddit overview">&nbsp;
         <?=$row['name']?></a></div>

    <div class="div-col <?=$class?>" style="width:9%">
        <? printf('%0.4f', $row['total']) ?></div>

    <div class="div-col <?=$class?>" style="width:9%">
        <? printf('%0.4f', $row['dload']) ?></div>

    <div class="div-col <?=$class?>" style="width:9%">
        <? printf('%0.4f', $row['tcheck']) ?></div>

    <div class="div-col <?=$class?>" style="width:9%">
        <? printf('%0.4f', $row['size']) ?></div>

    <div class="div-col <?=$class?>" style="width:9%">
        <? printf('%0.4f', $row['unload']) ?></div>

    <div class="div-col <?=$class?> right" style="width:12%">
        <? printf('%0.4f MB', $row['mem']) ?></div>

    <div class="div-col <?=$class?> left" style="width:13%">&nbsp;
        <?=$row['typ']?></div>

    <div style="clear:both"></div>

    <?  $loop++;
        endforeach; ?>

</div>
<br />
<!--    // last edit: 02/01/2015  ebt        -->
