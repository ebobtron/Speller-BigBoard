
<?php
/*
 *  update.php  leader board writen by Robert Clark et al. 2014
 *************************************************************/
 
 // this is an administration file not seen buy the public.
 
    error_reporting(E_ALL); // E_ALL
    
    require_once "../include/helfun.php";

    // render header
    require("../template/header.php");
    
        // the body of the page
    
        echo"<div class='admin'><h3>admin: update submission data</h3>";
    
        // .php?data=yes
    
        if(!array_key_exists('data', $_GET)) {
        
            $_GET = array('data' => null);
        }
    
        if(saniTize($_GET['data']) === "yes") {
    
            if($results = updateData("")) {
                
                if($results !== true) {
                    
                    echo $results;
                }
                sendemailNotifications("test");
            }
        }
        else { 
            
            echo "No Data!";
        }

        echo"</div>";

    // render footer
    require("../template/footer.php");

?>
