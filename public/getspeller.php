
<?php 
	
	require_once "../include/helfun.php";
  
	if ($_POST['magword'] != "launchcode")
	{
		// if not magicword stay on the page.
 
    $template = "getspellerform.html";
	     
		        // render header
            require("../template/header.php");

            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php");
	}
	else
	{
	 
		
		// good magicword continue submission
		$name = $_POST['name'];		  
		$email = $_POST['email'];
		
		// create new entry in DB and return ids or errors
		$newId = get("nameId",$name);
		
		if(is_array($newId)) {
			
			if ($newId['lastId'] == null) { 
	     
			 	$id = $newId['nextId'];
				//echo "new user ".$name." get new Id of ".$newId['nextId']."<br>";
			 	createSubStat($newId['nextId'], $name, $email);
			}
			else {
			
		   	$id = $newId['lastId'] + 1;
			 	//echo $name." gets new Id of ".$id."<br>";
				createSubStat($id, $name, $email);
			}	
		}
		else {
		
			$error = true;
		}	  
		$template = "submitform.php";
	     
		        // render header
            require("../template/header.php");
             
						if($error) { 
						   
							 echo "<br><br><br><br><br><br>";
							 echo " &nbsp; &nbsp; &nbsp; ".$newId;
							 echo "<br><br><br><br><br><br>";
						}
						else {
						
						  //render template
              require("../template/$template");
						}

            // render footer
            require("../template/footer.php");	
	}
	
	
	?>
	