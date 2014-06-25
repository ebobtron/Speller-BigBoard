<?php 
    
    require "../include/helfun.php";
    
    $keys = array_keys($titleString);
    
    $title = $titleString[$keys[1]];
    $head = $headString[$keys[1]];
    $link = $linkString[$keys[1]];
    
    $template = "aboutus_view.php"; 
        
        // render header
        require("../template/header.php");

        // render template
        require("../template/$template");

        // render footer
        require("../template/footer.php");

?>