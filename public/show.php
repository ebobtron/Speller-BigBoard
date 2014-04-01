

<?php

	require_once "../include/helfun.php";
	
	// comment time
	$dbh = opentable();
	$loop = 0;	
	$result = mysql_query("SELECT * FROM leader_board ORDER BY total ASC");
	if ($dbh)
	  mysql_close($dbh);	 

	$template = "table.php";
	     
		        // render header
            require("../template/header.php");

            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php");
						
						
?>

