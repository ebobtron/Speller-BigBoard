<!--
*
*   alertview.php  ** alert template to display alerts **
*
*   copyright 2015 Robert Clark(aka ebobtron), et al.
*
*   an expansion of my edX.org CS50x final project
*    winter/spring 2014  with Launch Code
********************************************************** -->  

<div class="gentext">

    <?= $mesString ?>
    <p class="center">
    
    <br /><br />

    <a href="show.php" class="head-links" style="font-size:19px">
       back to leader board</a>
    
    <?php if($conTarget != null): ?>
       
       &nbsp; &nbsp; &nbsp;...&nbsp; &nbsp; &nbsp; 
    
    <a href="<?= $conTarget ?>" class="head-links" style="font-size:22px">
       continue with submission</a>
    
    <?php else: ?>
      &nbsp;
    <?php endif ?>
       
    </p>   
    <br />
    <br />
</div>

<!--  last edit: 02/20/2015  ebt    -->