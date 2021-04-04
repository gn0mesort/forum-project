<?php
  session_start();
  if (isset($_SESSION["user_id"]))
  {
    header("Location: /", true, 302);
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/data/css/main.css" />
    <title>Log In - megate.ch</title>
  </head>
  <body>
    <?php include("php/navbar.php"); ?>
    <header>
      <h1>Log In</h1>
    </header>
    <main>
      <?php
        if (isset($_GET["error"]))
        {
      ?>
      <p class="error">
      <?php
          if ($_GET["error"] === "badname")
          {
            print("Invalid username.");
          }
          else if ($_GET["error"] === "badpass")
          {
            print("Invalid password.");
          }
      ?>
        </p>
      <?php
        }
      ?>
      <form class="framed" action="/php/login.php" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" required="true" pattern=".{1,64}" /><br />
        <label for="password">Password:</label>
        <input type="password" name="password" required="true" pattern=".{8,64}" title="Must be between 8 and 64 characters." /><br />
        <input type="submit" value="Log In" />
      </form>
    </main>
    <?php include("php/footer.php"); ?>
  </body>
</html>
