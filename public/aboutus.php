<?php
/**
  * aboutus.php   -- about us controler  --
  *
  * copyright 2015 Robert Clark(aka ebobtron) et al.
  *
  * an expansion of my edX.org 
  * CS50x final project winter/spring 2014  with Launch Code
  *
  ***************************************************************/

    require '../include/helfun.php';
    
    // get group keys from tileString array
    $keys = array_keys($titleString);
    
    // set the group description strings for this page
    $title = $titleString[$keys[1]];
    $head = $headString[$keys[1]];
    $link = $linkString[$keys[1]];
 
    // render header
    require('../template/header.php');

    // render template
    require('../template/aboutus_view.php');

    // render footer
    require('../template/footer.php');
    
    // last edit: 01/24/2015  ebt
?>
