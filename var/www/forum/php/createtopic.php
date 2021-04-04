<?php
  session_start();
  if (!isset($_SESSION["user_id"]))
  {
    header("Location: /login.php", true, 302);
    exit();
  }
  if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["title"]) || !isset($_POST["text"]) || !isset($_POST["author"]))
  {
    http_response_code(400);
    exit();
  }
  $mysqli = new mysqli("localhost", "php", "php", "forum");
  $create_topic_stmt = $mysqli->prepare("call create_topic(?, ?, ?);");
  $create_topic_stmt->bind_param("sss", $_POST["title"], $_POST["author"], $_POST["text"]);
  if (!$create_topic_stmt->execute())
  {
    error_log($mysqli->error);
    $mysqli->close();
    http_response_code(500);
    exit();
  }
  $create_topic_stmt->bind_result($topic_id);
  $create_topic_stmt->fetch();
  header("Location: /topic.php?id=" . $topic_id, true, 302);
  $create_topic_stmt->free_result();
  $mysqli->close();
?>
