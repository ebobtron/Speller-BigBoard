<?php
/**
*
*   helfun.php  or helper functions for leader board 
*   Robert Clark, aka ebobtron et al.
*   
*   extension of my CS50x final project   winter/spring 2014  with Launch Code
*
*************************************************************/

require "groupstrings.php";

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
            $sql = $sql . "AND grp = :grp OR grp = 0 ORDER BY total ASC";
        }
        else {   
            $sql = $sql . "ORDER BY total ASC";
        }
        $stmt = $dbhandle->prepare($sql);
        $stmt->bindParam(":grp", $data);
    }
    
    //--  GET NEXT ID
    if($what == "nextId") {
    
        $sql = "SELECT MAX(id) FROM leader_board WHERE grp = :grp";        
        $stmt = $dbhandle->prepare($sql);
        $stmt->bindParam(":grp", $data);
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
        
            return ' GETPUT"nameId" - ERROR:..&nbsp;&nbsp; ' . $errorMessage;
        }
    }   
}



/*   DEPRECIATED VERSION
function getPut($what, $data) {
 
    $dbhandle = PDOconnect();
    
  
  //*****           GET ROWS              *****   
  //*******************************************
    
    if($what == "rows") {

        $sql = "SELECT * FROM leader_board WHERE total IS NOT NULL ORDER BY total ASC";

        try {   
            
            $stmt = $dbhandle->prepare($sql);
            $results = $stmt->execute();
            if ($results !== false) {

                $rowdata = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else {

                $rowdata = null;
            }
        }
        catch(PDOException $e) {

            echo 'Leader Board GET ROWS ERROR: ' . $e->getMessage();
        }
        
        // return data
        return $rowdata;
    }

  //*****       GET ID FROM NAME AND NEXT ID      *****  
  //***************************************************

    if($what == "nameId") {

        // get the boards highest id number
        $sql = "SELECT MAX(id) FROM leader_board";

        try {

            $stmt = $dbhandle->prepare($sql);
            $stmt->execute();
            $iddata = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        }
        catch(PDOException $e) {

            echo 'Leader Board GET MAX(ID) ERROR: ' . $e->getMessage();
        }

        // calculate next Id number
        $nextId = (floor($iddata[0]["MAX(id)"] / 10) * 10) + 10;

        // in user name in database get names max(id)
        $sql = "SELECT MAX(id) FROM leader_board WHERE name = :name";

        try {

            $stmt = $dbhandle->prepare($sql);		  
            $stmt->bindParam(":name", $data); 
            $stmt->execute();
            $rowdata = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
        catch(PDOException $e) {

            echo 'Leader Board GET NAME MAX(ID) ERROR: ' . $e->getMessage()."</br>";
        }

        $results = array( "nextId" => $nextId, "lastId" => $rowdata[0]['MAX(id)']);
    
        if($results['lastId'] != null) {

            $id = $results['lastId'] + 1;

            if($id%10 == 0) {

                $results = "Maximum submissions of 10 has been reached for \" ";
                $results = $results.$data." \", sorry!";
        
            }   
        }

        // return data
        return $results;
    }
  
// TODO: add group to data submission 
  
    //  **
    //  *   ADD SUBMISSION ID AND NAME TO DATABASE TO RESERVE ID  
    //  *****************************************************
    
    if($what == "addSub") {	
    
        $msg = 'record added';
        
        $sql = "INSERT INTO leader_board (id, grp, name) VALUES(:id, :grp, :name)";
        
        $tempGroupNum = 1;
        
        //echo "<br>".$id."  ".$data."<br>";
        try {

            $stmt = $dbhandle->prepare($sql);
            $stmt->bindParam(":id", $data['id']);
            
// TODO:    this should use $data['grp']
//          $data comes from  
            $stmt->bindParam(":grp", $tempGroupNum);
            
            $stmt->bindParam(":name", $data['name']);
            $stmt->execute();

        }
        catch(PDOException $e) {

            // echo 'Leader Board ADDSUB ERROR: ' . $e->getMessage();
            $msg = 'Data Base error contact Administrator: ' . $e->getMessage();
      }
    }
  
    if($dbhandle)
        $dbhandle = null;

    return $msg;
}
/******   END GETPUT()  **********/  


/*
 *  createSubInfo()
 *
 *  creates submission info file with data for testing the submissions  
 ***********************************************************************/

