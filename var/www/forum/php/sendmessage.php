<?php
  session_start();
  if (!isset($_SESSION["user_id"]))
  {
    header("Location: /login.php", true, 302);
    exit();
  }
  if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["text"]) || !isset($_POST["author_id"]) || !isset($_POST["topic_id"]))
  {
    http_response_code(400);
    exit();
  }
  $mysqli = new mysqli("localhost", "php", "php", "forum");
  $create_message_stmt = $mysqli->prepare("call create_message(?, ?, ?);");
  $create_message_stmt->bind_param("sss", $_POST["topic_id"], $_POST["author_id"], $_POST["text"]);
  if (!$create_message_stmt->execute())
  {
    error_log($mysqli->error);
    $mysqli->close();
    http_response_code(500);
    exit();
  }
  $create_message_stmt->bind_result($message_id);
  $create_message_stmt->fetch();
  header("Location: /topic.php?id=" . $_POST["topic_id"] . "#" . $message_id, true, 302);
  $create_message_stmt->free_result();
  $mysqli->close();
  
?>
