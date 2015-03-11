
<?php 
/*
    grpInfo.php  ** grpInfo controller **
     
    copyright 2015 Robert Clark(aka ebobtron), et al.
  
    an expansion of my edX.org CS50x final project
    winter/spring 2014  with Launch Code
    
    ******************************************************/
    
    require('../include/helfun.php');
    
    $group = 'edx2015';
    
    $title = 'Group Info';                             //$titleString[$group];
    $link = $linkString[$group];
        
    // render header
    require('../template/header.php');

    // render template
    require('../template/groupInfo.php');

    // render footer
    require('../template/footer.php');
    
    
    // last edited: 03/11/2015  ebt

?>
