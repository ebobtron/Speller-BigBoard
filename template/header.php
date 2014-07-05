
<!DOCTYPE HTML>
<!-- written by Robert Clark, et al. see public/aboutus.php -->
<html lang="en">

  <head>

    <meta http-equiv="Content-type" content="text/html;charset=utf-8" />
    <meta name="description" content="Pset6 leader board for students
    of CS50/CS50x. Supported by students of CS50x" />
    
    <link href="../public/css/leaderboard.css" rel="stylesheet" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    
    <style type="text/css"></style>

    <?php if(isset($title)): ?>
      <title>LeaderBoard: <?=htmlspecialchars($title)?></title>
    <?php else: ?>
      <title>LeaderBoard</title>
    <?php endif ?>

  </head>

  <body>
    <div class="div-head">
      <h2 class="head">

        <a class="head-links" href="http://speller-leaderboard.freehostia.com">
          speller Leader Board</a>

          <?php if(isset($head)): ?>
            <? echo $head; ?>
          <?php else: ?>    
            <br />
          <?php endif ?>
      </h2>
      <h3 class="head">
          for students of Harvard College's CS50x from

          <a class="head-links" href="http://edx.org">edX.org</a>

          <?php if(isset($link)): ?>
            <? echo $link; ?>
          <?php else: ?>

          <?php endif ?>

      </h3>
    </div>
