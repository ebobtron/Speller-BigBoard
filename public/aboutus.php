<?php 
    
    require '../include/helfun.php';
    
    // get group keys from tileString array
    $keys = array_keys($titleString);
    
    // set the group description strings for this page
    $title = $titleString[$keys[1]];
    $head = $headString[$keys[1]];
    $link = $linkString[$keys[1]];
 
    // render header
    require('../template/header.php');

    // render template
    require('../template/aboutus_view.php');

    // render footer
    require('../template/footer.php');

?>
