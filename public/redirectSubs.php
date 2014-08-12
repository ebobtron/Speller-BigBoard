
<?php

    $files = glob("../uploading/*");

    if(empty($files))
    {
        echo "....   Server Reports: no submission files found..\n";
        exit;
    }

    if(fopen("../minis/alt_load.txt", "w"))
    {
        echo "....   Server Reports: submission files will be redirected during testing..\n";
    }

?>
