<?php 

    
  date_default_timezone_set('America/Chicago'); //America/Chicago
  echo date("l F j, Y @ g:i:s a T") . "<br>";
  
  
  //print_r($_POST);

  include('../include/helfun.php');
  

  
    $dbhandle = PDOconnect();
  
      // set some common variables
    $stmt = null;
    $results = null;
    
    // MySQL statement
    $sql = "select id, grp, name, min(total) as total, dload, tcheck, size, unload, ".
             "mem, typ from leader_board group by name order by total";
    
    /**
            [id] => 47
            [grp] => 3
            [name] => AlexGierczyk
            [total] => 0.1982
            [dload] => 0.0606
            [tcheck] => 0.1209
            [size] => 0
            [unload] => 0.0176
            [mem] => 7.09676
            [typ] => Hash Table
    
     **/
     
    
            
    
    // prepare the statement and get statement object // 
    $stmt = $dbhandle->prepare($sql);
    
    // bind parameter to variable name for a statement object
    //$stmt->bindParam(":grp1", $group);
    //$stmt->bindParam(":name", $name);
    
    
    // execute or catch the error
    try {     
        // if execute successful fetch results as associative array
        if($stmt->execute() !== false) {
        
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    catch(PDOException $error) {

        // return the error message
        $err = $error->getMessage();
        print($err);
    }
  
    print_r($results);
    
    $str =  "ne,w d,og,";
    
    $str = preg_replace('/,/', '', $str);
    
    print("<br>".$str);
    
   
?>

 
