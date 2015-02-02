<?php
/*
*   archive.php  -- archive controller --
*
*   copyright 2015 Robert Clark(aka ebobtron), et al.
*
*   an expansion of my edX.org CS50x final project
*   winter/spring 2014  with Launch Code
***************************************************************/ 

    error_reporting(0); // E_ALL | 0
    
    /*  getCSVTextRows() 
     *  helper function to crate arrays from text files
     ***************************************************/
    function getCSVTextRows($filename, $year)
    {
        $path = '../include/archive'.$year.'/';
        
        $fileHandle = fopen($path.$filename.'.txt', 'r') or die("can't open file");
        while(($data = fgetcsv($fileHandle, 1000, ",")) !== FALSE)
        {
            if($data[0])
            {
                $rows [] = $data;
            }   
        }
        fclose($fileHandle);
        return $rows;
    }
    
    if(!isset($_GET['year']))
    {
        $_GET['year'] = 2014; 
    }
    
    if(!isset($_GET['grp']))
    {
        $_GET['grp'] = 0;
        $listshown = 'all submissions 2014';
        $otherOne = 'Launch Code 2014';
        $otherTwo = 'edX.org 2014';
        $otherLinkOne = 1; 
        $otherLinkTwo = 3;
    }
    elseif($_GET['grp'] == 1)
    {
        $listshown = 'Launch Code 2014';
        $otherOne = 'all submissions 2014';
        $otherTwo = 'edX.org 2014';
        $otherLinkOne = 0; 
        $otherLinkTwo = 3;
    }
    elseif($_GET['grp'] == 3)
    {
        $listshown = 'edX.org 2014';
        $otherOne = 'Launch Code 2014';
        $otherTwo = 'all submissions 2014';
        $otherLinkOne = 1; 
        $otherLinkTwo = 0;
    }
    else
    {
        header('location: archive');
    }
    
    $rows = getCSVTextRows('rows_'.$_GET['grp'], $_GET['year']);
    
    // render the archive page
    
    include('../template/header.php');
       
    include('../template/archiveView.php');
        
    include('../template/footer.php');
    
    // last edit: 02/01/2015  ebt
?>
