<!--

     table_db.php   Display table of submissions and links 

     copyright 2015 Robert Clark(aka ebobtron), et al.

     an expansion of my edX.org CS50x final project
     winter/spring 2014  with Launch Code                            -->

<h4 class="tc" style="margin:auto;">
      all times are fastest average seconds
</h4>

<div class="todheader">
  
  <form action="show" method="post">
      
      <div class="flt" style="width:6%">
        <input type="button" name="head" value="id" 
               class="" title="" /></div>
  
      <div class="flt" style="width:22%">
        <input type="submit" name="head" value="name"
               class="" title="click to sort by name" /><?= $nmark ?></div>
  
      <div class="flt" style="width:9%">
        <input type="submit" name="head" value="total"
               class="" title="click to sort by total time" /><?= $tmark ?></div>
           
      <div class="flt" style="width:9%">
        <input type="submit" name="head" value="load"
               class="" title="click to sort by load time" /><?= $lmark ?></div>
  
      <div class="flt" style="width:9%">
        <input type="submit" name="head" value="check"
               class="" title="click to sort by check time" /><?= $cmark ?></div>
  
      <div class="flt" style="width:9%">
        <input type="button" name="head" value="size" 
               class="" title="" /></div>
               
      <div class="flt" style="width:9%">
        <input type="button" name="head" value="unload" 
               class="" title="" /></div>
               
      <div class="flt" style="width:12%">
        <input type="button" name="head" value="heap" 
               class="" title="" /></div>

      <div class="lst flt" style="width: calc(13% + 2px);">
        <input type="button" name="head" value="type" 
               class="" title="" /></div> 


      <input type="hidden" name="form" value="0" />
      <input type="hidden" name="nsort" value="<?= $nsort ?>" />
      <input type="hidden" name="tsort" value="<?= $tsort ?>" />
      <input type="hidden" name="lsort" value="<?= $lsort ?>" />
      <input type="hidden" name="csort" value="<?= $csort ?>" />
    
  </form>
    
  <!-- the style for the following div "clear:both" stops the following elements from
       wrapping around the last div above the efect is a new line   -->
  <div class="clear"></div>
  
</div>

<div class="todbody">

    <? $loop = 0; ?>
    <? $class = null; ?>     
    <? foreach($rows as $row): ?>
    <? if($loop % 2 == 0): ?>
      <? $class = 'even'; ?> 
    <? else: ?>
      <? $class = null; ?>
    <? endif; ?>

    <div class="<?=$class?>" style="width: calc(6% + 1px);">
        <?  printf('%04d', $row['id'])?></div>

    <div class="<?=$class?> left" style="width: calc(22% + 4px)">
      <a href="comment?comment=<?=$row['name']?>" class="name"
         title="click for user comments or reddit overview">&nbsp;
         <?=$row['name']?></a></div>

    <div class="<?=$class?>" style="width: calc(9% + 1px);">
        <? printf('%0.4f', $row['total']) ?></div>

    <div class="<?=$class?>" style="width: calc(9% + 1px);">
        <? printf('%0.4f', $row['dload']) ?></div>

    <div class="<?=$class?>" style="width: calc(9% + 1px);">
        <? printf('%0.4f', $row['tcheck']) ?></div>

    <div class="<?=$class?>" style="width: calc(9% + 2px);">
        <? printf('%0.4f', $row['size']) ?></div>

    <div class="<?=$class?>" style="width: calc(9% + 2px);">
        <? printf('%0.4f', $row['unload']) ?></div>

    <div class="<?=$class?> right" style="width: calc(12% - 3px); padding-right:6px;">
        <? printf('%0.4f MB', $row['mem']) ?></div>

    <div class="<?=$class?> left" style="width: calc(12% - 8px);padding-left:8px">
        <?=$row['typ']?></div>

    <div class="clear"></div>

    <?  $loop++;
        endforeach; ?>

</div>
<br />