function createSubInfo($name, $id, $email) {

    $outFileName = "../uploading/subInfo.txt";
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
 
 *   LOAD SUBMISSION TIMES AND DATA INTO DATABASE   
 **********************************************************/

function updateData($what) { 
    
    $success = true;
    $inFileName = "../minis/newsubdata.txt";
    
    if(!file_exists($inFileName)) {
        
        echo "&nbsp;&nbsp;&nbsp;no submission data, no file \" newsubdata.txt \"<br>";
        $dbhandle = null;
        return;        
    } 
        
    $dbhandle = PDOconnect();

    $sql = "REPLACE INTO `leader_board` VALUES(:id, :grp, :name, :total, :dload,";
    $sql = $sql . " :tcheck, :size, :unload, :mem)";    
    
    $inFileHandle = fopen($inFileName, 'r') or die("can't open file");
    
    try {

        $stmt = $dbhandle->prepare($sql);
        $tempGroup = 1;
        
        while(($data = fgetcsv($inFileHandle, 1000, ",")) !== FALSE) {

            if(!$data[0])
                break;
            printf("adding submission %04u for \" %s \" total time: %04f <br>",
                    $data[0], $data[1], $data[2]);

            $stmt->bindParam(":id", $data[0]);
            
// TODO:    this needs to change to $data[1]
//          and the others need to advance one 
            $stmt->bindParam(":grp", $tempGroup);
            
            $stmt->bindParam(":name", $data[1]);
            $stmt->bindParam(":total", $data[2]);
            $stmt->bindParam(":dload", $data[3]);
            $stmt->bindParam(":tcheck", $data[4]);
            $stmt->bindParam(":size", $data[5]);
            $stmt->bindParam(":unload", $data[6]);
            $stmt->bindParam(":mem", $data[7]);
            
            $stmt->execute();
        }
    }
    catch(PDOException $e) {
        
        $success = false;
        echo 'Leader Board updateData ERROR: ' . $e->getMessage();
    }
    
    unlink($inFileName);
    
    if($dbhandle)
        $dbhandle = null;

    return $success;
}


/*
 *   sendemailNotifications()
 *   SEND NOTIFICATIONS FROM AN UPLOADED FILE
 ****************************************************/   
function sendemailNotifications($mode) {

    $inFileName = "../minis/emailNot.txt";
    
    if(!file_exists($inFileName)) {
        
        echo "<br>&nbsp;&nbsp;&nbsp;no email notification, no file \" emailNot.txt \"";
        return;        
    }
    
    $inFileName = "../minis/emailNot.txt";
    $inFileHandle = fopen($inFileName, 'r') or die("can't open file");
    
    if($inFileHandle == 0) {
        
        echo "No email notification file emailNot.txt";
        return;
    }

    while(true) {
        
        $lineOne = fgetcsv($inFileHandle, 500, ",");
        $lineTwo = fgets($inFileHandle, 500);
     
        if(feof($inFileHandle))
            break;
        
        $result = sendMail($lineOne[0], "ebobtron@aol.com", $lineOne[2], $lineTwo);
        
        echo substr($result, 0, 35).".";
         
        // echo "to: ".$lineOne[0]." subject: ".$lineOne[2]."<br>";
        // echo "message: ".$lineTwo."<br><br>";
    
    }
    unlink($inFileName);
    return;
}


/*
 *  validName()
 *  replace white spaces from names D Doug becomes D_Doug
 *****************************************************************/
function validName($name) {
   
    return preg_replace('/\s+/', '_',$name);

}

/*
 *  validEmail()
 *  validate email address
 **********************************/
function validEmail($email) {
    
    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 

    if(preg_match($regex, $email)) {
     
        return $email;
    }
    else {
        
        return null;
    }
    
}


/****  CLEAN SUBMISSIONS UPLOADING  ****/
/***************************************/
function dumpSubmissions() {
    
    if(file_exists("../uploading/subInfo.txt")) {
        
        unlink("../uploading/subInfo.txt");
    }
    
    $files = glob("../uploading/*");
    $newfileName = null;
    
    foreach($files as $file) {
          
        $newfileName = "../dump/".basename($file);
        
        if(is_file($file)) {
            
            copy($file, $newfileName);
            echo "<br>  moved to the dump, the file: ".$newfileName;
            unlink($file);
        }
    }
    
    return;
}

/****  GET GROUP NUMBER  ****/
/****************************/
function getGroupNumber($grpName){
    // set filename and attempt to open
    $filename = "../grps.json";

    if (file_exists($filename)) {
        $file = fopen($filename, "r");
    }

    // error check
    if $file {
        // set group number from data
        $json = json_decode(fread($file, filesize($filename)), true);
        $grp = $json[$grpName];

        fclose($file);
    }
    else {
        // default
        $grp = null;
    }
    
    return $grp;
}

?>

