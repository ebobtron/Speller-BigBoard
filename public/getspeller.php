
<?php
/**
 *
 *   getspeller.php  submission controller for uploading file
 * 
 *   Robert Clark, aka ebobtron et al.
 *
 *  an expension of my 
 *  CS50x final project   winter/spring 2014  with Launch Code
 *
 ***************************************************************/

    require "../include/helfun.php";

    $error = false;
    
    $director = false;

    $email = validEmail(($_POST['email']));
    $name = validName(saniTize($_POST['name']));

    // set grp number based on last group user chose
    if(isset($_COOKIE['leaderboard_cookie'])) {
        
        $group = $_COOKIE['leaderboard_cookie'];
    }
    else {
        
        // skip the alert the second time though
        if(isset($_GET['con']) || saniTize($_POST['director']) == true ) {
            
            $director = true;
        }
        else {
            
            header("Location:"."alert.php?gsnc=yes");
            //exit;
        }
    }
        
    if($group === null) {
        
        $group = $defaultString;
    }
    
    $title = $titleString[$group];
    $head = $headString[$group];
    $link = $linkString[$group]; 
     
    $validSubMsg = null;
    
    if(!array_key_exists('magword', $_POST)) {
        
        $_POST = array('magword' => null, 'submit' => null);
    }
    else {
        
        $magWrd = saniTize($_POST['magword']);
        $submit = saniTize($_POST['submit']);
    }

    // now this is a little nutty  
    if($magWrd === $magicword_2) {
        
        $magWrd = $magicword;
    }

    if($magWrd !== $magicword || !$name || !$email) {

        if(!$email && $submit) {
            
            $validSubMsg = "alert('Submission needs an email address: ');" .
                           "javascript:history.go(-1);";
        }        

        if(!$name && $submit) {
        
            $validSubMsg = "alert('Submission needs a name: ');" .
                           "javascript:history.go(-1);";
        }
                
        if($magWrd != "launchcode" && $submit) {
        
            $validSubMsg = "alert('You must use a Magic Word. Check the referring web" .
                           "page for the correct Magic Word.');" .
                           "javascript:history.go(-1);";
        }

        // if no magicword stay on the getspeller form
        $template = "getspellerform.html";

            // render header
            require("../template/header.php");
        
            echo "<script type='text/javascript'>",$validSubMsg,"</script>";
    
            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php");
    }
    else {

        // good magicword and valid email address and name continue submission
        
        $email = $_POST['email'];

        $template = "submitform.php";

        // render header
        require("../template/header.php");
             
        // render template
        require("../template/$template");

        // render footer
        require("../template/footer.php");	
    }

?>

