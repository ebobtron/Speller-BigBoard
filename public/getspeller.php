
<?php 
	
	require_once "../include/helfun.php";
  
	if ($_POST['magword'] != "launchcode")
	{
		// if not magicword stay on the page.
 
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
		
		// good magicword continue submission
		
		// get nextID
		$nextID = get("nextID");
		
		echo $nextID;
				  
		$template = "submitform.php";
	     
		        // render header
            require("../template/header.php");

            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php");	
	}
	
	
	?>
	