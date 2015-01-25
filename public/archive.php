<?php
/**
  * archive.php  -- archive controller --
  *
  * copyright 2015 Robert Clark(aka ebobtron), et al.
  *
  * an expansion of my edX.org 
  * CS50x final project winter/spring 2014  with Launch Code
  *
  ***************************************************************/ 

    error_reporting(0); // E_ALL | 0
    
    # require('../include/helfun.php');
   
    // render the archive page
    
    include('../template/header.php');
       
        if(!include('../template/archive.php'))
        {
            include('../template/construction.php');
        }
        
    include('../template/footer.php');
    
    // last edit: 01/24/2015  ebt
?>
