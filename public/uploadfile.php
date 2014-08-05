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

    error_reporting(0); // E_ALL | 0
    
    // require common helper functions
    require '../include/helfun.php';
    
    // alerts user about the need for a data structure type
    if(saniTize($_POST['type']) == 0)
    {    
        header('Location: alert.php?type=no');
        exit;   
    }
    // default upload directory on website
    $dirString = '../uploading/';
    
    // define a duplicate submission flag
    $dupSub = false;

    // use alternate upload directory during automation
    if(file_exists('../minis/alt_load.txt'))
    {
        $dirString = '../uploading_alt/';
    }
    
    // if speller absent(null) or the wrong file name alert user
    if($_FILES['uploadedfile']['name'] !== 'speller')
    {
        $message =
        'missing, bogus or corupted file submission " '. 
        $_FILES['uploadedfile']['name'] .
        ' " please submit the file " speller " again.'.
        '<br /><br /><b>No file submission.</b>';
    }
    else
    {
        // sanitize the passed data
        $group = saniTize($_POST['group']);

        // get the page header strings to make the page pretty
        $title = $titleString[$group];
        $head = $headString[$group];
        $link = $linkString[$group];

        // sanitize critical data passed from form
        $name = saniTize($_POST['name']);
        $email = validEmail($_POST['email']);

        // build the submission file name from  name, group number, and type
        $submissionNameGrpTyp = $name . getGroupNumber($group) . '-' . $_POST['type'];
        
        // get uploaded file from system data
        $fileName = basename($_FILES['uploadedfile']['name']);
        
        // build the target path string 
        $target_path = $dirString . $submissionNameGrpTyp . $fileName . '.x' ;
        
        // search for duplicate subbmissions by name
        $files = glob($dirString.'*');
        foreach($files as $file)
        {
            if(strpos($file, $name))
            {
                $dupSub = true;
            }
        }
        
        // if duplicate name in local submissions folder alert user
        if($dupSub)
        {    
            header('Location: alert.php?dupSub=yes');
            exit;
        }

        // if file is up move to defined folder
        $success = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
        
        $dateTimeString = date("l F j, Y @ g:i:s a T");
        
        // if successful and if not
        if($success)
        {    
            // create a group - type variable
            $grp_type = getGroupNumber($group) . '-' . $_POST['type'];
             
            // create submission information file for automation
            createSubInfo($name, $grp_type, $email, $dirString);

            // build page display message for user submission 
            // note double quotes to parse variable into string
            $message = 
            "The file \" $fileName  \" has been uploaded<br />".
            "for submitter: $name &nbsp; group: $title <br />".
            '<br />'.
            '<b>The submission may take several hours to post.</b><br />'.
            '<br />'.
            'for questions contact the '.
            '<a href="mailto:ebobtron@aol.com" class="head-links" style="font-size:1.3em">'.
            'administrator</a><br /><br />';
            
            // build email message string note double quotes to parse the variables
            // into the string.
            $emailBody = 
            "Received a submission from: $name  Group: $title  Contact: $email on: ".
            "$dateTimeString \r\n";
            
            // open log file for appending
            $outFileHandle = fopen('../logs/submission.log', 'a');
        
            // write message to file
            fwrite($outFileHandle, $emailBody);
        
            // if outFileHandle good close the file
            if($outFileHandle)
            { 
                fclose($outFileHandle);
            }
                         
        }
        else
        {
            // built submission faile message using single quotes
            $message =
            'There was an error uploading the file, please try again, later.<br />'.
            'for questions contact the '.
            '<a href="mailto:ebobtron@aol.com" class="head-links" style="font-size:1.3em">'.
            'Leader Board Administrator</a><br />';

            // build the email message using double quotes to parse the variables
            $emailBody =
            "a submission failed to upload from: $name  @  $email - $dateTimeString";
        }
        
        // send email message
        $mr = sendMail("ebobtron@aol.com", "erobclark@att.net", "Leader BoardSubmission",
                        $emailBody);
        
        // add email message to page display message if there is one
        $message = $message . $mr;
    }

    // render the page
    
    // render header
    require('../template/header.php');

    // render body
    require('../template/uploadResults.php');
    
    // render footer
    require('../template/footer.php');

?>
