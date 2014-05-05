
<?php
/***
*
*   uploadfile.php  manage the uploaded file
*
*   Robert Clark, aka ebobtron
*   CS50x final project   winter/spring 2014  with Launch Code
*
*************************************************************/

    
    require "../include/config.php";
    require "../include/helfun.php";
     
    //error_reporting(E_ALL);
    
    // build the target path string and some useful others
    $submissionNameId = $_POST['name'] . $_POST['id'];
    $fileName = basename($_FILES['uploadedfile']['name']);
    
    $target_path = "../uploading/" . $submissionNameId;
    $target_path = $target_path . $fileName . ".x"; 
    
    // if file is is up move to defined folder
    $success = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
    
    // if successful and if not
    if($success) {

        // build message and email strings
        createSubInfo($_POST['name'], $_POST['id'], $_POST['email']);
        $message = "The file \" " . basename($_FILES['uploadedfile']['name']);
        $message = $message . " \" has been uploaded for submitter: \" ";
        $message = $message . $_POST['name'] . " \" - id: " . $_POST['id'] . "<br>";
        $message = $message . "Submission may take several hours before posting.<br><br>";
        $message = $message . "for questions contact the administrator <a href=\"";
        $message = $message . "mailto:ebobtron@aol.com\">mailto:ebobtron@aol.com</a><br>";
        
        $emailBody = "Received a submission from:  " . $_POST['name'] . " @ ";
        $emailBody = $emailBody . $_POST['email'];
        
        // log submission to database
        $result = getPut("addSub",$_POST);
        
        // and results to message and email
        $message = $message . "<br>" . $result;
        $emailBody = $emailBody . "\r\n" . $result;
        
    }
    else {

        $message = "There was an error uploading the file, please try again, later.<br>";
        $message = $message . "for questions contact the administrator <a href=\"";
        $message = $message . "mailto:ebobtron@aol.com\">mailto:ebobtron@aol.com</a><br>";
        $emailBody = "a submission failed to upload from:  ";
        $emailBody = $emailBody . $_POST['name'] . " @ " . $_POST['email'];
    }

    $mr = sendMail("ebobtron@aol.com", "erobclark@att.net",
                        "Leader Board Submission", $emailBody);
    $message = $message . $mr;

    // render header
    require("../template/header.php");

    // render body
    require("../template/uploadResults.php");

    // render footer
    require("../template/footer.php");

    //echo memory_get_peak_usage();

?>

