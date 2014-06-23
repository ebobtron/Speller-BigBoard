
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

    error_reporting(0);  // E_ALL | E_STRICT
    
    require "../include/helfun.php";
    
    // set default table
    $template = "table.php";
       
    // get array of keys for titleString array
    // keys to array elements are numeric
    $keys = array_keys($titleString);
    
    // check if group to display is pasted in the url
    if(isset($_GET['grp'])) {
    
        if($_GET['grp'] == 0) {
            
            $group = null;
            $template = "table_all.php";            
        }
        else {
             
            $group = $keys[$_GET['grp']];
        }
    }
    else {
        // if group not pasted in url check cookie 
        // if cookie exist, set group based on cookie data
        if(isset($_COOKIE['leaderboard_cookie'])) {
            
            $group = $_COOKIE['leaderboard_cookie'];
        }
        // else, redirect to table showing all groups times
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

