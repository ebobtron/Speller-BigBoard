

<?php 
    
    $cookie_name = 'leaderboard_cookie';
    $cookie_time = time() + (24 * 60 * 60 * 365); // about a year
    
    if(isset($_POST['group'])) {
        
        $cookie_value = $_POST['group'];
        setcookie($cookie_name, $cookie_value, $cookie_time, '/');                
    }
    
    if(isset($_COOKIE[$cookie_name])) {
        
        echo $_COOKIE[$cookie_name]."<br>";
        print_r($_COOKIE);
    }
            
    $template = "grpselform.php";
    
            // render header
            require("../template/header.php");
    
            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php"); 

?>