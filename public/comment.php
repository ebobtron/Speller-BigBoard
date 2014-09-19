<?php
/**
 *  comment.php    display comment from submitter or redirect to reddit if possible
 *  
 *  2014 Robert Clark, aka ebobtron et al.
 *
 *  an expansion of my final project for CS50 with edX.org 2014
 *
 ***************************************************************/
 
    error_reporting(E_ALL); // E_ALL
    
    include '../include/commentlist.php';
    
    // validate $_GET
    if(!isset($_GET['comment']))
    {
        header('location: alert');
        exit;
    }
    else
    {
        if(in_array($_GET['comment'], $comList_R, true))
        {
            // include the user comment file
            include('../include/text/' . $_GET['comment'] . '.php');
            
            // assign variable for use in html comview
            $usr = $_GET['comment'];
            
            // render page
            include('../template/header.php');
            include('../template/comview.php');
            include('../template/footer.php');
        }
        else
        {
            header('location: reddit?usr=' . $_GET['comment']);
            exit;
        }
    }
    
?>    
