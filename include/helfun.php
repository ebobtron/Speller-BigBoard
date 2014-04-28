<?php

		/********       Pear Mail      **********/
require_once "Mail.php";

function sendMail($to, $cc, $subject, $body)
{
		require_once "config.php";
		
		$from = "leader board <".$username.">";
		  
	 	$recipients = $to.",".$cc.",".$bcc;
	 	
		$headers = array ('From' => $from,
    		              'Cc' => $cc,
											'Return-Path' => $username,
											'To' => $to,
											'Subject' => $subject);
											
		/*	Blind Carbon Copy left from $headers to make it blind			 								 
	      'Bcc' => $bcc,
		********************************/
		
		$params = array('host' => $host,
		                'port' => $port, 
										'auth' => true,
										'username' => $username,
										'password' => $pwd);
														 
		$smtp = Mail::factory('smtp', $params);
 
		$mail = $smtp->send($recipients, $headers, $body);
 
		if(PEAR::isError($mail))
	 	{
			echo("<p>Nothing to worry about, someone is not going to get an email</p>");
			echo("<p>" . $mail->getMessage() . "</p>");
			return false;
		}
		else
		{
			echo("<p>Message successfully sent!</p>");
			return true;
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

function PDOconnect()
{
    require_once "config.php";

  	$dsn = 'mysql:host='.$dbpath.';dbname='.$dbuser;
	  $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 

    try
	  {
	  		$dbhan = new PDO($dsn, $dbuser, $dbpass, $options);
	  		$dbhan->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	}
		catch(PDOException $e)
		{
    		echo 'SLB - ERROR: ' . $e->getMessage();
  	}
    return $dbhan;
}


function get($what, $data)
{
	
	if(!$dbhandle)
		$dbhandle = PDOconnect();
	
		/*****  GET ROWS   ********/
		/**************************/
	if($what == "rows") {
				
		$sql =
		  "SELECT * FROM leader_board WHERE total IS NOT NULL ORDER BY total ASC";
		
		try
		{   
    		$stmt = $dbhandle->prepare($sql);
    		$results = $stmt->execute();
				if ($results !== false)
				{
				   $rowdata = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
				else
				{
				   $rowdata = null;
				}
		}
		catch(PDOException $e)
		{
    		echo 'Leader Board GET 1 ERROR: ' . $e->getMessage();
		}
		// return data
		return $rowdata;
	}		 
	
     /*****     GET ID FROM NAME  ADD TO DATABASE  ***********/
		 /********************************************************/
	if($what == "nameId") {

		$sql = "SELECT MAX(id) FROM leader_board";
		
		try {
		   
    	$stmt = $dbhandle->prepare($sql);
    	$stmt->execute();
    	$iddata = $stmt->fetchAll(PDO::FETCH_ASSOC); 
		}
		catch(PDOException $e) {
		
    	echo 'Leader Board GET 2 ERROR: ' . $e->getMessage();
		}
		
		$nextId = (floor($iddata[0]["MAX(id)"] / 10) * 10) + 10;
		
		$sql = "SELECT MAX(id) FROM leader_board WHERE name = :name";
		
		try {

		  $stmt = $dbhandle->prepare($sql);		  
			$stmt->bindParam(":name", $data); 
    	$stmt->execute();
			$rowdata = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
		}
		catch(PDOException $e) {

    		echo 'Leader Board GET 3 ERROR: ' . $e->getMessage()."</br>";
		}
					
		$results = array( "nextId" => $nextId,
								      "lastId" => $rowdata[0]['MAX(id)']);
		
		$sql = "INSERT INTO leader_board (id, name) VALUES(:id, :name)";
		
		if($results['lastId'] != null) {
			
			$id = $results['lastId'] + 1;
			if($id%10 == 0)
			  return "Maximum submissions of 10 has been reached for \" ".$data." \", sorry!";
		}
		else {
			
			$id = $results['nextId'] ;
		}
		
		//echo "<br>".$id."  ".$data."<br>";
		try {
		   
    	$stmt = $dbhandle->prepare($sql);
			$stmt->bindParam(":id", $id);
			$stmt->bindParam(":name", $data);
    	$stmt->execute();
    	# Affected Rows?
      //echo $stmt->rowCount(); // 1
			 
		}
		catch(PDOException $e) {
		
    	echo 'Leader Board GET 4 ERROR: ' . $e->getMessage();
		}									
		
		// return data
		return $results;
	}
	return;
}
	
function	createSubStat($name, $id, $email) {
		
	$outFileName = "../uploading/subStat.txt";
  $outFileHandle = fopen($outFileName, 'a') or die("can't open file");
  $outString = $name.",".$id.",".$email."\n";
	if($outFileHandle) {
	
		fwrite($outFileHandle, $outString); 
		fclose($outFileHandle);
	}
}

			
?>
