<!--
***
*
*   submitform.php  user interfaces to upload file
*
*   Robert Clark, aka ebobtron
*   CS50x final project   winter/spring 2014  with Launch Code
*
*************************************************************    -->

<div class="gentext">
  
  <h2> file submission continued </h2>
    
    group: <?=$title?><br>
    submitters name: <?=$name?><br>
    submitters email: <?=$_POST['email']?><br>
    <br>
    <br>

<!--    
// submission Id will be issued when valid data added to table
    echo " this submissions id: ",$id,"<br />";  --> 
    

    <form enctype='multipart/form-data' action='uploadfile.php' method='POST'>
        <input type='hidden' name='MAX_FILE_SIZE' value='25000'>

        Please upload <h3> "speller" </h3> not speller.c, thank you.<br>
        <br>
        Click Browse to Select File to Upload: <input type='file' name='uploadedfile'><br>
        <br>

        <input type='hidden' name='name' value='<?=$name?>'>
        <input type='hidden' name='group' value='<?=$group?>'>
   <!-- <input type='hidden' name='id' value='",$id,"'>     -->
        <input type='hidden' name='email' value='<?=$_POST['email']?>'>
        
        <input type='submit' value='submit' style='font-size:20px'>
        
    </form>
    <br>

</div>
