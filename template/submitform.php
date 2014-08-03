<!--
 **
 *
 *   submitform.php  user interfaces to upload file
 *
 *   Robert Clark, aka ebobtron el al.
 *
 *   CS50x final project   winter/spring 2014  with Launch Code
 *
 *************************************************************    -->

<div class="gentext">
  
  <h2> file submission continued </h2>
    
    group: <?=$title?><br />
    submitters name: <?=$name?><br />
    submitters email: <?=$_POST['email']?><br />
    <br />

    <form enctype='multipart/form-data' action='uploadfile' method='POST'>
        <input type='hidden' name='MAX_FILE_SIZE' value='48000' />

        Please upload <big><big> "speller"</big></big> not speller.c, thank you.<br />
        <br />
        <big><b>Click Browse to Select File to Upload:</b></big><br />
            <input type='file' name='uploadedfile' /><br />
        <br />
        
        <fieldset style="border:2px solid #3399ff;width:50%;border-radius: 10px">
        <legend>&nbsp;Type Data Structure Used&nbsp;</legend>
        <input type="hidden" name="type" value="0">
        <input type="radio" name="type" value="1">Hash Table
        <input type="radio" name="type" value="2">Trie
        <input type="radio" name="type" value="3">Other
        </fieldset>
        <!--  -->
        <br />
        <input type='hidden' name='name' value='<?=$name?>' />
        <input type='hidden' name='group' value='<?=$group?>' />
        <input type='hidden' name='email' value='<?=$_POST['email']?>' />
        
        <input type='submit' value='submit' style='font-size:20px' />
        
    </form>
    <br />

</div>
