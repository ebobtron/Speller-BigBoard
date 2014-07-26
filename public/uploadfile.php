
<?php
/*
 *   uploadfile.php  manage the uploaded file
 *
 *   Robert Clark, aka ebobtron et al.
 *
 *   An expansion of my 
 *   CS50x final project   winter/spring 2014  with Launch Code
 *
 ***************************************************************/

    error_reporting(0); // E_ALL
    
    if($_POST['type'] == 0){
        
        header("Location:"."alert.php?type=no");
        exit;   
    }
    
    require "../include/helfun.php";

    $dirString = "../uploading/";

    if(file_exists("../minis/alt_load.txt")) {

        $dirString = "../uploading_alt/";
    }

    if($_FILES['uploadedfile']['name'] !== "speller") {

       $message = "bogus or corupted file submission \"".
                  $_FILES['uploadedfile']['name'].
                  "\" plesse submit the file \"speller\" again.";
       $message = $message . "<br /><br /><b>No file submission.</b>";          
    }
    else {

        $group = saniTize($_POST['group']);

        $title = $titleString[$group];
        $head = $headString[$group];
        $link = $linkString[$group];

        $name = saniTize($_POST['name']);
        $email = validEmail($_POST['email']);

        // build the target path string and some useful other strings
        $submissionNameGp = $name . getGroupNumber($group) . '-' . $_POST['type'];
        $fileName = basename($_FILES['uploadedfile']['name']);

        $target_path = $dirString . $submissionNameGp;
        $target_path = $target_path . $fileName . ".x";
        
        if(file_exists($target_path)){
            
            header("Location:"."alert.php?dupSub=yes");
            exit;
        }

        // if file is is up move to defined folder
        $success = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
        
        // if successful and if not
        if($success) {
            
            $grp_type = getGroupNumber($group) . '-' . $_POST['type']; 
            // create subinfo file for automation
            createSubInfo($name, $grp_type, $email, $dirString);

            // build message and email strings
            $message = "The file \" " . basename($_FILES['uploadedfile']['name']);
            $message = $message . " \" has been uploaded <br /> for submitter: \" ";
            $message = $message . $name . " \" - group: " . $title . "<br />";
            $message = $message . "<br /><b>Submission may take several hours before ".
                                  "posting.</b><br /><br />";
            $message = $message . "for questions contact the administrator <a href=\"";
            $message = $message . "mailto:ebobtron@aol.com\">mailto:ebobtron@aol.com</a>".
                                  "<br /><br />";

            $emailBody = "Received a submission from:  " . $name .
                         "  Group:  ". $title . "  Contact:  " . $email . "\r\n";

        }
        else {

            $message = "There was an error uploading the file, please try again, " .
                       "later.<br />";
            $message = $message . "for questions contact the <a href=\"";
            $message = $message . "mailto:ebobtron@aol.com\">".
                                  "Leader Board Administrator</a><br />";

            $emailBody = "a submission failed to upload from:  ";
            $emailBody = $emailBody . $name . " @ " . $email;
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
