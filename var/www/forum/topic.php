<?php
  session_start();
  if (!isset($_SESSION["user_id"]))
  {
    header("Location: /login.php", true, 302);
    exit();
  }
  if (!isset($_GET["id"]))
  {
    header("Location: /topics.php", true, 302);
    exit();
  }
  $mysqli = new mysqli("localhost", "php", "php", "forum");
  $get_topic_stmt = $mysqli->prepare("call get_topic(?);");
  $get_topic_stmt->bind_param("s", urldecode($_GET["id"]));
  if (!$get_topic_stmt->execute())
  {
    error_log($mysqli->error);
    $mysqli->close();
    http_response_code(500);
    exit();
  }
  $get_topic_stmt->bind_result($topic_author_id, $topic_title, $topic_author, $topic_creation_date);
  $get_topic_stmt->fetch();
  $get_topic_stmt->free_result();
  $mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/data/css/main.css" />
    <title><?= $topic_title ?> - megate.ch</title>
  </head>
  <body>
    <?php include("php/navbar.php"); ?>
    <header>
      <h1><?= $topic_title ?></h1>
      <h4>Created By <?= $topic_author ?> on <?= $topic_creation_date ?></h4>
    </header>
    <main>
      <?php include("php/getmessages.php"); ?>
      <?php include("php/replybox.php"); ?>
    </main>
    <?php include("php/footer.php"); ?>
    <script src="/data/js/replybox.js"></script>
  </body>
</html>
