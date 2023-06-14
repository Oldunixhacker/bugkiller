<!DOCTYPE html>
<html lang="en">
<head>
<title>Report a Bug - <?php echo $projectname . " Bugkiller"; ?></title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Report a Bug</h1>
<?php if ($wikitextallowed == true) { echo "<p>Wikitext formatting is supported.</p>"; } ?>
<p>Please note that <?php echo $projectname . " Bugkiller"; ?> only allows bug reports about <?php echo $projectname ?>.</p>
<form method="post">
        <input type="text" id="title" name="title" placeholder="Title"><br><br>
        <textarea id="description" name="description" placeholder="Description"></textarea><br><br><label for="status"><b>Status</b><br><small>It is highly recommended to leave this as Needs Triage. B.G.M.B. is only suitable for very large bugs, like ones that occur when opening any page or signing in.</small></label><br><br><select id="status" name="status">
        <option value="Needs Triage">Needs Triage</option>
        <option value="B.G.M.B.">B.G.M.B. (Big Giant Monster Bug)</option>
        <option value="High">High</option>
        <option value="Medium">Medium</option>
        <option value="Low">Low</option>
        </select><br><br>
        <input type="submit" value="Report" class="bugkiller-button">
        </form>
</body>
</html>
<?php
$config = parse_ini_file("config.ini");

// Variables
$servername = $config['servername'];
$username = $config['username'];
$password = $config['password'];
$dbname = $config['dbname'];
$projectname = $config['projectname'];
$wikitextallowed = $config['wikitextallowed'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new mysqli($servername, $username, $password, $dbname);
  $title = $_POST["title"];
  $description = $_POST["description"];
  $priority = $_POST["status"];
  if ($title == "") {
    echo "Title is required.";
    return;
  }
  if ($description == "") {
    echo "Description is required.";
    return;
  }
  $sql = "INSERT INTO bugs (bug_name, bug_description, status, priority) VALUES ('$title', '$description', 'Open', '$priority')";
  // Execute the SQL statement
  if (mysqli_query($conn, $sql)) {
    header("Location: /bugkiller");
    exit;
  } else {
    echo "Something went wrong. Try again.";
  }
}
?>
