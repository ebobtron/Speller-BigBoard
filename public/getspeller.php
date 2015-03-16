<?php
/*
*   getspeller.php  ** submission controller for uploading file **
* 
*   Robert Clark, aka ebobtron et al.
*
*   an expansion of my CS50x final project
*   winter/spring 2014  with Launch Code
***********************************************************************/

    require '../include/helfun.php';

    $error = false;
    
    $director = false;

    $email = null;
    $name = null;
    
    if(isset($_POST['email']))
    {
        $email = saniTizeEmail($_POST['email']);
        $email = validEmail($email);
    }
    
    if(isset($_POST['name']))
    {
        $name = validName(saniTize($_POST['name']));
    }

    // set grp number based on last group user chose
    if(isset($_COOKIE['leaderboard_cookie']))
    {    
        $group = saniTize($_COOKIE['leaderboard_cookie']);
    }
    else
    {    
        // skip the alert the second time though
        if(isset($_GET['con']) || saniTize($_POST['director']) == true )
        {    
            $director = true;
        }
        else
        {    
            header("Location: alert?gsnc=yes");
            //exit;
        }
    }
        
    if($group === null)
    {    
        $group = $defaultString;
    }
    
    $title = $titleString[$group];
    $head = $headString[$group];
    $link = $linkString[$group];
    
    $subcount = subCount($name, getGroupNumber($group)); 
     
    $validSubMsg = null;
    $magWrd = null;
    $submit = null;
    
    if(!array_key_exists('magword', $_POST))
    {    
        $_POST = array('magword' => null, 'submit' => null);
    }
    else
    {    
        $magWrd = saniTize($_POST['magword']);
        $submit = saniTize($_POST['submit']);
    }

    // now this is a little nutty  
    if($magWrd === $magicword_2)
    {    
        $magWrd = $magicword;
    }

    if($magWrd !== $magicword || !$name || !$email)
    {
        if(!$email && $submit)
        {       
            $validSubMsg = "alert('Submission needs a valid email address');" .
                           "javascript:history.go(-1);";
        }        

        if(!$name && $submit)
        {
            $validSubMsg = "alert('Submission needs a name');" .
                           "javascript:history.go(-1);";
        }
                
        if($magWrd != "launchcode" && $submit)
        {
            $validSubMsg = "alert('You must use a Magic Word. Check the referring web" .
                           "page for the correct Magic Word.');" .
                           "javascript:history.go(-1);";
        }

        // something missing stay on the getspeller form but pop a b box

        // render header
        require('../template/header.php');
    
        // render template
        require('../template/getspellerform.html');

        // render footer
        require('../template/footer.php');
        
        
        // pop the b box only when $validSubMsg contains a Message
        // else the empty script is an HTML 5 error
        if($validSubMsg)
        {
            echo '<script type="text/javascript">'.$validSubMsg.'</script>';
        }
    }
    else
    {
        // good magicword, valid email address and name continue submission
        
        $email = saniTizeEmail($_POST['email']);

        // render header
        require('../template/header.php');
             
        // render template
        require('../template/submitform.php');

        // render footer
        require('../template/footer.php');	
    }
    
    // last edited:  03/11/2015  ebt
?>

