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
  <a class="menu" href="../public/grpsel.php?r=ta" title="click to submit your speller">
        Submit Your Program&nbsp;</a></p>


&middot;

<p style="display: inline;">
<a class="menu" href="criteria.php">&nbsp;Test Criteria&nbsp;</a></p>

&middot;

<p style="display: inline;">
<a class="menu hover" href="download.php">&nbsp;Download "test"&nbsp;</a></p>

&middot;

<p style="display: inline;">&nbsp;Groups
<!--
<a class="menu hover" href="">&nbsp;Download "test"&nbsp;</a>
-->
</p>

</div>

<div class="div-table">

<h3 style="margin:0px">all times in seconds</h3>

<table class="table">
 <thead class="thead">
  <tr>
	 <th class="th"></th>
	 <th class="th">name</th>
	 <th class="th">total time</th>
   <th class="th" style='width:40%'>group</th>

 
  </tr>
</thead>
<tbody class="tbody ldbd-tbody">

<?php
  $loop = 0;
	foreach($rows as $row)
	{
		if($loop % 2 == 0)
		  echo " <tr class='row'> ";
		else
		  echo " <tr> ";
    
    $keyNum = $row['grp'];  	
    $groupName = $titleString[$keys[$keyNum]];
		
    $grp = sprintf("%8s", $groupName);
    
		$to = sprintf("%0.4f", $row['total']);


		echo"
    <td class='td'></td>
		<td class='td'>",$row['name'],"</td>
		<td class='td'>",$to,"</td>
    <td class='td' style='width:30%;font-family:Arapey_Italic;font-size:14pt'>",$grp,"</td>
    <td class='td'></td>

		</tr>";

		$loop++;
	}
	/*
    <th class="th">load time</th>
	  <th class="th">check time</th>
    <th class="th">size time</th>
	  <th class="th">unload time</th>
	  <th class="th">heap used</th>
    
    $ld = sprintf("%0.4f", $row['dload']);
		$ck = sprintf("%0.4f", $row['tcheck']); 
		$sz = sprintf("%0.4f", $row['size']);
		$ul = sprintf("%0.4f", $row['unload']);
		$mm = sprintf("%0.4f MB", $row['mem']);
      
  	<td class='td'>",$ld,"</td>
		<td class='td'>",$ck,"</td>
    <td class='td'>",$sz,"</td>
		<td class='td'>",$ul,"</td>
		<td class='td right'>",$mm,"</td>
  */  
?>
      </tbody>
	  </table>
  </div>
<br>
