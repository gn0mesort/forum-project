<nav>
  <span>
  Welcome,&nbsp;
  <?php
    if (isset($_SESSION["user_id"]))
    {
      $mysqli = new mysqli("localhost", "php", "php", "forum");
      $get_user_stmt = $mysqli->prepare("select name from users where user_id = UUID_TO_BIN(?);");
      $get_user_stmt->bind_param("s", $_SESSION["user_id"]);
      if(!$get_user_stmt->execute())
      {
        print("Bad user_id = " . $_SESSION["user_id"]);
      }
      $get_user_stmt->bind_result($name);
      $get_user_stmt->fetch();
      print($name);
      $get_user_stmt->free_result();
      $mysqli->close();
    }
    else
    {
      print("you are not logged in.");
    }
  ?>
  </span>
  <a href="/">Home</a>
  <?php
    if (isset($_SESSION["user_id"]))
    {
  ?>
      <a href="/topics.php">Current Topics</a>
      <a href="/create.php">Create Topic</a>
      <a href="/user.php?id=<?= urlencode($_SESSION["user_id"]) ?>">Profile</a>
      <a href="/logout.php">Log Out</a>
  <?php
    }
    else
    {
  ?>
      <a href="/login.php">Log In</a>
      <a href="/registration.php">Register</a>
  <?php
    }
  ?>
  <hr />
</nav>
<div style="height:5rem;"></div>
