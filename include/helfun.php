<?php
/*
*   helfun.php    ** helper functions for leader board ** 
*
*   copyright 2015 Robert Clark(aka ebobtron), et al.
*
*   an expansion of my edX.org CS50x final project
*   winter/spring 2014  with Launch Code
*************************************************************/

require "config.php"; 

require "groupstrings.php";

#require_once('../include/jpgraph-3.5.0b1/src/jpgraph.php');

    // set default timezone, dah!
    date_default_timezone_set('America/Chicago');

/*
 *   Pear Mail    http://pear.php.net/package/Mail
 *
 *   the regular PHP email functions don't allow for authentication
 *
 *   att.net and  some other incoming mail servers require that 
 *   the sending client authenticate the sender, i.e. user id and password
 *           
 ****************************************/
function sendMail($to, $cc, $subject, $body)
{

    error_reporting(E_ALL & ~E_STRICT);
    
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
    
    $mailobj = new Mail;
    
    $smtp = $mailobj->factory('smtp', $params);

    $mail = $smtp->send($recipients, $headers, $body);
    
    $pearobj = new PEAR; 
    if($pearobj->isError($mail))
    {
        $mes = "<br><br>An email server / script error has occured.&nbsp; Errormessage is: ";
        return $mes . "<br>" . $mail->getMessage();
    }
    else
    {   
        return "<br>A message was successfully sent to the leader board administrator ".
               "about this submission!";
    }
}

/*
 *  PDOconnect()
 *
 *  returns a handle to our connection to the MySQL database table
 *****************************************************************/

