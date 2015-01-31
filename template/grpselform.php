<!--
*
*   grpselform.php  -- goup selection template --
*
*   copyright 2015 Robert Clark(aka ebobtron), et al.
*
*   an expansion of my edX.org CS50x final project
*   winter/spring 2014  with Launch Code
*************************************************************** -->

<div class="gentext lilmar" style='width:80%'>

  <h3 class="head lilmar"> Group Selection </h3>
    Please click the image below that best describes your circumstances, thank you.<br />
    <ul><li>
    If you have a group not shown here please contact the
    <a href="mailto:ebobtron@aol.com" class="head-links" style='font-size:19px'>
       Leader Board Administrator.</a>&nbsp; We can add your group.</ul>
</div>

<div class="grpSelect">  

<form action="grpsel" method="post">

  <table id="grpTable">
  
  <!--          removing codergirl and lauchcode from the groups 
  <tr>
    <td class='grptd'>
      <div id="coderg">
        <button id="coderggrp" name='group' value="codergirlstl2014" title="click for Coder Girl STL 2014">
         <img alt="CoderGirlSTL 2014 group" id="codergimg" src="../public/img/coder-g.jpg">
           &nbsp;STL&nbsp;&nbsp; 2014
        </button>
      </div>
    </td>
    <td>If you are studying with groups associated with Coder Girl STL</td>
  </tr>
  <tr>
    <td class="grptd">
      <div id="lcode">
        <button id="lcodegrp" name='group' value="lcstlw2014" title="click for LaunchCode winter 2014">
         <img alt="click for this group" id='lcodeimg' src="../public/img/logo-white-lc.png">
     &nbsp;STL&nbsp;&nbsp;winter 2014
        </button>
      </div>
    </td>
    <td>LaunchCode STL winter 2014</td>
  </tr>
  -->
  <tr>
    <td class="grptd">
      <div id="edx">      
        <button id="edxgrp" name='group' value="edx2015" title="click for edX.org 2015">
          <img alt="click for this group" id='edximg' src="../public/img/hero-logo-edx.png">
          <img alt="click for this group" id='cs50img' src="../public/img/cs50_299x188.jpg">
        </button>
      </div>
    </td>
    <td>If you are studying CS50x with edX.org.
    </td>
  </tr>
  <tr>
   <td>your group here</td>
   <td>contact the
     <a href="mailto:ebobtron@aol.com" class="head-links" style='font-size:19px'>
        leader board administrator.</a>&nbsp; We can add your group.
   </td>
  </tr>
</table>
  <input type="hidden" name="target" value="<?=$target?>" />
</form>

</div><br />

<!-- last edit: 01/30/2015  ebt -->

