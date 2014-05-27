

<?php 

            
    $template = "grpselform.php";
    
            // render header
            require("../template/header.php");
    
    print_r($_POST);
    
            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php"); 


?>