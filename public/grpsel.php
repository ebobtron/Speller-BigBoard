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

    error_reporting(0); // E_ALL
    
    require("../include/helfun.php");
    
    $target = "sub";
    $cookie_name = 'leaderboard_cookie';
    $cookie_time = time() + (24 * 60 * 60 * 365); // about a year
    

    
    // if request croup change
    if(!isset($_GET['chg'])) {

        // check for cookie
        if(isset($_COOKIE[$cookie_name])) {
            
            // this checks if the cookie is valid by seeing id cookie value is 
            // in $titleString
            if(array_key_exists($_COOKIE[$cookie_name], $titleString)) {    
                
                // good cookie get speller
                header("Location: "."getspeller.php");
                exit;
            }
            else {
                
                // invalid cookie alert user
                header("Location: "."alert.php");
                exit;
            }    
        }
    }
    else {
        
        if(saniTize($_GET['chg']) === "default") {

            $target = "chggrp";
        }
    }

    if(isset($_POST['group'])) {
        
        $cookie_value = saniTize($_POST['group']);
        setcookie($cookie_name, $cookie_value, $cookie_time, '/');
        header("Location: ".
        "http://".$_SERVER["HTTP_HOST"].dirname($_SERVER["PHP_SELF"])."/getspeller.php");
        exit;
    }
    
    if(isset($_POST['target'])) {
        
        if(saniTize($_POST['target']) === "chggrp") {
            
            header("Location: "."show.php");
            exit;
        }
    }
    
    $template = "grpselform.php";
    
    // render header
    require("../template/header.php");

    // render template
    require("../template/$template");

    // render footer
    require("../template/footer.php"); 

?>
