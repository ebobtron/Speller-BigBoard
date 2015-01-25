<?php 
/**
  * 404.php   -- not found --
  *
  * copyright 2015 Robert Clark aka ebobtron, et al.
  *
  * an expansion of my edX.org 
  * CS50x final project winter/spring 2014  with Launch Code
  *
  ***************************************************************/
  
    $body = "<div class='gentext'><br />".
            "<h2>Sorry your request could not be found.</h2>".
            "<br /></div>"; 
  
    require("../template/header.php");

    echo $body;

    require("../template/footer.php"); 
    
    // last edit: 01/24/2015 ebt  
?>