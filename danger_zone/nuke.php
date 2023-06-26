<link rel="stylesheet" href="/style.css">
<?php
header("Content-Type: text/plain");
echo "BUGKILLER NUKE TOOL - ATTEMPTING TO PERFORM A NUKE!\n";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST['password'] != $password) {
    echo "Incorrect password.";
    header("HTTP/1.1 401 Unauthorized");
    exit;
  }
  $conn = new mysqli($servername, $username, $password, $dbname);
  $sql = "DROP TABLE bugs;\n";
  $sql .= "DROP TABLE comments;";
  if (mysqli_query($conn, $sql)) {
      echo "Done, redirecting soon...";
      header("Location: $path");
  } else {
      echo "Something went wrong. Try again.\nThis is the error message:\n" . mysqli_error($conn);
  }
  exit;
}

require_once "../topbar.php";
require_once "../configure.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Nuke - <?php echo $projectname . " Bugkiller"; ?></title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Nuke this bug tracker</h1>
<p><strong>Warning: You are doing something destructive! This will effectively erase all bugs, accounts, preferences, and comments on this Bugkiller.</strong></p>
<p>You will be redirected to the home page to recreate the bugs table, however, <strong>all bugs currently in the table will be completely erased.</strong></p>
<p>The configuration file will not be deleted.</p>
<p><strong>This action is irreversable. <a href="<? echo $path ?>/backup.php">Backup the database</a> before you proceed.</strong></p>
<hr>
<p>Nuking is locked down using a hardcoded method to prevent hoax nukes. Enter the password for SQL user <code><?php echo $username; ?></code> to continue:</p>
<form method="post">
<label for="password">MySQL user password:</label>
<input type="password" name="password"><br><br>
<input type="submit" value="Nuke" class="bugkiller-button">
</form>
</html>
