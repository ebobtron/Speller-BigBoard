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
    		echo 'ERROR: ' . $e->getMessage();
  	}
    return $dbhan;
}


function rows()
{
		$rowdata;
		
		$dbhandle = PDOconnect();
		
		$sql = "SELECT * FROM leader_board ORDER BY total ASC";
		
		try
		{   
    		$stmt = $dbhandle->prepare($sql);
    		$stmt->execute();

    		while( $row = $stmt->fetch() ){
						
						$rowdata [] = $row;
				}
		}
		catch(PDOException $e)
		{
    		echo 'Leader Board ERROR: ' . $e->getMessage();
		}
		
		// close database connection and return data
		$dbhandle = null;
		return $rowdata;		 
}

function nextID()
{	
		$dbhandle = PDOconnect();
		
		$sql = "SELECT MAX(id) FROM leader_board";
		
		try
		{   
    		$stmt = $dbhandle->prepare($sql);
    		$stmt->execute();

    		$row = $stmt->fetch(); 
				//print_r($row);
		}
		catch(PDOException $e)
		{
    		echo 'Leader Board ERROR: ' . $e->getMessage();
		}
		
		$nextId = (floor($row["MAX(id)"] / 10) * 10) + 10;
		
		// close database connection and return data
		$dbhandle = null;
		return $nextId;
}
			
?>
