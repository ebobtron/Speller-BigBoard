

<?php

	require_once "../include/helfun.php";
	
	// comment time
 

	$template = "gettest.html";
	     
		        // render header
            require("../template/header.php");

            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php");
						
						
?>

