<ul>
<?php
  $mysqli = new mysqli("localhost", "php", "php", "forum");
  $get_topics_stmt = $mysqli->prepare("call get_topics();");
  if (!$get_topics_stmt)
  {
    error_log($mysqli->error);
    http_response_code(500);
    exit();
  }
  if (!$get_topics_stmt->execute())
  {
?>
    <p class="error">Error fetching topics.</p>
<?php
  }
  else
  {
    $get_topics_stmt->bind_result($topic_id, $author_id, $title, $author, $creation_date);
    while ($get_topics_stmt->fetch())
    {
?>
    <li><a href="/topic.php?id=<?= urlencode($topic_id); ?>"><?= $title; ?></a> by <a href="/user.php?id=<?= urlencode($author_id); ?>"><?= $author; ?></a> on <?= $creation_date; ?></li>
<?php
    }
    $get_topics_stmt->free_result();
  }
  $mysqli->close();
?>
</ul>
