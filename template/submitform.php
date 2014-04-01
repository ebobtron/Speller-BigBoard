
<div>

<blockquote style="font-size:22">
<h2> file submission </h2>
<?php 
  if ($_POST['majword'] != "launchcode")
	{
		echo "
  	<form action='submit.php' method='post'>
  	<p>
    	Please provide the magic word:
			<input type='text' name='majword'>
  	</p>
  	<p>
		  If your resubmitting or adding a second add your id to your name.<br> 
    	Your name or reddit ID in one word \"TerryLF\" or \"DonJones2010\":
    	<input type type='text' name='name'>
  	</p>
		<p>
    	Your email address if I have trouble with your file: 
    	<input type type='text' name='email'>
  	</p>
  	<input type='submit' value='continue'>
  	</form> ";
	}
	if ($_POST['majword'] == "launchcode")
	{
		echo " submiters name: ",$_POST['name'],"<br>"; 
		echo " submiters email: ",$_POST['email']; 
	
		echo "
  	<form enctype='multipart/form-data' action='getfile.php' method='POST'>
  	<input type='hidden' name='MAX_FILE_SIZE' value='25000'>
		<p>Please send <h3> \"speller\"</h3> not speller.c, thank you.<br><br>
    	 Select File to Upload: <input type='file' name='uploadedfile'>
		</p>
  	<input type='hidden' name='name' value='",$_POST['name'],"'>
		<input type='hidden' name='email' value='",$_POST['email'],"'>
 	 	<input type='submit' value='submit'>
  	</form>";
	}
	/* print_r($_POST); */
?>

</blockquote>
</div>
 		