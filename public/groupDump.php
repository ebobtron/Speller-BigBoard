<?php

    header("location: /");
    
    exit;
    
    include "../include/helfun.php";
 
    $mySQL_Handle = PDOconnect();
    
    $grp = 6;
    
    $rows = getPut("rows", $grp);
    
    $outFileHandle = fopen('../include/archive2014/rows_0.txt', 'w');
    
    foreach ($rows as $row)
    {
       $line = $row['name'].",".$row['total'].",".$row['dload'].",".$row['tcheck'].",".
               $row['size'].",".$row['unload'].",".$row['mem'].",".$row['typ']."\r\n";
       fwrite($outFileHandle, $line);
    }
    
    echo "done";
    
?>