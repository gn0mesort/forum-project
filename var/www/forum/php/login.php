<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
  error_log("Bad request type");
  http_response_code(400); # Bad Req
  exit();
}
$mysqli = new mysqli("localhost", "php", "php", "forum");
if (strlen($_POST["name"]) <= 0 || strlen($_POST["name"]) > 64)
{
  header("Location: /login.php?error=badname", true, 302);
  $mysqli->close();
  exit();
}
if (strlen($_POST["password"]) < 8 || strlen($_POST["password"]) > 64)
{
  header("Location: /login.php?error=badpass", true, 302);
  $mysqli->close();
  exit();
}
$login_stmt = $mysqli->prepare("call fetch_login(?);");
$login_stmt->bind_param("s", $_POST["name"]);
if (!$login_stmt->execute())
{
  error_log($mysqli->error);
  http_response_code(500);
  $mysqli->close();
  exit();
}
$login_stmt->bind_result($user_id, $password);
$login_stmt->fetch();
if (!$user_id || !$password)
{
  header("Location: /login.php?error=badname", true, 302);
  $mysqli->close();
  exit();
}
if (!password_verify($_POST["password"], $password))
{
  header("Location: /login.php?error=badpass", true, 302);
  $mysqli->close();
  exit();
}
$_SESSION["user_id"] = $user_id;
$login_stmt->free_result();
header("Location: /", true, 302);
$mysqli->close();
exit();
?>
