
<?php
/***$_POST['group']
*
*   uploadfile.php  manage the uploaded file
*
*   Robert Clark, aka ebobtron et al.
*
*   An expansion of my 
*   CS50x final project   winter/spring 2014  with Launch Code
*
*************************************************************/

    require "../include/helfun.php";
    
    $dirString = "../uploading/";
    
    if(file_exists("../minis/alt_load.txt")) {
        
        $dirString = "../uploading_alt/";
    }
    
    if($_FILES['uploadedfile']['name'] !== "speller") {
       
       $message = "bogus or corupted file submission \"".
                  $_FILES['uploadedfile']['name'].
                  "\" plesse submit the file \"speller\" again.";
       $message = $message . "<br><br><b>No file submission.</b>";          
    }
    else {
    
        $group = $_POST['group'];
    
        $title = $titleString[$group];
        $head = $headString[$group];
        $link = $linkString[$group];
     
        #error_reporting(E_ALL);
    
        // build the target path string and some useful other strings
        $submissionNameGp = $_POST['name'] . getGroupNumber($group);
        $fileName = basename($_FILES['uploadedfile']['name']);
    
        $target_path = $dirString . $submissionNameGp;
        $target_path = $target_path . $fileName . ".x"; 
    
        // if file is is up move to defined folder
        $success = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
    
        // if successful and if not
        if($success) {

            // create subinfo file for automation
            createSubInfo($_POST['name'], getGroupNumber($group), $_POST['email'],
                               $dirString);
        
            // build message and email strings
            $message = "The file \" " . basename($_FILES['uploadedfile']['name']);
            $message = $message . " \" has been uploaded <br> for submitter: \" ";
            $message = $message . $_POST['name'] . " \" - group: " . $title . "<br>";
            $message = $message . "<br><b>Submission may take several hours before ".
                                  "posting.</b><br><br>";
            $message = $message . "for questions contact the administrator <a href=\"";
            $message = $message . "mailto:ebobtron@aol.com\">mailto:ebobtron@aol.com</a>".
                                  "<br>";
        
            $emailBody = "Received a submission from:  " . $_POST['name'] . " @ ";
            $emailBody = $emailBody . $_POST['email'];
        
        
            // and results to message and email
            $message = $message . "<br>" . $result;
            $emailBody = $emailBody . "\r\n" . $result;
        
        }
        else {

            $message = "There was an error uploading the file, please try again, later.<br>";
            $message = $message . "for questions contact the <a href=\"";
            $message = $message . "mailto:ebobtron@aol.com\">".
                                  "Leader Board Administrator</a><br>";
        
            $emailBody = "a submission failed to upload from:  ";
            $emailBody = $emailBody . $_POST['name'] . " @ " . $_POST['email'];
        }

        $mr = sendMail("ebobtron@aol.com", "erobclark@att.net",
                        "Leader Board Submission", $emailBody);
        $message = $message . $mr;
    }

    // render header
    require("../template/header.php");

    // render body
    require("../template/uploadResults.php");

    // render footer
    require("../template/footer.php");

?>
