<?php
/*
      show.php   leader board table view controller 
  
      copyright 2015 Robert Clark(aka ebobtron), et al.
  
      an expansion of my edX.org CS50x final project
      winter/spring 2014  with Launch Code                          */
    
    

    error_reporting(0);  // E_ALL | E_STRICT
    
    require "../include/helfun.php";

    // default table values
    $postlist = null;
    $table = false;
    $tablelist = 'unique';
    $caption = null;
    
    
    // set default table
    $template = "table_db.php";  // new table design suggested by alexg
    
    if(isset($_POST['list'])){
        $postlist = $_POST['list'];
        $tablelist = $_POST['list'];
    } 
    
    // if a different leader baord is selected or track the current
    // leader board selected
    if(isset($_GET['t'])){        
        
        if($_GET['t'] === 'a'){            
            $tablelist = 'all';
        }
        
        if($_GET['t'] === 'u'){
            $tablelist = 'unique';
        }
    }
    
    if($tablelist === 'unique'){
        $amark = null;
        $umark = '&#x2713;';
        $caption = 'fastest by type';
    }
    else{
        $umark = null;
        $amark = '&#x2713;';
        $caption = 'all submissions';
    }

      
    // get array of keys for titleString array
    // keys to array elements are numeric
    $keys = array_keys($titleString);
    
    // check if group to display is passed in the url
    if(isset($_GET['grp']))
    {    
        // assign get to $grpNumber for clarity
        $grpNumber = saniTize($_GET['grp']);
        
        if($grpNumber == 0)
        {    
            $group = null;
        }
        else
        {
            // prevent bogus grpNumber
            if(isset($keys[$grpNumber]))
            {    
                $group = $keys[$grpNumber];
            }
            else
            {    
                $group = null;
            }
        }
    }
    else
    {
        // if group not pasted in url check cookie 
        // if cookie exist, set group based on cookie data
        if(isset($_COOKIE['leaderboard_cookie']))
        {    
            $group = $_COOKIE['leaderboard_cookie'];

            if(!array_key_exists($group, $titleString))
            {
                $group = null;
            } 
        }
        // else, redirect to table showing all groups times
        else
        {   
            $group = null;
        }
    }
    
    // tell the user which group they are looking at
    if($group !== null)
    {    
        $title = $titleString[$group];
        $head = $headString[$group];
        $link = $linkString[$group];
        $template = "table_db.php"; 
    }
    
    // default command array for the MySQL call getPut() 
    $what = array("$tablelist", "sort");
    
    // start all sort direction marks as null
    $nmark = null;
    $tmark = null;
    $lmark = null;
    $cmark = null;
    
    // start all sort status varibles as null
    $nsort = 0;
    $tsort = 1;
    $lsort = 0;
    $csort = 0;
    
    // if a heading title clicked 
    if(isset($_POST['form']))
    {
        // relate sort status with mark
        $nmark = ($_POST['nsort'] == 0) ? null : $nmark;  // set mark to 0 or leave it
        $nsort = $_POST['nsort'];  // update sort value from table form
        
        $tmark = ($_POST['tsort'] == 0) ? null : $tmark;
        $tsort = $_POST['tsort'];
        
        $lmark = ($_POST['lsort'] == 0) ? null : $tmark;
        $lsort = $_POST['lsort'];
        
        $cmark = ($_POST['csort'] == 0) ? null : $tmark;
        $csort = $_POST['csort'];
    }
    
    // if a heading title clicked 
    if(isset($_POST['head']))
    {       
        if($_POST['head'] === "name")
        {
            // if name clicked check name sort status  valid is -1, 0, 1
            if($nsort > 0)
            {          
                $nmark = $downmark;  // toggle mark
                $nsort = -1;  // toggle sort status         
                $what[1] = "nsortd";  // set getPut() argument string
            }
            else
            {
                $nmark = $upmark; 
                $nsort = 1;
                $what[1] = "nsortu";
            }
            $tsort = 0;  // zero other marks
            $lsort = 0;
            $csort = 0;
        }
        else
            $nmark = null;  // if name heading not click set mark to null;
        
        if($_POST['head'] === "total")
        {   
            if($tsort > 0)
            {          
                $tmark = $downmark;
                $tsort = -1;
                $what[1] = "tsortd";
            }
            else
            {
                $tmark = $upmark;
                $tsort = 1;
                $what[1] = "tsortu";
            }
            $nsort = 0;
            $lsort = 0;
            $csort = 0;
            
        }
        else
            $tmark = null;  
        
        if($_POST['head'] === "load")
        {   
            if($lsort > 0)
            {          
                $lmark = $downmark;
                $lsort = -1;
                $what[1] = "lsortd";
            }
            else
            {
                $lmark = $upmark;
                $lsort = 1;
                $what[1] = "lsortu";
            }
            $nsort = 0;
            $tsort = 0;
            $csort = 0;
            
        }
        else
            $lmark = null;        

        if($_POST['head'] === "check")
        {   
            if($csort > 0)
            {          
                $cmark = $downmark;
                $csort = -1;
                $what[1] = "csortd";
            }
            else
            {
                $cmark = $upmark;
                $csort = 1;
                $what[1] = "csortu";
            }
            $nsort = 0;
            $tsort = 0;
            $lsort = 0;
            
        }
        else
            $cmark = null;

    }
    
    // 
    if(isset($_GET['grp']))
    {
        if($_GET['grp'] == 9)
        {
            $group = 'test';
        }
    }
    
    // get table rows from display
    $rows = getPut($what, getGroupNumber($group));    
    
    // determin odd or even number of rows
    $oddrows = count($rows, 0) % 2;
    
    // background color of table body div should be oposite the last row color
    if($oddrows)
        $rowcolor = '#dde7ed';
    else
        $rowcolor = '#e8eff5';

    // render header
    require("../template/header.php");
    
    // render menu
    require("../template/menu.php");

    // render template
    require("../template/$template");

    // render footer
    require("../template/footer.php");

?>

