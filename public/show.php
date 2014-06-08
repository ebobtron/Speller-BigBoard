
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

    require "../include/helfun.php";

    // Check if cookie contains group value
    // if cookie exist, set group var based on cookie data
    if (isset($_COOKIE['leaderboard_cookie'])) {
        $group = $_COOKIE['leaderboard_cookie'];
    }
    // else, redirect to group selection page
    else {
        header("Location: http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/grpsel.php");
    }
    
    // tell the user which group they are looking at
    $title = $titleString[$group];
    $head = $headString[$group];
    $link = $linkString[$group];
    

    // get table rows from display
    $rows = getPut("rows", getGroupNumber($group));

    $template = "table.php";

            // render header
            require("../template/header.php");

            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php");


?>

