<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  echo "BUGKILLER NUKE TOOL - ATTEMPTING TO PERFORM A NUKE!\n";
  header("Content-Type: text/plain");
  require_once "../configure.php";
  echo "\n\n";
  $IP = dirname($IP);
  if ($_POST['password'] != $password) {
    echo "Incorrect password.";
    header("HTTP/1.1 401 Unauthorized");
    exit;
  }
  if ($_POST['captcha'] == $_SESSION['captcha']) {
        echo "Security measures verified.\n";
  } else {
	      echo "Incorrect or missing captcha.";
        header("HTTP/1.1 401 Unauthorized");
        exit;
  }
  $conn = new mysqli($servername, $username, $password, $dbname);
  $sql = "DROP TABLE bugs;";
  if (mysqli_query($conn, $sql)) {
      echo "\nFinished removing bugs table";
  } else {
      echo "Something went wrong. Reload the page.\nThis is the error message:\n" . mysqli_error($conn);
      exit;
  }
  $sql .= "DROP TABLE comments;";
  if (mysqli_query($conn, $sql)) {
      echo "Done, redirecting soon...";
      header("Location: $path");
  } else {
      echo "Something went wrong. Reload the page.\nThis is the error message:\n" . mysqli_error($conn);
  }
  exit;
}

require_once "../configure.php";

$IP = dirname($IP);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Nuke - <?php echo $projectname . " Bugkiller"; ?></title>
</head>
<body>
<h1>Nuke this bug tracker</h1>
<p><strong>Warning: You are doing something destructive! This will effectively erase all bugs, accounts, preferences, and comments on this Bugkiller.</strong></p>
<p>You will be redirected to the home page to recreate the bugs table, however, <strong>all bugs currently in the table will be completely erased.</strong></p>
<p>The configuration file will not be deleted.</p>
<p><strong>This action is irreversable. <a href="<? echo $path ?>/backup.php">Backup the database</a> before you proceed.</strong></p>
<hr>
<p>Enter the password for SQL user <code><?php echo $username; ?></code> and complete the CAPTCHA to continue:</p>
<form method="post">
<label for="password">MySQL user password:</label>
<input type="password" name="password"><br><br>
<label for="captcha">Enter the letters you see in the image below:</label><br>
<img src="<?php echo $path ?>/danger_zone/captcha.gif.php" alt="Hard CAPTCHA" title="Hard CAPTCHA"><br>
<input type="text" name="captcha" id="captcha"><br><br>
<input type="submit" value="Nuke!" class="bugkiller-button">
</form>
</html>
