
<?php
/***
*
*   show.php  leader board table view controller 
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
    $template = "table_all.php";
       
    // get array of keys for titleString array
    // keys to array elements are numeric
    $keys = array_keys($titleString);
    
    // check if group to display is pasted in the url
    if(isset($_GET['grp'])) {
        
        // assign get to $grpNumber for clarity
        $grpNumber = saniTize($_GET['grp']);
        
        if($grpNumber == 0) {
            
            $group = null;
        }
        else {

            // prevent bogus grpNumber
            if(isset($keys[$grpNumber])) {
                
                $group = $keys[$grpNumber];
            }
            else {
                
                $group = null;
            }
        }
    }
    else {
        // if group not pasted in url check cookie 
        // if cookie exist, set group based on cookie data
        if(isset($_COOKIE['leaderboard_cookie'])) {
            
            $group = $_COOKIE['leaderboard_cookie'];

            if(!array_key_exists($group, $titleString)) {
                $group = null;
            } 
            
        }
        // else, redirect to table showing all groups times
        else {
           
            $group = null;
        }
    }
    
    // tell the user which group they are looking at
    if($group !== null) {
        
        $title = $titleString[$group];
        $head = $headString[$group];
        $link = $linkString[$group];
        $template = "table.php"; 
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

