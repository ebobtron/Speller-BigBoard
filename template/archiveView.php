<!--
     archiveView.php    archive View 

     copyright 2015 Robert Clark(aka ebobtron), et al.

     an expansion of my edX.org CS50x final project
     winter/spring 2014  with Launch Code                         -->

<div class="div-table lilmar">
    The tables below are the lists of submissions from last years CS50x offered by
    edX.org. &nbsp;There are three lists: all submissions, those from a study group
    sponsored in Saint Louis, Missouri U.S. by Launch Code and a general list of
    submissions from others taking the CS50x course online world wide.  
</div>

<div class="normar">
    <a name="pagetop" class="link"><?=$listshown?></a> &nbsp;
    | &nbsp;
    <a href="archive?grp=<?=$otherLinkOne?>" class="link"><?=$otherOne?></a> &nbsp;
    | &nbsp;
    <a href="archive?grp=<?=$otherLinkTwo?>" class="link"><?=$otherTwo?></a>
</div>

<div class="div-table">

  <h4 style="margin:0px">all times in seconds</h4>
  
  <div class="div-col left b" style="width:20%">&nbsp; &nbsp; name</div>
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

<div class="d-sub" style="height: calc(100% - 290px);">

    <? $loop = 0; ?>
    <? $class = null; ?>     
    <? foreach($rows as $row): ?>
    <? if($loop % 2 == 0): ?>
       <? $class = ' row'; ?> 
    <? else: ?>
       <? $class = null; ?>
    <? endif; ?>

    <div class="div-col<?=$class?> left" style="width:20%">
      <a href="comment?comment=<?=$row[0]?>" class="name"
         title="click for user comments or reddit overview">&nbsp;
         <?=$row[0]?></a></div>

    <div class="div-col<?=$class?>" style="width:9%">
        <? printf('%0.4f', $row[1]) ?></div>

    <div class="div-col<?=$class?>" style="width:9%">
        <? printf('%0.4f', $row[2]) ?></div>

    <div class="div-col<?=$class?>" style="width:9%">
        <? printf('%0.4f', $row[3]) ?></div>

    <div class="div-col<?=$class?>" style="width:9%">
        <? printf('%0.4f', $row[4]) ?></div>

    <div class="div-col<?=$class?>" style="width:9%">
        <? printf('%0.4f', $row[5]) ?></div>

    <div class="div-col<?=$class?> right" style="width:12%">
        <? printf('%0.4f MB', $row[6]) ?></div>

    <div class="div-col<?=$class?> left" style="width:13%">&nbsp;
        <?=$row[7]?></div>

    <div style="clear:both"></div>

    <?  $loop++;
        endforeach; ?>
</div>
<br />

