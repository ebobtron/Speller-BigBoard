<!-- 
**
 *
 *  tabel_all.php  Display table of submissions and links
 * 
 *  Robert Clark, aka ebobtron et al.
 *
 *  extension of my CS50x final project
 *  winter/spring 2014  with Launch Code
 *
 *************************************************************   -->

<div class="div-table">

  <h3 style="margin:0px">all times in seconds</h3>

  <table class="table-all general">
  
    <thead class="thead">
    
    <tr class="head">
      <th>name</th>
      <th>total time</th>
      <th>load time</th>
      <th>data structure type</th>
      <th>group</th>
      </thead>
    </tr>   
   <!--      
        <td class="td left" style="min-width:9em">&nbsp;name</td>
        <td class="td" style="min-width:5em">total time</td>
        <td class="td" style="min-width:2em"></td>
        <td class="td left" style="min-width:10em">structure type</td>
        <td class="td left" style="min-width:17em">group</td>
      -->
        
      

    <tbody class="tbody ldbd-tbody">
    
    <? $loop = 0; ?> 
    <? foreach($rows as $row): ?>

    <? if($loop % 2 == 0): ?>
        <tr class="even"> 
    <? else: ?>
        <tr>	
    <? endif; ?>          
    
    <? 
         $to = sprintf("%0.4f", $row['total']);
         $keyNum = $row['grp'];
         $groupName = $titleString[$keys[$keyNum]];
         $grp = sprintf("%s", $groupName);
         $loop++;
    ?>
         
         <td>
           <a href="comment?comment=<?=$row['name']?>" class="name"
              title="click for user comments or reddit overview">&nbsp;
           <?=$row['name']?></a>
         </td>
         <td><?=$to?></td>
         <td></td>
         <td><?=$row['typ']?></td>
         <td><?=$grp?></td>
        </tr>

    <? endforeach; ?>  
  </tbody>  
  </table>

</div>
<br />
