<?php
  session_start();
  if (!isset($_SESSION["user_id"]))
  {
    header("Location: /login.php", true, 302);
    exit();
  }
  if (!isset($_GET["id"]))
  {
    header("Location: /", true, 302);
    exit();
  }
  $mysqli = new mysqli("localhost", "php", "php", "forum");
  $get_user_stmt = $mysqli->prepare("call get_user(?);");
  $get_user_stmt->bind_param("s", urldecode($_GET["id"]));
  if (!$get_user_stmt->execute())
  {
    error_log($mysqli->error);
    $mysqli->close();
    http_response_code(500);
    exit();
  }
  $get_user_stmt->bind_result($user_id, $user_name, $user_join_date, $user_avatar);
  $get_user_stmt->fetch();
  $get_user_stmt->free_result();
  $mysqli->close();
  $mysqli = new mysqli("localhost", "php", "php", "forum"); # ????
  $get_post_count_stmt = $mysqli->prepare("call get_post_count(?);");
  $get_post_count_stmt->bind_param("s", $_GET["id"]);
  if (!$get_post_count_stmt->execute())
  {
    error_log($mysqli->error);
    $mysqli->close();
    http_response_code(500);
    exit();
  }
  $get_post_count_stmt->bind_result($user_post_count);
  $get_post_count_stmt->fetch();
  $get_post_count_stmt->free_result();
  $mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/data/css/main.css" />
    <title><?= $user_name ?>'s Profile - megate.ch</title>
  </head>
  <body>
    <?php include("php/navbar.php"); ?>
    <header>
      <h1><?= $user_name ?></h1>
    </header>
    <main>
      <div class="framed">
        <p>Joined: <time datetime="<?= $user_join_date; ?>"><?= $user_join_date; ?></time></p>
        <p>Posts: <?= $user_post_count; ?></p>
      </div>
    </main>
    <?php include("php/footer.php"); ?>
  </body>
</html>
