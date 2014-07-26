<?php
/**
*
*   helfun.php  or helper functions for leader board 
*   Robert Clark, aka ebobtron et al.
*   
*   extension of my CS50x final project   winter/spring 2014  with Launch Code
*
*************************************************************/


require "config.php"; 

require "groupstrings.php";
require_once('../include/jpgraph-3.5.0b1/src/jpgraph.php');

/*
 *   Pear Mail    http://pear.php.net/package/Mail
 *
 *   the regular PHP email functions don't allow for authentication
 *
 *   att.net and  some other incoming mail servers require that 
 *   the sending client authenticate the sender, i.e. user id and password
 *           
 ****************************************/
function sendMail($to, $cc, $subject, $body) {

    require_once "Mail.php";
    require "config.php";

    $from = "leader board <".$username.">";

    $recipients = $to.",".$cc.",".$bcc;

    $headers = array ('From' => $from,
                      'Cc' => $cc,
                      'Return-Path' => $username,
                      'To' => $to,
                      'Subject' => $subject);


        /*  FOR Blind Carbon Copy
        /*  leave from $headers to make it blind
        /*  'Bcc' => $bcc,
        /***************************************/

    $params = array('host' => $host,
                    'port' => $port, 
                    'auth' => true,
                    'username' => $username,
                    'password' => $pwd);

    $smtp = Mail::factory('smtp', $params);

    $mail = $smtp->send($recipients, $headers, $body);

    if(PEAR::isError($mail)) {
    
    // TODO: fix this error mess
    
        $mes = "<br><br>Nothing to worry about, someone is not going to get an email";
        $mes = $mes . "<br>" . $mail->getMessage();
        
        return $mes;
    }
    else {
        
        return "<br>A message was successfully sent to the leader board administrator".
               " about this submission!";
    }
}

/*
 *  PDOconnect()
 *
 *  returns a handle to our connection to the MySql database table
 *****************************************************************/

function PDOconnect() {
    
    require "config.php";

    $dsn = 'mysql:host='.$dbpath.';dbname='.$dbuser;
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 

    try {
        
        $dbhan = new PDO($dsn, $dbuser, $dbpass, $options);
        $dbhan->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
        
        echo 'LeaderBoard PDOConnect ERROR: ' . $e->getMessage();
    }
    
    return $dbhan;
}

/*  
 *  GETPUT()
 *
 *  DATABASE FUNCTIONS  NO ON THE FLY SQL STATEMENTS        
 *********************************************************/

