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
    <title>Registration - megate.ch</title>
  </head>
  <body>
    <?php include("php/navbar.php"); ?>
    <header>
      <h1>Registration</h1>
    </header>
    <main>
      <?php
        if (isset($_GET["error"]))
        {
      ?>
      <p class="error">
      <?php
          if ($_GET["error"] === "badnamelen")
          {
            print("Usernames must be between 1 and 64 characters.");
          }
          else if ($_GET["error"] === "usertaken")
          {
            print("That username is already in use.");
          }
          else if ($_GET["error"] === "badpasslen")
          {
            print("Passwords must be between 8 and 64 characters.");
          }
      ?>
        </p>
      <?php
        }
      ?>
      <form class="framed" action="/php/register.php" method="post" enctype="multipart/form-data">
        <label for="name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name:</label>
        <input type="text" name="name" required="true" pattern=".{1,64}" /><br />
        <label for="password">Password:</label>
        <input type="password" name="password" required="true" pattern=".{8,64}" title="Must be between 8 and 64 characters." /><br />
        <input type="submit" value="Register" />
      </form>
    </main>
    <?php include("php/footer.php"); ?>
  </body>
</html>
