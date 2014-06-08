
<?php 

    /*** 
     * changed to an associative array to improve readability for future and 
     * prevent need to call lookup function to get group number
     */

    $titleString = array(
           "none" => "",
           "lcstlw2014" => "LaunchCodeSTL winter 2014",
           "codergirlstl2014" => "Coder Girl STL 2014",
           "edx2014" => "edX.org 2014"
           );
    
    
    
    $headString = array(
           "none" => "<br />", 
           "lcstlw2014" => "&nbsp;-&nbsp;&nbsp;-&nbsp;&nbsp;LaunchCode St. Louis Edition<br>",
           "codergirlstl2014" => "&nbsp;-&nbsp;&nbsp;-&nbsp;&nbsp;".
              "<a href='mailto:codergirl@launchcode.org' class='head-links'>".
              "Coder Girl STL Edition</a><br>",
           "edx2014" => "&nbsp;-&nbsp;&nbsp;-&nbsp;&nbsp;edX Edition<br>"
           );
    
    
    
    $linkString = array(
           "none" => "",
           "lcstlw2014" => "winter 2014 with <a href='http://launchcodestl.com' class='head-links'>". 
                      "LaunchCodeSTL.com</a>",
           "codergirlstl2014" => "2014 with <a href='http://launchcodestl.com' class='head-links'>". 
                      "LaunchCodeSTL.com</a>",
           "edx2014" => ""
           );
                      
    //echo $linkString[1];                  
                                        
?>
