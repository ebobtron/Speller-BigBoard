<?php
/*
    show.php   ** leader board table view controller ** 

    copyright 2015 Robert Clark(aka ebobtron), et al.
  
    an expansion of my edX.org CS50x final project
    winter/spring 2014  with Launch Code
    
    ******************************************************/

    error_reporting(0);  // E_ALL | E_STRICT
    
    require "../include/helfun.php";
    
    // set default table
    // $template = "table_all.php";
    // changed default page the all groups thing is like not needed anymore
    $template = "table.php";   
       
    // get array of keys for titleString array
    // keys to array elements are numeric
    $keys = array_keys($titleString);
    
    // check if group to display is pasted in the url
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
        $template = "table.php"; 
    }
    
    $what = array("rows", "sort");
    
    $nmark = null;
    $tmark = null;
    $lmark = null;
    $cmark = null;
    
    $nsort = 0;
    $tsort = 1;
    $lsort = 0;
    $csort = 0;
    
    if(isset($_POST['form']))
    {
        $nmark = ($_POST['nsort'] > 0) ? $upmark : $downmark;
        $nmark = ($_POST['nsort'] == 0) ? null : $nmark;
        $nsort = $_POST['nsort'];
        
        $tmark = ($_POST['tsort'] > 0) ? $upmark : $downmark;
        $tmark = ($_POST['tsort'] == 0) ? null : $tmark;
        $tsort = $_POST['tsort'];
        
        $lmark = ($_POST['lsort'] > 0) ? $upmark : $downmark;
        $lmark = ($_POST['lsort'] == 0) ? null : $tmark;
        $lsort = $_POST['lsort'];
        
        $cmark = ($_POST['csort'] > 0) ? $upmark : $downmark;
        $cmark = ($_POST['csort'] == 0) ? null : $tmark;
        $csort = $_POST['csort'];
        
        //$lmark = $_POST['lmark'];
        //$cmark = $_POST['cmark'];
    }
    

    if(isset($_POST['head']))
    {       
        if($_POST['head'] === "name")
        {
            if($nsort > 0)
            {          
                $nmark = $downmark;
                $nsort = -1;
                $what[1] = "nsortd";
            }
            else
            {
                $nmark = $upmark;
                $nsort = 1;
                $what[1] = "nsortu";
            }
            $tsort = 0;
            $lsort = 0;
            $csort = 0;
        }
        else
            $nmark = null;
        
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
    else
    {
        $tmark = $upmark; 
    }
    

   
/*
*/    
 
    // get table rows from display
    $rows = getPut($what, getGroupNumber($group));

    // render header
    require("../template/header.php");
    
    // render links
    require("../template/links.php");

    // render template
    require("../template/$template");

    // render footer
    require("../template/footer.php");

    // last edit: 05/11/2015 ebt
?>

