

<?php
 require_once "../include/helfun.php";
		
    // render header
    require("../template/header.php");
  
  echo"<div class='admin'><h2>admin: update submission data</h2>";
    
 
  updateData($_GET['dumb']);    


 
 //sendMail("ebobtron@aol.com", "erobclark@att.net", "CS50x Submission", $body);
  
  echo"</div>";
	
  	// render footer
    require("../template/footer.php");
 
?>

