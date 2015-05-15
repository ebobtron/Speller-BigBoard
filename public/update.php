<?php
/*
    update.php  ** add new submission data to board and send email notifications **
    
    copyright 2015 Robert Clark(aka ebobtron), et al.
  
    an expansion of my edX.org CS50x final project
    winter/spring 2014  with Launch Code
    ******************************************************************************/
 
    // this is an administration file not normally seen buy the public.
    
    /*  local report_error funciton
     *
     ******************************/ 
    function report_Error($message){
        $error = $message;
        require '400.php';
        exit;
    }
    /***********     *************/
   
    error_reporting(E_ALL); // E_ALL
       
    // check for illegal array element count, one and two are valid
    if(count($_GET) > 2 )
    {
        report_Error('access violation');    
    }
    
    // default value is no return text
    $returnText = false;
    
    // test for valid array keys and values
    if(array_key_exists('data', $_GET) && $_GET['data'] == "yes")
    {
        if(array_key_exists('parsub_c', $_GET) && $_GET['parsub_c'] == "yes")
        {
           $returnText = true; 
        }
    }
    else
    {
        report_Error('invalid request');
    }
    
    /****              *********/
    // valid request, do the work
    
    $results = null;
    $results_mail = null;

    // if no submission data then alert the admin
    if(!file_exists("../minis/newsubdata.txt"))
    {    
        $results = 'no submission data to load to database';
    }
   
    require_once "../include/helfun.php";
        
    $endofline = '<br>';
    $htmlheader = "<div class='admin'><h3>admin: update submission data</h3>";
    $htmlfooter = '</div>';
    
    if(file_exists("../minis/emailNot.txt"))
    {
        
        // if no submission data results so far get some
        if(!$results)
        {
            $results = updateData($returnText);
        }
        else
        {
            // clean up the submission files when failed
            updateData($returnText);
        }
        $results_mail = sendemailNotifications($returnText);
    }
    else
    {
        $results_mail = ' e22 email notification file not found';
    }

    if($returnText)
    {
        echo "...     update.php reports\n\n";
        echo $results;
        echo "\n";
        echo $results_mail;
    }
    else
    {    
        // render header
        require("../template/header.php");    

        // render body directly
        echo $htmlheader;
        echo $results . $endofline;
        echo $results_mail;
        echo $htmlfooter;
    
        // render footer
        require("../template/footer.php");
    }
    
    
    // last edited:  03/23/2015  ebt
?>
