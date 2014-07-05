
<!-- 
**
*
*   table.php  Display table of submissions and links
* 
*   Robert Clark, aka ebobtron et al.
*
*   extension of my CS50x final project   winter/spring 2014  with Launch Code
*
*************************************************************   -->

<div class="div-table">

<h3 style="margin:0px">all times in seconds</h3>

<table class="table">
 <tbody class="tbody ldbd-tbody" style='height:28px;'>
  <tr>
	 <td class="td" style='width:6%'>id</td>
	 <td class="td left"  style='width:13%'>name</td>
	 <td class="td" style='width:8%'>total time</td>
	 <td class="td" style='width:8%'>load time</td>
	 <td class="td" style='width:8%'>check time</td>
	 <td class="td" style='width:8%'>size time</td>
	 <td class="td" style='width:8%'>unload time</td>
	 <td class="td" style='width:8%'>heap used</td> 
  </tr>
</tbody>
<tbody class="tbody ldbd-tbody">

<?php
  $loop = 0;
	foreach($rows as $row)
	{
		if($loop % 2 == 0)
		  echo " <tr class='row'> ";
		else
		  echo " <tr> ";	

		$id = sprintf("%04d", $row['id']);
		$to = sprintf("%0.4f", $row['total']);
		$ld = sprintf("%0.4f", $row['dload']);
		$ck = sprintf("%0.4f", $row['tcheck']);
		$sz = sprintf("%0.4f", $row['size']);
		$ul = sprintf("%0.4f", $row['unload']);
		$mm = sprintf("%0.4f MB", $row['mem']);
		
    echo
       "<td class='td' style='width:6%'>",$id,"</td>\n" .
		   
       "<td class='td left' style='width:13%'>" .
       
       "<a href='http://www.reddit.com/user/",$row['name'],"' class='name' ".
       "title='click me for more info'>" . $row['name']. "</a>" .
       
       "</td>" .
		
    "<td class='td' style='width:8%'>",$to,"</td>" .
    "<td class='td' style='width:8%'>",$ld,"</td>" .
		"<td class='td' style='width:8%'>",$ck,"</td>" .
		"<td class='td' style='width:8%'>",$sz,"</td>" .
		"<td class='td' style='width:8%'>",$ul,"</td>" .
		"<td class='td right' style='width:8%'>",$mm,"</td>" .
		"</tr>";

		$loop++;
	}

?>
      </tbody>
	  </table>
  </div>
<br />

<a href='http://www.reddit.com/user/'></a>