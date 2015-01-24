<?php
/**
  * 403.php  -- forbidden  --
  *
  * copyright 2015 Robert Clark aka ebobtron, et al.
  *
  * an expansion of my edX.org 
  * CS50x final project winter/spring 2014  with Launch Code
  *
  ***************************************************************/
  
    $body = "<div class='gentext'>".
            "<h2> Sorry this is forbidden. &nbsp;Shame on you.</h2>".
            "</div>";     


    require("../template/header.php");
    
    echo $body;
    
    require("../template/footer.php");
 
    // last edit: 
?>
