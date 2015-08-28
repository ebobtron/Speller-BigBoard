<!DOCTYPE HTML>
<!-- copyright 2015 Robert Clark(aka ebobtron), et al. 
     see public/aboutus.php           -->

<html lang="en">

  <head>
    <?php if(isset($title)): ?>
      <title>LeaderBoard: <?= htmlspecialchars($title) ?></title>
    <?php else: ?>
      <title>LeaderBoard</title>
    <?php endif ?>
    
    <link rel="canonical" href="http://speller-leaderboard.freehostia.com" type="text/html" />
    <meta http-equiv="Content-type" content="text/html;charset=utf-8" />
    <meta name="description" content="Pset6, Pset5, Mispellings, leader board for
     students of CS50x. Supported by students of CS50x" />
    
    <link href="../public/css/leaderboard.css" rel="stylesheet" type="text/css" />
    <link href="../public/css/table-general.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
    
    <style type="text/css"></style>

  </head>

  <body>
    <div id="fb-root"></div>
    <script>
      (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
      fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
    
    <div class="div-head">
      <h1 class="head">

        <a class="head-links" href="http://speller-leaderboard.freehostia.com">
          SPELLER LEADER BOARD</a>

          <?php if(isset($head)): ?>
            <?= $head ?>
          <?php else: ?>    
            <br />
          <?php endif ?>
      </h1>
      <h3 class="head">
          for students of Harvard College's CS50x 

          <?php if(isset($link)): ?>
            <?= $link ?>
          <?php else: ?>

          <?php endif ?>

      </h3>
    </div>
    
<!-- last edited: 03/11/2015  ebt -->    
