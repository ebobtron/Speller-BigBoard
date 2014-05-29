
<!DOCTYPE HTML>
<html>

  <head>
  
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <link href="../public/css/leaderboard.css" rel="stylesheet" />
    <style type="text/css"></style>
    
    <?php if(isset($title)): ?>
      <title>LeaderBoard: <?= htmlspecialchars($title) ?></title>
    <?php else: ?>
      <title>LeaderBoard: LaunchCode winter 2014</title>
    <?php endif ?>
  
  </head>
  
  <body>
    <div class="div-head">
      <h3 class="head">
        
        <a class="head-links" href="http://speller-leaderboard.freehostia.com">
          speller Leader Board</a>
          
          &nbsp;-&nbsp;&nbsp;-&nbsp;&nbsp;LaunchCode St. Louis Edition<br />
          Harvard College's CS50x from
          
          <a class="head-links" href="http://edx.org">edX.org</a>
          
          <?php if (isset($title)): ?>
            <?= htmlspecialchars($title) ?>
          <?php else: ?>
            winter 2014 with <a href="http://launchcodestl.com" class="head-links">
            LaunchCodeSTL.com</a>
          <?php endif ?>
      
      </h3>
    </div>
    
