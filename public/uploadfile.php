

<?php
 require_once "../include/helfun.php";
		
    // render header
    require("../template/header.php");
 
 $target_path = "../uploading/" . $_POST['name'].$_POST['id'];

 $target_path = $target_path.basename($_FILES['uploadedfile']['name']).".x"; 
 
 if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
   
   echo "The file ". basename( $_FILES['uploadedfile']['name']). 
    " has been uploaded";
   $body = "a submission from:  " . $_POST['name'] . " @ " . $_POST['email'];
 }
 else {
   
   echo "There was an error uploading the file, please try again!";
   $body = "a submission failed to upload from:  " . $_POST['name'] . " @ " . $_POST['email'];
 }
 /**/
 echo  "<br>",$_POST['name'];
 
 sendMail("ebobtron@aol.com", "erobclark@att.net", "CS50x Submission", $body);

		// render footer
    require("../template/footer.php");
 
?>

