
<?php
/**
*
*   grpsel.php  group selection controler
*
*   Robert Clark, aka ebobtron et al
*
*   An expansion of my
*   CS50x final project   winter/spring 2014 with Launch Code
*
***************************************/

    error_reporting(E_ALL);
    
    $target = "sub";
    $cookie_name = 'leaderboard_cookie';
    $cookie_time = time() + (24 * 60 * 60 * 365); // about a year
    
    
    if(!isset($_GET['chg'])) {

        if(isset($_COOKIE[$cookie_name])) {
                
            header("Location:"."getspeller.php");
        }
    }
    else {
        
        if(strcmp($_GET['chg'],"default") == 0){
            
            $target = "chggrp";
        }
    }

    if(isset($_POST['group'])) {

        $cookie_value = $_POST['group'];
        setcookie($cookie_name, $cookie_value, $cookie_time, '/');
        header("Location:".
        "http://".$_SERVER["HTTP_HOST"].dirname($_SERVER["PHP_SELF"])."/getspeller.php");
    }
    
    if(isset($_POST['target'])) {
        
        if(strcmp($_POST['target'],"chggrp") == 0) {
            
            header("Location:"."show.php");
        }
    }
    


    /* // diagnostic code
    if(isset($_COOKIE[$cookie_name])) {    
        echo $_COOKIE[$cookie_name]."<br>";
        print_r($_COOKIE);
    }
    ********************************/


    $template = "grpselform.php";
    
            // render header
            require("../template/header.php");

            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php"); 

?>
