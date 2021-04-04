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
    <title>Create Topic - megate.ch</title>
  </head>
  <body>
    <?php include("php/navbar.php"); ?>
    <header>
      <h1>Create Topic</h1>
    </header>
    <main>
      <div class="framed">
        <form action="/php/createtopic.php" method="post" enctype="multipart/form-data">
          <label for="title">Topic:</label>
          <input type="text" name="title" required placeholder="Type your topic..." size="120" /><br /><br />
          <textarea name="text" cols="120" rows="24" required placeholder="Type your message..."></textarea><br />
          <input type="hidden" name="author" value="<?= $_SESSION["user_id"]; ?>" />
          <input type="submit" value="Create Topic" />
        </form>
      </div>
    </main>
    <?php include("php/footer.php"); ?>
  </body>
</html>
