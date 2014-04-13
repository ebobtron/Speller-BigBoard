
<div class="lnk">

<p class="img" style="display: inline;">
<a class="menu" href="getspeller.php">&nbsp;Submit Your Program&nbsp;</a></p>

&middot;

<p class="img" style="display: inline;">
<a class="menu" href="criteria.php">&nbsp;Test Criteria&nbsp;</a></p>

&middot;

<p class="img" style="display: inline;">
<a class="menu" href="download.php">&nbsp;Download "test"&nbsp;</a></p>
</div>

<div class="div-table">

<h3 style="margin:0px">all times in seconds</h3>

<table class="table">
 <thead class="thead">
  <tr>
	 <th class="td-th">id</th><th class="td-th">name</th>
	 <th class="td-th">total time</th><th class="td-th">load time</th>
	 <th class="td-th">check time</th><th class="td-th">size time</th>
	 <th class="td-th">unload time</th><th class="td-th">&nbsp;&nbsp;memory</th> 
  </tr>
</thead>
<tbody class="tbody ldbd-tbody">
<?php

	foreach($rows as $row)
	{ 
		
		if ($loop % 2 == 0)
		  echo " <tr class='row'> ";
		else
		  echo " <tr> ";	

		$id = sprintf("%04d", $row[id]);
		$to = sprintf("%0.3f", $row[total]);
		$ld = sprintf("%0.3f", $row[dload]);
		$ck = sprintf("%0.3f", $row[tcheck]);
		$sz = sprintf("%0.3f", $row[size]);
		$ul = sprintf("%0.3f", $row[unload]);
		$mm = sprintf("%0.3f MB", $row[mem]);
		echo"
    <td class='td-th'>",$id,"</td>
		<td class='td-th'>",$row['name'],"</td>
		<td class='td-th'>",$to,"</td>
    <td class='td-th'>",$ld,"</td>
		<td class='td-th'>",$ck,"</td>
		<td class='td-th'>",$sz,"</td>
		<td class='td-th'>",$ul,"</td>
		<td class='td-th right'>",$mm,"</td>
    </tr>";
		
		$loop++;
	}

 ?>
  </tbody> 
 </table>
 </div>
<br>
 