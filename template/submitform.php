<!--
/***
*
*   submitform.php  user interfaces to upload file
*
*   Robert Clark, aka ebobtron
*   CS50x final project   winter/spring 2014  with Launch Code
*
*************************************************************/
-->

<div class="gentext">

  <h2> file submission continued </h2>
  

  <?php 
    
    echo " group: ",$title,"<br />";

    echo " submitters name: ",$name,"<br />";
    echo " this submissions id: ",$id,"<br />"; 
    echo " submitters email: ",$_POST['email']; 

    echo "
        <form enctype='multipart/form-data' action='uploadfile.php' method='POST'>
            <input type='hidden' name='MAX_FILE_SIZE' value='25000'>

            <p>Please send <h3> \"speller\"</h3> not speller.c, thank you.<br /><br />
               Select File to Upload: <input type='file' name='uploadedfile'></p>

            <input type='hidden' name='name' value='",$name,"'>
            <input type='hidden' name-'grp' value='",$grp,"'>
            <input type='hidden' name='id' value='",$id,"'>
            <input type='hidden' name='email' value='",$_POST['email'],"'>
            <input type='submit' value='submit' style='font-size:20px'>
        </form>";
  ?>

<br />

</div>

