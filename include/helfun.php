<?php
/*
       helfun.php    helper functions for leader board  
  
       copyright 2015 Robert Clark(aka ebobtron), et al.

       an expansion of my edX.org CS50x final project
       winter/spring 2014  with Launch Code                               ******/
       

require "config.php"; 

require "groupstrings.php";

error_reporting(E_ALL & ~E_STRICT);

// set default timezone, dah!
date_default_timezone_set('America/Chicago');


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

  
/**  getput()
  *
  *  DATABASE FUNCTIONS  NO ON THE FLY SQL STATEMENTS        
  *
  ******************************************************************************/

function getPut($what, $data) {
 
    //--  connect to the database
    $dbhandle = PDOconnect();
    
    //-- set some common variables default values
    $stmt = null;
    $results = null;
    $errorMessage = null;
    $sql = null;
    $sort = "total ASC";
    
    //--  get unique or all   
    //--  if $data = group number, returns group number and group zero("0") Staff
    //--  if $data = null(no grp selection at all), returns all groups
    //--  confine $data to "null" or numeric symbols 0, 1, 2, 3 etc.
    
    //-- SORT COLUMN ORDER BY what[1] from viewer clicking table header 
    if(isset($what[1])) {
    
        if($what[1] === "tsortu")
            $sort = "total ASC";
        if($what[1] === "tsortd")
            $sort = "total DESC";
            
        if($what[1] === "nsortu")
            $sort = "LOWER(name) ASC, total ASC";
        if($what[1] === "nsortd")
            $sort = "LOWER(name) DESC, total ASC";
            
        if($what[1] === "lsortu")
            $sort = "dload ASC";
        if($what[1] === "lsortd")
            $sort = "dload DESC";
            
        if($what[1] === "csortu")
            $sort = "tcheck ASC";
        if($what[1] === "csortd")
            $sort = "tcheck DESC";
        
        if($what[1] === "usortu")
            $sort = "unload ASC";
        if($what[1] === "usortd")
            $sort = "unload DESC";
            
        if($what[1] === "tysortu")
            $sort = "typ ASC";
        if($what[1] === "tysortd")
            $sort = "typ DESC";
            
        $sort = "ORDER BY " . $sort;            
    }
    
    //-- get all submissions or unique sumbissions
    if($what[0] === 'unique' || $what[0] === 'all') {
           
        // either group plus group 0 or all submission on the table.
        // default is mostly group 3 edX.org         
        if($data !== null) {
            $sql_grp = "AND grp = :grp0 OR grp = 0 ";
        }
        else {   
            $sql_grp = null; 
        }
        // the unique table requires a JOIN to keep a sumbission's data together
        $uni_sel = "SELECT DISTINCT s.* FROM leader_board s ".
                   "JOIN (SELECT min(total) AS total ".
                   "FROM leader_board WHERE total IS NOT NULL ";
        
        // the unigue GROUP BY
        $uni_grp_by = "GROUP By name, typ) ";
        
        // build the 'unique' sql string or the 'all' sql string.
        if($what[0] === 'unique'){
            $sql = $uni_sel . $sql_grp . $uni_grp_by;
            $sql = $sql . "min ON s.total = min.total " . $sort;
        }    
        else {
            $sql = "SELECT * FROM leader_board WHERE total IS NOT NULL ";
            $sql = $sql . $sql_grp . $sort;
        }
        
        // perpare data for execution
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
    
    //--   COMMON VALID DATA TEST
    if($stmt === null) {
        return " GETPUT parameter 1 invalid";
    }
       
    //--  COMMON TRY EXECUTE CATCH  ----
    try {     
        
        if($stmt->execute() !== false) {
        
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    catch(PDOException $error) {

        $errorMessage = $error->getMessage();
    }
        
    //--  return results for 'all' and 'unique'
    if($what[0] === 'all' || $what[0] === 'unique'){
    
        if($errorMessage === null)
        {
            return $results;
        }
        else
        {
            return ' GETPUT"rows" - ERROR:..&nbsp;&nbsp; ' . $errorMessage;
        }    
    }
    
    //--  return results for "nextId"
    if($what == "nextId") {
    
        if($errorMessage === null) {
        
            return array("nextId" => $results[0]['MAX(id)']+1);
        }
        else {
        
            return ' GETPUT"nextId" - ERROR:..&nbsp;&nbsp; ' . $errorMessage;
        }
    }
    
    //--  return results for "subNames"
    if($what == "subNames") {
    
        if($errorMessage === null) {
            
            return $results;
        }
        else {
        
            return ' GETPUT"subNames" - ERROR:..&nbsp;&nbsp; ' . $errorMessage;
        }
    }

}   // end function getpout() //

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


/**   updateData()
  *
  *   LOAD SUBMISSION DATA INTO DATABASE  
  *
  ******************************************************************************/

function updateData($text)
{    
    // get the group names and data identifiers
    include "groupstrings.php";
    
    // define a database result
    $result = false;
    
    // default success - thinK positive
    $success = true;
    
    // resultString to return;
    $resultString = null;
    
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
            $result = $stmt->execute();
            
            // output admin data
            if(!$text)
            {
                $resultString = $resultString .
                sprintf("adding %04u for group %u name: \" %s \" total time: %04f <br>",
                         $return['nextId'], $data[0], $data[1], $data[2]);
            }
            else
            {
                $resultString = $resultString .
                sprintf("adding %04u for group %u name: \" %s \" total time: %04f \n",
                         $return['nextId'], $data[0], $data[1], $data[2]);
            }
            
            // build some source and destination strings for moving submission files
            // to a final resting place
            $oldFileName = $data[1] . $data[0] . '-' . $type . 'speller.x';
            $newFileName = $oldFileName . $return['nextId'];

            // move submitter's files to the dump if it exists
            // under certain automation testing methods the file may not exist
            // if submitter is not on the board or the latest submission fails the
            // file well move to the dump and replace any file already there.  The
            // dump contains files on the board or last failure. 
            if(file_exists('../uploading/' . $oldFileName))
            {
                dumpSubmissions($oldFileName, $newFileName);
            }       
        }
    }
    catch(PDOException $error)
    {    
        // success is not true / echo error message
        $success = false;
        echo 'Leader Board updateData ERROR: ' . $error->getMessage();
    }
    
    // clean up files and move to dump if no data was uploaded
    unlink($inFileName);
    dumpSubmissions(0,0);
    moveSubmissions();
    
    // close database connection if open
    if($dbhandle)
        $dbhandle = null;

    // return $resultString on success or false 
    if($success)
    {
        return $resultString;
    }
    else
    {
        return false;
    }
}


/*
 *   sendemailNotifications()
 *   SEND SUBMISSION NOTIFICATIONS FROM DATA IN AN UPLOADED FILE
 ****************************************************************/   
function sendemailNotifications($mode) {

    $endofline = '<br>';
    if($mode)
    {
        $endofline = "\n";
    }
    
    include("groupstrings.php");
    
    // string for return
    $success_string = null;
     
    // submission data uploaded from submission testing
    $inFileName = "../minis/emailNot.txt";
    
    // in no email notification file complain and then return
    if(!file_exists($inFileName))
    {    
        return "...no email notifications sent, no file \" emailNot.txt \"";       
    }
    
    // open submission notification file or die
    $inFileHandle = fopen($inFileName, 'r') or die("can't open file");
    
    // on error return complain
    if(!$inFileHandle)
    {    
        return "...Can not open file emailNot.txt";
    }
    
    // get array keys by position number
    $keys = array_keys($titleString);
    
    // loop through submission notification file until end
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
        
        // extract group number from group-Type string
        $grp = substr($lineTwo[1], 0, strlen($lineTwo[1]) - 2);
         
        // get group string for email notification
        $group = $titleString[$keys[$grp]];
        
        // join line two's separated values back together as error string
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
        $success_string = $success_string . '...    ' . substr($result, 5, 55) . "." .
        $endofline;
    
    }

    // delete the file
    unlink($inFileName);
    
    // pretty much self explainatory don't you think
    return $success_string;
}

