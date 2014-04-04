
<div>

<blockquote style="font-size:20">
<h2> file submission </h2>
<?php 


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
	
	  /* print_r($_POST); */
?>

</blockquote>
</div>
 		