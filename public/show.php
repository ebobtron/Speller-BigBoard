

<?php

    require_once "../include/helfun.php";
    
    // TODO:
    // add session / cookie code here to direct viewer to last
    // group viewed or redirect to group selection page.
    
    // TODO: assign group from cookie
    $group = null;
    
    // tell the user which group they are looking at
    $title = $group;

    // get table rows from display
    $rows = getPut("rows", $group);

    $template = "table.php";

            // render header
            require("../template/header.php");

            // render template
            require("../template/$template");

            // render footer
            require("../template/footer.php");


?>

