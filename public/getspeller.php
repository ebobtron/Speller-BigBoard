
<?php 
	
	require_once "../include/helfun.php";
  
	if ($_POST['magword'] != "launchcode")
	{
	   
	
		// comment time
 
		$template = "getspellerform.html";
	     
		        // render header
            require("../template/header.php");

            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php");
	}
	else
	{
		
		$template = "submitform.php";
	     
		        // render header
            require("../template/header.php");

            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php");	
	}
	
	
	?>
	