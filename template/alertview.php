

<div class="gentext">

    <?=$mesString?><br />
    <p class="center">
    <a href="show.php" class="head-links" style="font-size:19px">
       back to leader board</a>
    
    <?php if($contarget !== null): ?>
       
       &nbsp;&nbsp;&nbsp;...&nbsp;&nbsp;&nbsp; 
    
    <a href="<?=$contarget?>" class="head-links" style="font-size:22px">
       continue with submission</a>
    
    <?php else: ?>
      &nbsp;
    <?php endif ?>
       
    </p>   
    <br />
    <br />
</div>
