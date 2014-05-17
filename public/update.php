

<?php
    //error_reporting(E_ALL);
    require_once "../include/helfun.php";
		
    // render header
    require("../template/header.php");
    
    // the body of the page
    {
        echo"<div class='admin'><h2>admin: update submission data</h2>";
    
        // .php?data=yes
    
        if(!array_key_exists('data', $_GET)) {
        
            $_GET = array('data' => null);
        }
    
        if($_GET['data'] == "yes") {
    
            updateData("");
            sendemailNotifications("test");
        }
        else { 
            
            echo "No Data!";
        }
        
        echo"</div>";
    }
	
  	// render footer
    require("../template/footer.php");
 
?>

