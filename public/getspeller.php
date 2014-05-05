
<?php
/***
*
*   getspeller.php  user interfaces to upload file
* 
*   Robert Clark, aka ebobtron
*   CS50x final project   winter/spring 2014  with Launch Code
*
*************************************************************/

    require_once "../include/helfun.php";

    $error = false;
    
    if(!array_key_exists('magword', $_POST)) {
        $_POST = array('magword' => null);
    }    
        
    if($_POST['magword'] != "launchcode") {

        // if not magicword stay on the getspeller form
        $template = "getspellerform.html";

            // render header
            require("../template/header.php");

            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php");
    }
    else {

        // good magicword continue submission
        $name = $_POST['name'];
        $email = $_POST['email'];

        // return id from the submisson name or the next id
        $newId = getPut("nameId",$name);
        
        if(is_array($newId)) {
        
            if($newId['lastId'] == null) {
            
                $id = $newId['nextId'];
            }
            else {

                $id = $newId['lastId'] + 1;
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

            // render template
            require("../template/$template");
        }

        // render footer
        require("../template/footer.php");	
    }


?>

