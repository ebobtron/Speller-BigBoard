
<?php
/**
 *  alert.php  leader board writen by Robert Clark et al. 2014
 *************************************************************/
 
    error_reporting(E_ALL); // E_ALL
    
    require("../include/helfun.php");
    
    // message string
    $mesString = "no data";
    
    // continue target
    $contarget = "getspeller.php?con=yes";
    
    // check for valid cookie
    if(isset($_COOKIE['leaderboard_cookie'])) {
        
        $group = $_COOKIE['leaderboard_cookie'];

        if(!array_key_exists($group, $titleString)) {
            
            $mesString = "<br /><br />" .
                         "It appears your cookie has been corrupted, the reason is " .
                         "unclear.&nbsp; Please continue to choose your group." .
                         "<br /><br />Please direct any questions to the " .
                         "<a href=\"mailto:ebobtron@aol.com\" class=\"legal-links\" " .
                         "style=\"font-size:16px\">administrator.</a><br />";
            $contarget = "grpsel.php?chg=yes";
        }          
    }
    
    if(isset($_GET['gsnc'])) {
        
        $mesString = "<br /><br />" .
                     "The Leader Board has detected that your browser is not supporting " .
                     "cookies.<br /><br />The Leader Board uses cookies to track the user " .
                     "group affiliation during file submissions.&nbsp; You may continue " .
                     "and your group will default to edX.org else please enable your " .
                     "cookies or use another browser.<br /><br />Thanks for using the Leader ".
                     "Board.<br /><br />Please direct any questions to the " .
                     "<a href=\"mailto:ebobtron@aol.com\" class=\"legal-links\" " .
                     "style=\"font-size:16px\">administrator.</a><br />";

    }
    
    if(isset($_GET['dupSub'])) {
    
        $mesString = "<br /><br />" .
                     "The Leader Board has a file as yet untested that matches your " .
                     "current submission.&nbsp; The testing and benchmarking programs " .
                     "are not fully automated and it may take several hours to see the " .
                     "results on the board.&nbsp; Please hold all additional submissions " .
                     "until your current submission reaches the board.<br />" .
                     "<br />Thanks<br />" .
                     "<br />Please direct any questions to the " .
                     "<a href=\"mailto:ebobtron@aol.com\" class=\"legal-links\" " .
                     "style=\"font-size:16px\">administrator.</a><br />";
         
        $contarget = null;            
    }
    
    if(isset($_GET["type"])) {
        
    $mesString = <<<'EDO'
          <br /><br />
          please select the data type you used, if yours is not shown please
          select other.<br /><br />
          <a href="javascript:history.go(-1);" class="head-links"
          style="font-size:20px">go back
          and select data type</a><br /><br /><br />
EDO;
                     
        $contarget = null;
    }
    
    
    // render the page
    
        include("../template/header.php");
        
        include("../template/alertview.php");
        
        include("../template/footer.php");



?>

