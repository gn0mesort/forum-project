<?php
  session_start();
  if (!isset($_SESSION["user_id"]))
  {
    header("Location: /login.php", true, 302);
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/data/css/main.css" />
    <title>Topics - megate.ch</title>
  </head>
  <body>
    <?php include("php/navbar.php"); ?>
    <header>
      <h1>Topics</h1>
    </header>
    <main>
      <div class="framed">
        <?php include("php/gettopics.php") ?>
      </div>
    </main>
    <?php include("php/footer.php"); ?>
  </body>
</html>
