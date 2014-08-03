<?php
/*
 *
 *  grpsel.php  group selection controller
 *
 *  Robert Clark, aka ebobtron et al
 *
 *  An expansion of my
 *  CS50x final project   winter/spring 2014 with Launch Code
 *
 **************************************************************/

    error_reporting(E_ALL); // E_ALL

    require('../include/helfun.php');

    // default target value
    $target = 'sub';

    // cookie data name and experation time
    $cookie_name = 'leaderboard_cookie';
    $cookie_time = time() + (24 * 60 * 60 * 365); // about a year

    // if no request for group change
    if(!isset($_GET['chg']))
    {
        // check for cookie
        if(isset($_COOKIE[$cookie_name]))
        {    
            // this checks if the cookie is valid by seeing if cookie value is 
            // in $titleString
            if(array_key_exists($_COOKIE[$cookie_name], $titleString))
            {        
                // good cookie get speller
                header('Location: getspeller');
                #exit;
            }
            else
            {    
                // invalid cookie alert user
                header('Location: alert.php');
                #exit;
            }    
        }
    }
    else
    {    
        // if not change submission group change our default group
        if(saniTize($_GET['chg']) === "default")
        {
            // target changed from sub to change group
            $target = "chggrp";
        }
    }

    // if post has group key set cookie for the group selected
    if(isset($_POST['group']))
    {    
        $cookie_value = saniTize($_POST['group']);
        setcookie($cookie_name, $cookie_value, $cookie_time, '/');
        header('Location: '.
        'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/getspeller');
        #exit;
    }

    // if post has target key test and then redirect to show
    if(isset($_POST['target']))
    {
        //sanitize post data before use
        if(saniTize($_POST['target']) === "chggrp")
        {  
            header('Location: show');
            #exit;
        }
    }

    // render header
    require('../template/header.php');

    // render template
    require('../template/grpselform.php');

    // render footer
    require('../template/footer.php'); 

?>
