
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
    
    // Check if cookie contains group value
    // if cookie exist, set group var based on cookie data
    if (isset($_COOKIE['leaderboard_cookie'])) {
        
        $group = $_COOKIE['leaderboard_cookie'];
        $template = "table.php";
    }
    // else, redirect to group selection page
    else {
           
        $group = null;
        $template = "table_all.php";
        
        #header("Location:".
        #"http://".$_SERVER["HTTP_HOST"].dirname($_SERVER["PHP_SELF"])."/grpsel.php");
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

            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php");


?>

