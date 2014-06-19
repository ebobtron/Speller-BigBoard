<!-- 
***
*
*   tabel_all.php  Display table of submissions and links
* 
*   Robert Clark, aka ebobtron et al.
*
*   extension of my CS50x final project   winter/spring 2014  with Launch Code
*
*************************************************************   -->

<div class="lnk">

    <p style="display: inline;">

    <!-- $_GET  ? r = gt means a group table -->
    <a class="menu" href="../public/grpsel.php" title="click to submit your speller">
        Submit Your Program&nbsp;</a>
    </p>


    &middot;

    <p style="display: inline;">
        <a class="menu" href="criteria.php">&nbsp;Test Criteria&nbsp;</a>
    </p>

    &middot;

    <p style="display: inline;">
        <a class="menu hover" href="download.php">&nbsp;Download "test"&nbsp;</a>
    </p>

    &middot;

    <p style="display: inline;">

        <a class="menu hover" href="grpInfo.php">&nbsp;Groups</a>
    </p>

</div>

<div class="div-table">

  <h3 style="margin:0px">all times in seconds</h3>

  <table class='table-all'>
    <thead class="thead">
      <tr>
        
        <th class="th">name</th>
        <th class="th">total time</th>
        <th class="th" style='width:50%'>group</th>
      </tr>
    </thead>
    <tbody class="tbody ldbd-tbody">

<?php

    $loop = 0;

    foreach($rows as $row){

        if($loop % 2 == 0)
            echo " <tr class='row'> ";
        else
            echo " <tr> ";

        $total = sprintf("%0.4f", $row['total']);
        
        $keyNum = $row['grp'];  	
        $groupName = $titleString[$keys[$keyNum]];

        $grp = sprintf("%8s", $groupName);

        echo"
            <td class='td-all'>", $row['name'], "</td>
            <td class='td-all'>", $total, "</td>
            <td class='td td-allgrp'>", $grp, "</td>
            </tr>
            ";

        $loop++;
    }
  
?>
    </tbody>
  </table>
</div><br>
