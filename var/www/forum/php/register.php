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
  header("Location: /registration.php?error=badnamelen", true, 302);
  $mysqli->close();
  exit();
}
if (strlen($_POST["password"]) < 8 || strlen($_POST["password"]) > 64)
{
  header("Location: /registration.php?error=badpasslen", true, 302);
  $mysqli->close();
  exit();
}
$register_stmt = $mysqli->prepare("call register_user(?, ?);");
if (!$register_stmt)
{
  error_log($mysqli->error);
  $mysqli->close();
  http_response_code(500);
  exit();
}
$passhash = password_hash($_POST["password"], PASSWORD_ARGON2ID);
$register_stmt->bind_param("ss", $_POST["name"], $passhash);
if (!$register_stmt->execute())
{
  header("Location: /registration.php?error=usertaken", true, 302);
  $mysqli->close();
  exit();
}
$register_stmt->bind_result($user_id);
$register_stmt->fetch();
$_SESSION["user_id"] = $user_id;
$register_stmt->free_result();
header("Location: /", true, 302);
$mysqli->close();
exit();
?>
