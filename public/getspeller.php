
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
		/*
		$qString = "SELECT row FROM leader_board".
		           " WHERE name = '".$_POST["name"].
							 "'";
		$row = myquery($qString);
		
		print($qString);
		
		print_r($row);
				 
		/*
		SELECT * FROM table WHERE id=(SELECT MAX(id) FROM TABLE 
		 */
		 
		 
		        $template = "submitform.php";
	     
		        // render header
            require("../template/header.php");

            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php");	
	}
	
	
	?>
	