function getPut($what, $data) {
 
    //  connect to the database
    $dbhandle = PDOconnect();
    
    // set some common variables
    $stmt = null;
    $results = null;
    $errorMessage = null;
    
    //--  GET ROWS   
    //--  if $data = group number, returns group number and group zero("0") Staff
    //--  if $data = null, returns all groups
    //--  confine $data to "null" or numeric symbols 0, 1, 2 etc.
    if($what == "rows") {
        
        $sql = "SELECT * FROM leader_board WHERE total IS NOT NULL ";
        
        if($data !== null) {
            $sql = $sql . "AND grp = :grp0 OR grp = 0 ORDER BY total ASC";
        }
        else {   
            $sql = $sql . "ORDER BY total ASC";
        }
        $stmt = $dbhandle->prepare($sql);
        $stmt->bindParam(":grp0", $data);
    }
    
    //--  GET NEXT ID
    if($what == "nextId") {
    
        $sql = "SELECT MAX(id) FROM leader_board WHERE grp = :grp1";        
        $stmt = $dbhandle->prepare($sql);
        $stmt->bindParam(":grp1", $data);
    }
    
    if($stmt === null) {
    
        return " GETPUT parameter 1 invalid";
    
    }
       
    //--  COMMON TRY CATCH  ----
    try {     
        
        if($stmt->execute() !== false) {
        
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    catch(PDOException $error) {

        $errorMessage = $error->getMessage();
    }
        
    //--  return data "rows"
    if($what == "rows"){
    
        if($errorMessage === null) {
        
            return $results;
        }
        else {
        
            return ' GETPUT"rows" - ERROR:..&nbsp;&nbsp; ' . $errorMessage;
        }    
    }
    
    //--  return data "nextId"
    if($what == "nextId") {
    
        if($errorMessage === null) {
        
            return array("nextId" => $results[0]['MAX(id)']+1);
        }
        else {
        
            return ' GETPUT"nextId" - ERROR:..&nbsp;&nbsp; ' . $errorMessage;
        }
    }   
}

/*
 *  createSubInfo()
 *
 *  creates submission info file with data for testing the submissions  
 ***********************************************************************/

function createSubInfo($name, $id, $email, $dir) {
    
    $outFileName = $dir . "subInfo.txt";
    $outFileHandle = fopen($outFileName, 'a') or die("can't open file");
    
    $outString = $name . $id . "speller.x,";
    $outString = $outString . $id . "," . $name. "," . $email . "\n";

    if($outFileHandle) {
        
        fwrite($outFileHandle, $outString); 
        fclose($outFileHandle);
    }
}

/*
 *   updateData()
 *   LOAD SUBMISSION DATA INTO DATABASE  
 *********************************************************/

function updateData() {
    
    include "groupstrings.php";
    $success = true;
    $inFileName = "../minis/newsubdata.txt";
    
    if(!file_exists($inFileName)) {
        
        $dbhandle = null;
        dumpSubmissions(0,0);
        moveSubmissions();
        return "&nbsp;...no submission data: file \"" . $inFileName . "\" not found<br />";        
    } 
        
    $dbhandle = PDOconnect();

    $sql = "REPLACE INTO `leader_board` VALUES(:id, :grp2, :name, :total, :dload,";
    $sql = $sql . " :tcheck, :size, :unload, :mem, :typ)";    
    
    $inFileHandle = fopen($inFileName, 'r') or die("can't open file");
    
    try {

        $stmt = $dbhandle->prepare($sql);
        $tempGroup = 1;
        
        while(($data = fgetcsv($inFileHandle, 1000, ",")) !== FALSE) {

            if(!$data[0]) {
                
                break;
            }
            
            $type = null;
            
            // extract group and type from $data[0]
            if(!in_array($data[0], $validGrpNum_R, true)) {
                               
                // asign last value in $data[0]
                $type = $data[0][strlen($data[0]) - 1];
                
                // remove -type value from $data[0]
                $data[0][strlen($data[0]) - 1] = null;
                $data[0][strlen($data[0]) - 1] = null;
            } 
            
            $return = getPut("nextId", $data[0]);
            
            if(is_array($return)) {
                
                $stmt->bindParam(":id", $return['nextId']);
            }
            $stmt->bindParam(":grp2", $data[0]);
            $stmt->bindParam(":name", $data[1]);
            $stmt->bindParam(":total", $data[2]);
            $stmt->bindParam(":dload", $data[3]);
            $stmt->bindParam(":tcheck", $data[4]);
            $stmt->bindParam(":size", $data[5]);
            $stmt->bindParam(":unload", $data[6]);
            $stmt->bindParam(":mem", $data[7]);
            $stmt->bindParam(":typ", $type);
            
            $stmt->execute();
            printf("adding %04u for group %u name: \" %s \" total time: %04f <br>",
                    $return['nextId'], $data[0], $data[1], $data[2]);
            
            $oldFileName = $data[1] . $data[0] . "speller.x";
            $newFileName = $oldFileName . $return['nextId'];
            
            dumpSubmissions($oldFileName, $newFileName);
                    
        }
    }
    catch(PDOException $e) {
        
        $success = false;
        echo 'Leader Board updateData ERROR: ' . $e->getMessage();
    }
    // clean up files
    unlink($inFileName);
    dumpSubmissions(0,0);
    moveSubmissions();
    
    if($dbhandle)
        $dbhandle = null;

    return $success;
}

/*
 *   sendemailNotifications()
 *   SEND NOTIFICATIONS FRM AN UPLOADED FILE
 ****************************************************/   
function sendemailNotifications($mode) {
    
    include("groupstrings.php");
     
    // submission data uploaded from submission testing
    $inFileName = "../minis/emailNot.txt";
    
    // in no email notification file complain and then return
    if(!file_exists($inFileName)) {
        
        echo "<br>&nbsp;&nbsp;&nbsp;no email notification, no file \" emailNot.txt \"";
        return;        
    }
    
    // open submisson notification file or die
    $inFileHandle = fopen($inFileName, 'r') or die("can't open file");
    
    // on error complain and return
    if($inFileHandle == 0) {
        
        echo "No email notification file emailNot.txt";
        return;
    }
    
    // get array keys by position number
    $keys = array_keys($titleString);
    
    // loop through submisson notification file until end
    while(true) {
        
        $lineOne = fgetcsv($inFileHandle, 500, ",");
        $lineTwo = fgetcsv($inFileHandle, 500, ",");
        
        // if end of file break from loop
        if(feof($inFileHandle))
            break;
        
        // get group string for email notification
        $group = $titleString[ $keys[$lineTwo[1]]];
        
        // insert group title string into email body
        $body =  $lineTwo[0] . " of " . $group . ", " . $lineTwo[2];
     
        
        // email "to, cc, subject, body"
        $result = sendMail($lineOne[0], "ebobtron@aol.com", $lineOne[2], $body);
        
        // display part of message
        echo substr($result, 0, 35).".";
    
    }

    unlink($inFileName);
    return;
}

/*
 *  validName()
 *  replace white spaces from names D Doug becomes D_Doug
 *****************************************************************/
function validName($name) {
   
    return preg_replace("/\s+/", "_",$name);
}

/*
 *  validEmail()
 *  validate email address
 **********************************/
function validEmail($email) {
    
    $regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/"; 

    if(preg_match($regex, $email)) {
     
        return $email;
    }
    else {
        
        return null;
    }
}

/*
 *  saniTize()                     theB264
 *  sanitize it before we use it
 *****************************************/
function saniTize($words) {
    
    $regex = "/^[_0-9a-z A-Z]+$/";   // regular expression from theB264
    
    if(preg_match($regex, $words)) {
     
        return $words;
    }
    else {
        
        return null;
    }
} 
function saniTizeEmail($address) {
    // also investigate php's FILTER_SANITIZE_EMAIL
    if (filter_var($address, FILTER_VALIDATE_EMAIL)) {
        return $address;
    }
    return null;
}
/*
 *  dumpSubmissions()
 *  MOVE SUBMISSIONS FROM UPLOADING TO DUMP
 ******************************************/
function dumpSubmissions($old, $new) {
    
    if($old && $new) {
        
        $old = "../uploading/".$old;
        $new = "../dump/".$new;
        copy($old, $new);
        echo "moved to the dump, the file: " . $old . "<br>";
        unlink($old);
        return;
    }
    
    $files = glob("../uploading/*");
    $newfileName = null;
    
    foreach($files as $file) {
          
        $newfileName = "../dump/".basename($file);
        
        if(is_file($file)) {
            
            copy($file, $newfileName);
            echo "moved to the dump, the file: ".$newfileName . "<br>";
            unlink($file);
        }
    }
    
    return;
}

/*
 *  MOVE SUBMISSIONS FROM Alternate Directory
 *
 *********************************************/
function moveSubmissions() {

    $files = glob("../uploading_alt/*");
    
    foreach($files as $file) {
          
        $newfileName = "../uploading/".basename($file);
        
        if(is_file($file)) {
            
            copy($file, $newfileName);
            echo "found new submissin file: ".$newfileName . "<br>";
            unlink($file);
        }
    }
    
    // ends submission redirect
    if(file_exists("../minis/alt_load.txt")) {
        
        unlink("../minis/alt_load.txt");
    }    
    return; 

}

/*
 *  getGroupNumber()   by  h-chris
 *  GET GROUP NUMBER    
 ****************************/
function getGroupNumber($grpName){
    
    $grpNum = null;
    
    if($grpName === null) {
        
        return $grpNum;
    }
    
    // set filename and attempt to open
    $filename = "../include/grps.json";

    if(file_exists($filename)) {
        
        $file = fopen($filename, "r");
    }
    else {
        
        echo "...Error: could not open :" . $filename . "<br>";
    }
    
    // error check
    if($file) {
        
        // set group number from data
        $json = json_decode(fread($file, filesize($filename)), true);
        
        if(isset($json[$grpName])) {
            
            $grpNum = $json[$grpName];
        }

        fclose($file);
    }

    return $grpNum;
}

?>

