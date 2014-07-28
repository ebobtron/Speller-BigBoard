<?php
/**
 *  alert.php  leader board writen by Robert Clark et al. 2014
 *  see aboutus.php 
 *************************************************************/

    error_reporting(0); // E_ALL | 0
    
    require('../include/helfun.php');
    require('../include/alert_strings.php');
    
    // message string
    $mesString = 'no data';
    
    // continue target
    $conTarget = 'getspeller.php?con=yes';
    
    // check for valid cookie
    if(isset($_COOKIE['leaderboard_cookie']))
    {
        $group = $_COOKIE['leaderboard_cookie'];

        if(!array_key_exists($group, $titleString))
        {    
            $mesString = $badCookie;
            $conTarget = 'grpsel.php?chg=yes';
        }          
    }
    
    if(isset($_GET['gsnc']))
    {    
        $mesString = $noCookieSupport;
    }
    
    if(isset($_GET['dupSub']))
    {
        $mesString = $dupSubmission;
        $conTarget = null;            
    }
    
    if(isset($_GET['type']))
    {
        $mesString = $typeString;
        $conTarget = null;
    }
   
    // render the page
    
    include('../template/header.php');
        
    include('../template/alertview.php');
        
    include('../template/footer.php');

?>
