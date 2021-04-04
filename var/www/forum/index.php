<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/data/css/main.css" />
    <title>megate.ch</title>
  </head>
  <body>
    <?php include("php/navbar.php"); ?>
    <header>
      <h1>MEGATE.CH</h1>
    </header>
    <main>
      <h2>News</h2>
      <?php include("php/news.php"); ?>
    </main>
    <?php include("php/footer.php"); ?>
  </body>
</html>
