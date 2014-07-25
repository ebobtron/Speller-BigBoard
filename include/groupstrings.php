
<?php 

    /*** 
     * changed to an associative array to improve readability for future and 
     * prevent need to call lookup function to get group number
     */

    $validGrpNum_R = array(0,1,2,3);

    $defaultString = "edx2014";
    
    $titleString = array(
           "cs50staff" => "CS50 Staff Solution",
           "lcstlw2014" => "LaunchCodeSTL winter 2014",
           "codergirlstl2014" => "Coder Girl STL 2014",
           "edx2014" => "edX.org 2014"
           );
    
    
    
    $headString = array(
           "cs50staff" => "<br>", 
           "lcstlw2014" => "&nbsp;-&nbsp;&nbsp;-&nbsp;&nbsp;".
               "LaunchCode St. Louis Edition<br>",
           "codergirlstl2014" => "&nbsp;-&nbsp;&nbsp;-&nbsp;&nbsp;".
               "<a href='mailto:codergirl@launchcode.org' class='head-links'>".
               "Coder Girl STL Edition</a><br>",
           "edx2014" => "&nbsp;-&nbsp;&nbsp;-&nbsp;&nbsp;edX.org Edition<br>"
           );
    
    
    
    $linkString = array(
           "cs50staff" => "",
           "lcstlw2014" => "winter 2014 with ".
               "<a href='http://launchcodestl.com' class='head-links'>". 
               "LaunchCodeSTL.com</a>",
           "codergirlstl2014" => "2014 with ".
               "<a href='http://launchcodestl.com' class='head-links'>". 
               "LaunchCodeSTL.com</a>",
           "edx2014" => ""
           );
                      
    //echo $linkString[1];                  
                                        
?>
