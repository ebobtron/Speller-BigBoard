<?php    
/**
 *  reddit.php    reddit redirect or throw error
 *  
 *  2014 Robert Clark, aka ebobtron et al.
 *
 *  an expansion of my final project for CS50 with edX.org 2014
 *
 ***************************************************************/
 
    error_reporting(E_ALL); // E_ALL
    
    // validate $_GET
    if(isset($_GET['usr']))
    {
        $url = 'http://www.reddit.com/user/' . $_GET['usr'] . '/';
    }
    else
    {
        header('location: alert?reddit=url');
        exit;
    }
    
    // get a CURL handle
    $curlHan = curl_init();
    
    curl_setopt($curlHan, CURLOPT_URL, $url);
    curl_setopt($curlHan, CURLOPT_HEADER, TRUE);
    curl_setopt($curlHan, CURLOPT_NOBODY, TRUE); // remove body
    curl_setopt($curlHan, CURLOPT_RETURNTRANSFER, TRUE);
            
    $head = curl_exec($curlHan);
            
    $httpCode = curl_getinfo($curlHan, CURLINFO_HTTP_CODE);
            
    curl_close($curlHan); 
            
    if($httpCode > '400')
    {
        header('location: alert?reddit=url');
        exit;
    }
    else
    {
        header('location: '.$url);
        exit;
    }

?>            