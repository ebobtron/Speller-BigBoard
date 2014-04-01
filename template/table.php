
<div class="lnk">

<p class="img" style="display: inline;">
<a id="menu" href="submit.php">&nbsp;Submit Your Program&nbsp;</a></p>

&middot;

<p class="img" style="display: inline;">
<a id="menu" href="criteria.php">&nbsp;Test Criteria&nbsp;</a></p>

&middot;

<p class="img" style="display: inline;">
<a id="menu" href="download.php">&nbsp;Download "test"&nbsp;</a></p>
</div>

<div class="div-table">


<h3 style="margin:0px">all times in seconds</h3>



<table summary="leader board" class="table">

<tr>
	<th>id</th><th>name</th><th>total time</th><th>load time</th>
	<th>check time</th><th>size time</th><th>unload time</th>
	<th>memory</th> 
</tr>

<?php

	while($row = mysql_fetch_array($result))
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
    <td>",$id,"</td><td>",$row['name'],"</td><td>",$to,"</td>
    <td>",$ld,"</td><td>",$ck,"</td><td>",$sz,"</td>
		<td>",$ul,"</td><td class='right'>",$mm,"</td>
    </tr>";
		
		$loop++;
	}

 ?>
 </table>
</div><br>
 