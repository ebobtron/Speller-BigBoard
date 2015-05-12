<!--
*
*   table.php  ** Display table of submissions and links **
*
*   copyright 2015 Robert Clark(aka ebobtron), et al.
*
*   an expansion of my edX.org CS50x final project
*   winter/spring 2014  with Launch Code
************************************************************   -->

<div class="div-table">
  
  <form action="" method="post">
  <div style="width:98.6%"> 
  <h4 style="margin:0px">all times are fastest average seconds</h4>
  <div class="div-col b" style="width:6%">id</div>
  
  <div class="div-col left smaller" style="width:22%">
    <input type="submit" name="head" value="name"
           class="headset b" title="sort" /><?= $nmark ?></div>
  
  <div class="div-col smaller" style="width:9%">
    <input type="submit" name="head" value="total"
           class="headset b" title="sort"/><?= $tmark ?></div>
           
  <div class="div-col smaller" style="width:9%">
    <input type="submit" name="head" value="load"
           class="headset b" title="sort" /><?= $lmark ?></div>
  
  <div class="div-col smaller" style="width:9%">
    <input type="submit" name="head" value="check"
           class="headset b" title="sort" /><?= $cmark ?></div>
  
  <div class="div-col b" style="width:9%">size</div>
  <div class="div-col b" style="width:9%">unload</div>
  <div class="div-col b" style="width:12%">heap</div>
  <div class="div-col b left" style="width:13%">&nbsp;&nbsp;&nbsp;type</div> 
  </div>
  <input type="hidden" name="form" value="0" />
  <input type="hidden" name="nsort" value="<?= $nsort ?>" />
  <input type="hidden" name="tsort" value="<?= $tsort ?>" />
  <input type="hidden" name="lsort" value="<?= $lsort ?>" />
  <input type="hidden" name="csort" value="<?= $csort ?>" />
  
  </form>
  
  <!-- 
  
  
  
  the clear:both stops the following elements from wrapping around
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

    <div class="div-col <?=$class?>" style="width:6%">
        <?  printf('%04d', $row['id'])?></div>

    <div class="div-col <?=$class?> left" style="width:22%">
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
<!--      // last edit: 05/12/2015  ebt        -->
