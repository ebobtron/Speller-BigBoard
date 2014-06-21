
<?php
/***
*
*   show.php  leader board table view controler 
* 
*   Robert Clark, aka ebobtron et al.
*   
*   The expansion of my 
*   CS50x final project   winter/spring 2014 with Launch Code
*
***************************************************************/
    error_reporting(E_ALL);
    
    require "../include/helfun.php";
    
    // set default table
    $template = "table.php";   
    
    if(isset($_GET['grp'])) {
    
        if($_GET['grp'] == 0) {
            
            $group = null;
            $template = "table_all.php";            
        }
        else {
            
            $keys = array_keys($titleString);
            $group = $keys[$_GET['grp']];
        }
    }
    else {
        
        // Check if cookie contains group value
        // if cookie exist, set group var based on cookie data
        if(isset($_COOKIE['leaderboard_cookie'])) {
            
            $group = $_COOKIE['leaderboard_cookie'];
        }
        // else, redirect to group selection page
        else {
           
            $group = null;
            $template = "table_all.php";
        
        }
    }
    
    // tell the user which group they are looking at
    if($group !== null) {
        
        $title = $titleString[$group];
        $head = $headString[$group];
        $link = $linkString[$group];
    }
    
    $keys = array_keys($titleString);
    
    // get table rows from display
    $rows = getPut("rows", getGroupNumber($group));

            // render header
            require("../template/header.php");
            
            // render links
            require("../template/links.php");

            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php");


?>

