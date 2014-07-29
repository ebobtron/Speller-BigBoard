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
    <tbody class="tbody ldbd-tbody" style="height:28px;">
      <tr>
        <td class="td" style="width:6em">id</td>
        <td class="td left" style="width:13em">name</td>
        <td class="td" style="width:8em">total time</td>
        <td class="td" style="width:8em">load time</td>
        <td class="td" style="width:8em">check time</td>
        <td class="td" style="width:8em">size time</td>
        <td class="td" style="width:8em">unload time</td>
        <td class="td" style="width:8em">heap used</td> 
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
    
          <td class="td" style="width:6em"><?=$id?></td>

          <td class="td left" style="width:13em">

            <a href="http://www.reddit.com/user/<?=$row["name"]?>/" class="name"
               title="click me for more info"><?=$row["name"]?></a>

          </td>
          <td class="td" style="width:8em"><?=$to?></td>
          <td class="td" style="width:8em"><?=$ld?></td>
          <td class="td" style="width:8em"><?=$ck?></td>
          <td class="td" style="width:8em"><?=$sz?></td>
          <td class="td" style="width:8em"><?=$ul?></td>
          <td class="td right" style="width:8em"><?=$mm?></td>

        </tr>

      <? endforeach; ?>

    </tbody>
  </table>
</div>
<br />
