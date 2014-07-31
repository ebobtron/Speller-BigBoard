<!--
**
 *
 *  table.php  Display table of submissions and links
 *
 *  Robert Clark, aka ebobtron et al.
 *
 *  extension of my CS50x final project   
 *  winter/spring 2014  with Launch Code
 *
 *************************************************************   -->

<div class="div-table">

  <h3 style="margin:0px">all times in seconds</h3>

  <table class="table">
    <tbody class="tbody ldbd-tbody" style="height:28px" >
      <tr>
        <td class="td b" style="min-width:4em">id</td>
        <td class="td b left" style="min-width:10em">name</td>
        <td class="td b" style="min-width:5em">total</td>
        <td class="td b" style="min-width:5em">load</td>
        <td class="td b" style="min-width:5em">check</td>
        <td class="td b" style="min-width:5em">size</td>
        <td class="td b" style="min-width:5em">unload</td>
        <td class="td b" style="min-width:6em">heap</td>
        <td class="td b left" style="min-width:6em">&nbsp;&nbsptype</td> 
      </tr>

    </tbody>

    <tbody class="tbody ldbd-tbody">
    
      <? $loop = 0; ?> 
      <? foreach($rows as $row): ?>

      <? if($loop % 2 == 0): ?>
        <tr class="row"> 
      <? else: ?>
        <tr>	
      <? endif; ?>

      <? $id = sprintf("%04d", $row["id"]);
         $to = sprintf("%0.4f", $row["total"]);
         $ld = sprintf("%0.4f", $row["dload"]);
         $ck = sprintf("%0.4f", $row["tcheck"]);
         $sz = sprintf("%0.4f", $row["size"]);
         $ul = sprintf("%0.4f", $row["unload"]);
         $mm = sprintf("%0.4f MB", $row["mem"]);
         $loop++; ?>
    
          <td class="td" style="min-width:4em"><?=$id?></td>

          <td class="td left" style="min-width:10em">

            <a href="http://www.reddit.com/user/<?=$row['name']?>/" class="name"
               title="click me for more info"><?=$row['name']?></a>

          </td>
          <td class="td" style="min-width:5em"><?=$to?></td>
          <td class="td" style="min-width:5em"><?=$ld?></td>
          <td class="td" style="min-width:5em"><?=$ck?></td>
          <td class="td" style="min-width:5em"><?=$sz?></td>
          <td class="td" style="min-width:5em"><?=$ul?></td>
          <td class="td right" style="min-width:6em"><?=$mm?></td>
          <td class="td left" style="min-width:6em">&nbsp;&nbsp;<?=$row['typ']?></td>

        </tr>

      <? endforeach; ?>

    </tbody>
  </table>
</div>
<br />
