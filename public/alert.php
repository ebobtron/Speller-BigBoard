<?php
/**
 *  alert.php  leader board writen by Robert Clark et al. 2014
 *  see aboutus.php 
 *************************************************************/

    error_reporting(0); // E_ALL | 0
    
    require('../include/helfun.php');
    require('../include/alert_strings.php');
    
    // default message string
    $mesString = 'no data';
    
    // default continue target
    $conTarget = 'getspeller?con=yes';
    
    // check for our cookie 
    if(isset($_COOKIE['leaderboard_cookie']))
    {
        // get group from cookie
        $group = $_COOKIE['leaderboard_cookie'];

        // check in cookie value is a valid group name
        if(!array_key_exists($group, $titleString))
        {    
            $mesString = $badCookie;
            $conTarget = 'grpsel?chg=yes';
        }
    }

    // alert is no browser cookie support
    if(isset($_GET['gsnc']))
    {    
        $mesString = $noCookieSupport;
    }
    
    // alert is duplicate local submission found
    if(isset($_GET['dupSub']))
    {
        $mesString = $dupSubmission;
        $conTarget = null;            
    }
    
    // alert is no data structure type selected
    if(isset($_GET['type']))
    {
        $mesString = $typeString;
        $conTarget = null;
    }
    
    // alert is no database connection chech error message in helfun.php
    if(isset($_GET['connect']))
    {
        $mesString = $mysqlConnectionFailed;
        $conTarget = null;
    }
    
    // alert is the submitter clicked has not reddit profile
    if(isset($_GET['reddit']))
    {
        $mesString = $noRedditProfile;
        $conTarget = null;
    }
   
    // render the alert page
    
    include('../template/header.php');
        
    include('../template/alertview.php');
        
    include('../template/footer.php');

?>
