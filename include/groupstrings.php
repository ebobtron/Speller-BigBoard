<?php
/*
   groupstrings.php  -- group definitions for titles and links --

   copyright 2015 Robert Clark(aka ebobtron), et al.

   an expansion of my edX.org CS50x final project
   winter/spring 2014  with Launch Code
   ******************************************************************/

   /** 
     * changed to an associative array to improve readability for future and 
     * prevent need to call lookup function to get group number
     * 
     * Chris
     ***************/

    $validGrpNum_R = array(0,1,2,3);

    $defaultString = "edx2015";
    
    $titleString = array(
           "cs50staff" => "CS50 Staff Solution",
           "lcstlw2015" => "LaunchCode STL winter 2015",
           "codergirlstl2015" => "Coder Girl STL 2015",
           "edx2015" => "edX.org 2015"
           );
    
    
    $headString = array(
           "cs50staff" => "<br>", 
           "lcstlw2015" => "&nbsp;-&nbsp;&nbsp;-&nbsp;&nbsp;".
               "LaunchCode St. Louis Edition<br>",
           "codergirlstl2015" => "&nbsp;-&nbsp;&nbsp;-&nbsp;&nbsp;".
               "<a href='mailto:codergirl@launchcode.org' class='head-links'>".
               "Coder Girl STL Edition</a><br>",
           "edx2015" => "&nbsp;-&nbsp;&nbsp;-&nbsp;&nbsp;edX.org Edition<br>"
           );
    
    
    $linkString = array(
           "cs50staff" => "",
           "lcstlw2015" => "winter 2015 with ".
               "<a href='http://launchcode.org' class='head-links'>". 
               "LaunchCode.org</a>",
           "codergirlstl2015" => "2015 with ".
               "<a href='http://launchcode.org' class='head-links'>". 
               "LaunchCode.org</a>",
           "edx2015" => "2015 from <a href='http://edx.org' class='head-links'>".
               "edX.org</a>"
           );

    //   last edit: 3/11/2015  ebt                               
?>


