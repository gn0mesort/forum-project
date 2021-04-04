<?php
  session_start();
  if (!isset($_SESSION["user_id"]))
  {
    header("Location: /login.php", true, 302);
    exit();
  }
  include ("parsedown.php");
  $mysqli = new mysqli("localhost", "php", "php", "forum");
  $get_messages_stmt = $mysqli->prepare("call get_messages(?);");
  $get_messages_stmt->bind_param("s", urldecode($_GET["id"]));
  if (!$get_messages_stmt->execute())
  {
    error_log($mysqli->error);
    $mysqli->close();
    http_response_code(500);
    exit();
  }
  $get_messages_stmt->bind_result($message_id, $message_author_id, $message_author, $message_text, $message_creation_date);
  $parsedown = new Parsedown();
  $parsedown->setSafeMode(true);
  $parsedown->setMarkupEscaped(true);
  while ($get_messages_stmt->fetch())
  {
?>
    <div id="<?= $message_id; ?>" class="framed message">
      <p class="small">From <a href="/user.php?id=<?= urlencode($message_author_id); ?>"><?= $message_author; ?></a> at <time datetime="<?= $message_creation_date; ?>"><?= $message_creation_date; ?></time></p>
      <p class="small"><a href="#<?= $message_id; ?>" onclick="toggleReply();">Reply</a></p>
      <div class="message-body">
        <?= $parsedown->parse($message_text); ?>
      </div>
    </div>
<?php
  }
  $get_messages_stmt->free_result();
  $mysqli->close();
?>
