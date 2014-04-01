<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>Process Uploaded File</title>
</head>
<body>

<?php
 require_once "include/helfun.php";

 $target_path = "uploading/" . $_POST['name'];

 $target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
 
 if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path))
 {
   echo "The file ". basename( $_FILES['uploadedfile']['name']). 
    " has been uploaded";
 }
 else
 {
   echo "There was an error uploading the file, please try again!";
 }
 /**/
 echo  "<br>",$_POST['name'];
 $body = "a submission from:  " . $_POST['name'] . " @ " . $_POST['email'];
 sendMail("ebobtron@aol.com", "erobclark@att.net", "CS50x Submission", $body);
?>
</body>
</html>