/*
 *  validName()
 *  replace white spaces in names i.e. "D Doug" becomes "D_Doug"
 *****************************************************************/
function validName($name) {
   
    return preg_replace("/\s+/", "_",$name);
}

/*
 *  validEmail()
 *  validate email address
 **********************************/
function validEmail($email) {

    // regular expression from theB264
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
            echo "found new submission file: ".$newfileName . "<br>";
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

/**   sendMail()
  *   
  *   using Pear Mail    http://pear.php.net/package/Mail
  * 
  *   the regular PHP email functions don't allow for authentication
  *
  *   att.net and some other incoming mail servers require that 
  *   the sending client authenticate the sender, i.e. user id and password
  *           
  *****************************************************************************/
  
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
        $mes = "<br><br>An email server / script error has occurred.&nbsp; " .
               "Error message is: ";
        return $mes . "<br>" . $mail->getMessage();
    }
    else
    {   
        return "<br>A message was successfully sent to the leader board administrator ".
               "about this submission!";
    }
}


/**   subCount($name, $group)
  *
  *   get submission count for a user name and group number
  *
  ******************************************************************************/

function subCount($name, $group){
    
    // connect to database server and return handle
    $dbhandle = PDOconnect();
    
    // set some common variables
    $stmt = null;
    $results = null;
    
    // MySQL statement
    $sql = "SELECT count(*) FROM leader_board WHERE grp = :grp1 AND " .
           "name = :name";        
    
    // prepare the statement and get statement object
    $stmt = $dbhandle->prepare($sql);
    
    // bind parameter to variable name for a statement object
    $stmt->bindParam(":grp1", $group);
    $stmt->bindParam(":name", $name);
    
    // execute or catch the error
    try {     
        // if execute successful fetch results as associative array
        if($stmt->execute() !== false) {
        
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    catch(PDOException $error) {

        // return the error message
        return $error->getMessage();
    }
    // return contents of two dimensional array
    return $results[0]['count(*)'];
}


/*   some up / down arrow charactors   */
$upmark = '&#x25B2;';
$downmark = '&#x25BC;';


?>
