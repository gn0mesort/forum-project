<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/data/css/main.css" />
    <link rel="stylesheet" href="/data/css/gruvbox-dark.css" />
    <title>megate.ch</title>
  </head>
  <body onload="hljs.highlightAll();">
    <?php include("php/navbar.php"); ?>
    <header>
      <h1 title="Beware the cube!">
        <noscript>You have disabled the cube.</noscript>
        <canvas id="context" width="320" height="240"></canvas>
      </h1>
      <noscript><h2>This site works a lot better with JavaScript enabled.</h2></noscript>
    </header>
    <main>
      <h2>News</h2>
      <?php include("php/news.php"); ?>
    </main>
    <?php include("php/footer.php"); ?>
    <script src="/data/js/highlight.pack.js"></script>
    <script src="/data/js/glm-js.min.js"></script>
    <script src="/data/js/cube.js"></script>
  </body>
</html>
