

<?php
    
    require_once "../include/helfun.php";

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
                //echo "new user ".$name." get new Id of ".$newId['nextId']."<br>";
                createSubInfo($newId['nextId'], $name, $email);
            }
            else {

                $id = $newId['lastId'] + 1;
                //echo $name." gets new Id of ".$id."<br>";
                createSubInfo($id, $name, $email);
            }
        }
        else {  

            $error = true;
        }
        // TODO:  fix this 
        $template = "construction.php";

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

