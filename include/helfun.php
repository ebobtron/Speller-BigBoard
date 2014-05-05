<?php
/***
*
*   helfun.php  or helper functions for leader board 
*   Robert Clark, aka ebobtron
*   CS50x final project   winter/spring 2014  with Launch Code
*
*************************************************************/

		/********       Pear Mail      **********/
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


        /*  Blind Carbon Copy left from $headers to make it blind
        *   'Bcc' => $bcc,
        ********************************/

    $params = array('host' => $host,
                    'port' => $port, 
                    'auth' => true,
                    'username' => $username,
                    'password' => $pwd);

    $smtp = Mail::factory('smtp', $params);

    $mail = $smtp->send($recipients, $headers, $body);

    if(PEAR::isError($mail)) {
    
        $mes = "<br><br>Nothing to worry about, someone is not going to get an email";
        $mes = $mes . "<br>" . $mail->getMessage();
        
        return $mes;
    }
    else {
        
        return "<br>A message was successfully sent to the administrator about this                 submission!";
    }
}


/*       DEPRECIATED FUNCTION                               
**********************************************************
function opentable()
{
	require_once "config.php";
	$dbh = mysql_connect($dbpath, $dbuser, $dbpass);
	if(!$dbh || !mysql_select_db($dbuser) )
	{
		echo "<p style='background-color: yellow;'>";
		echo "mysql_connect failed -- or -- <br>";
		echo "mysql_select_db failed<br>";
	}
	else
	{
		return $dbh;
	}           
}
*************************************************************/

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


function getPut($what, $data) {

    
    $dbhandle = PDOconnect();
    

/*****  GET ROWS   ********/
/**************************/
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

/*****     GET ID FROM NAME AND NEXT ID  ***********/
/********************************************************/
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

/*******   ADD SUBMISSION ID AND NAME TO DATABASE TO HOLD ID   ************/
/**************************************************************************/
  if($what == "addSub") {	
    
    $msg = 'record added';
    $sql = "INSERT INTO leader_board (id, name) VALUES(:id, :name)";
		
		//echo "<br>".$id."  ".$data."<br>";
		try {
		   
    	$stmt = $dbhandle->prepare($sql);
			$stmt->bindParam(":id", $data['id']);
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


/**
*  creates submission info file with data for testing the submissions
*  and returning the info to the submitters
*
*********************************************************************/

function createSubInfo($name, $id, $email) {
		
    $outFileName = "../uploading/subInfo.txt";
    $outFileHandle = fopen($outFileName, 'a') or die("can't open file");
    $outString = $name.",".$id.",".$email."\n";
	  
    if($outFileHandle) {
	
		    fwrite($outFileHandle, $outString); 
		    fclose($outFileHandle);
	  }
}

function updateData($what) {
  
  if(!$dbhandle)
		$dbhandle = PDOconnect();
  
  $sql = "REPLACE INTO `leader_board` VALUES(:id, :name, :total, :dload,
           :tcheck, :size, :unload, :mem)";
           
	$inFileName = "../minis/newsubdata.txt";
  $inFileHandle = fopen($inFileName, 'r') or die("can't open file");
  try {

    $stmt = $dbhandle->prepare($sql);
  	fscanf($inFileHandle,"%u%s%f%f%f%f%f%f",$a,$b,$c,$d,$e,$f,$g,$h);
    
  while(!feof($inFileHandle)) {
    
    $stmt->bindParam(":id", $a);
    $stmt->bindParam(":name", $b);
    $stmt->bindParam(":total", $c);
    $stmt->bindParam(":dload", $d);
    $stmt->bindParam(":tcheck", $e);
    $stmt->bindParam(":size", $f);
    $stmt->bindParam(":unload", $g);
    $stmt->bindParam(":mem", $h);
    $stmt->execute();
    
    fscanf($inFileHandle,"%u%s%f%f%f%f%f%f",$a,$b,$c,$d,$e,$f,$g,$h);
    printf("adding submission %04u for \" %s \" total time: %04f \n",$a,$b,$c);
    echo"<br>";
  }

  }
  catch(PDOException $e) {

    echo 'Leader Board admin 4 ERROR: ' . $e->getMessage();
  }

  return;

}
?>