function PDOconnect() {
    
    require "config.php";

    $dsn = 'mysql:host='.$dbpath.';dbname='.$dbuser;
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 

    try
    {    
        $dbhan = new PDO($dsn, $dbuser, $dbpass, $options);
        $dbhan->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $error)
    {
        // set time zone to match the server logs 
        date_default_timezone_set('UTC'); //America/Chicago

        // build log message
        $logmes = 'LeaderBoard PDOConnect ERROR: ' . $error->getMessage() .
        date("D M j G:i:s T Y") . "\r\n";
        
        // open log file for appending
        $outFileHandle = fopen('../logs/pdoconnect_error.log', 'a');
        
        // write message to file
        fwrite($outFileHandle, $logmes);
        
        // if outFileHandle good close the file
        if($outFileHandle)
        { 
            fclose($outFileHandle);
        }
        
        // alert user 
        header('location: alert?connect=no');
        
        // stop script here upon return
        exit;
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
    
    //--   GET SUBMISSION NAMES
    if($what == "subNames") {
    
        $sql = "SELECT name FROM leader_board WHERE grp = :grp1 GROUP BY name";        
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
    
        if($errorMessage === null)
        {
            return $results;
        }
        else
        {
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
    
    //--  return data "subNames"
    if($what == "subNames") {
    
        if($errorMessage === null) {
            
            return $results;
        }
        else {
        
            return ' GETPUT"subNames" - ERROR:..&nbsp;&nbsp; ' . $errorMessage;
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

function updateData()
{    
    // get the group names and data identifiers
    include "groupstrings.php";
    
    // default success - thing positive
    $success = true;
    
    // data structure descriptors
    $dsType = array('none','Hash Table','Trie','Other');
    
    // submission data file name
    $inFileName = "../minis/newsubdata.txt";
    
    // in no submission data then clean up the files
    // and alert the admin
    if(!file_exists($inFileName))
    {    
        dumpSubmissions(0,0);
        moveSubmissions();
        return "&nbsp;...no submission data: file \" $inFileName \" not found<br />";        
    } 
        
    // connect to the data base get handle
    $dbhandle = PDOconnect();

    // define the MySQL statement 
    $sql = "REPLACE INTO `leader_board` VALUES(:id, :grp2, :name, :total, :dload,";
    $sql = $sql . " :tcheck, :size, :unload, :mem, :typ)";    
    
    // open submission data file
    $inFileHandle = fopen($inFileName, 'r') or die("can't open file");
    
    // begin adding data to database
    try
    {
        // prepare or create sql statement object
        $stmt = $dbhandle->prepare($sql);
        
        // begin parsing data from submission file one line at a time
        while(($data = fgetcsv($inFileHandle, 1000, ",")) !== FALSE)
        {
            // if no data exit loop
            if(!$data[0])
            {
                break;
            }
            
            // default type value
            $type = null;
            
            // extract group and type from $data[0]
            if(!in_array($data[0], $validGrpNum_R, true)) {
                               
                // assign last value in $data[0]
                $type = $data[0][strlen($data[0]) - 1];
                
                // get group substring
                $data[0] = substr($data[0], 0, strlen($data[0] - 2));
                
            } 
            
            // get the next id number for this group
            $return = getPut("nextId", $data[0]);
            
            // if getput nextId result good bind data or throw error 
            if(is_array($return))
            {    
                $stmt->bindParam(":id", $return['nextId']);
            }
            else
            {
                $error = 'unable to get id number';
                throw new Exception($error);
            }
            // bind data to object
            $stmt->bindParam(":grp2", $data[0]);
            $stmt->bindParam(":name", $data[1]);
            $stmt->bindParam(":total", $data[2]);
            $stmt->bindParam(":dload", $data[3]);
            $stmt->bindParam(":tcheck", $data[4]);
            $stmt->bindParam(":size", $data[5]);
            $stmt->bindParam(":unload", $data[6]);
            $stmt->bindParam(":mem", $data[7]);
            $stmt->bindParam(":typ", $dsType[$type]);
            
            // execute the MySQL data addition
            $stmt->execute();
            
            // output admin data
            printf("adding %04u for group %u name: \" %s \" total time: %04f <br>",
                    $return['nextId'], $data[0], $data[1], $data[2]);
            
            // build some source and destination strings
            $oldFileName = $data[1] . $data[0] . '-' . $type . 'speller.x';
            $newFileName = $oldFileName . $return['nextId'];

            // move submitter's files to the dump if it exists
            // under certain automation testing methods the file may not exist
            // if submitter is not on the board or the lastest submission fails the
            // file well move to the dump and replace any file already there.  The
            // dump contains file on the board or last failure. 
            if(file_exists('../uploading/' . $oldFileName))
            {
                dumpSubmissions($oldFileName, $newFileName);
            }       
        }
    }
    catch(PDOException $e)
    {    
        // success is not true / echo error message
        $success = false;
        echo 'Leader Board updateData ERROR: ' . $e->getMessage();
    }
    
    // clean up files and move to dump if no data was uploaded
    unlink($inFileName);
    dumpSubmissions(0,0);
    moveSubmissions();
    
    // close database connection if open
    if($dbhandle)
        $dbhandle = null;

    // return success true or false
    return $success;
}

/*
 *   sendemailNotifications()
 *   SEND NOTIFICATIONS FROM AN UPLOADED FILE
 ****************************************************/   
function sendemailNotifications($mode) {

    // $mode not currently in use
    
    include("groupstrings.php");
     
    // submission data uploaded from submission testing
    $inFileName = "../minis/emailNot.txt";
    
    // in no email notification file complain and then return
    if(!file_exists($inFileName))
    {    
        echo "<br>&nbsp;&nbsp;&nbsp;no email notification, no file \" emailNot.txt \"";
        return;        
    }
    
    // open submisson notification file or die
    $inFileHandle = fopen($inFileName, 'r') or die("can't open file");
    
    // on error complain and return
    if($inFileHandle == 0)
    {    
        echo "No email notification file emailNot.txt";
        return;
    }
    
    // get array keys by position number
    $keys = array_keys($titleString);
    
    // loop through submisson notification file until end
    while(true)
    {
        // get first and second line of message
        $lineOne = fgetcsv($inFileHandle, 500, ",");
        $lineTwo = fgetcsv($inFileHandle, 500, ",");
        
        // if end of file break from loop
        if(feof($inFileHandle))
        {
            break;
        }
        
        // extract gropu number from group-Type string
        $grp = substr($lineTwo[1], 0, strlen($lineTwo[1]) - 2);
         
        // get group string for email notification
        $group = $titleString[$keys[$grp]];
        
        // join linetwo's seperated values back together as error string
        $index = 0;
        $errorStr = null;
        foreach($lineTwo as $value)
        {
           if($index > 1)
           {
              $errorStr = $errorStr . $value;
           }
           $index = $index + 1;
        }
        
        // insert group title string into email body
        $body =  $lineTwo[0] . " of " . $group . ", " . $errorStr;
     
        
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
    
    $regex = "/^[_A-Za-z0-9-]+(\.[_A-Za-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/"; 

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
    // last edit: 03/02/2015  ebt
?>

