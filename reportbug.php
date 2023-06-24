<?php
require_once "configure.php";

$wikitextallowed = $config['wikitextallowed'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new mysqli($servername, $username, $password, $dbname);
  $title = $_POST["title"];
  $description = $_POST["description"];
  $priority = $_POST["status"];
  $skipcreate = false;
  if ($title == "" and $description == "") {
    echo "Empty form response. Please fill out the form to submit a bug.";
    $skipcreate = true;
  }
  if ($title == "" and $description != "") {
    echo "Title is required.";
    $skipcreate = true;
  }
  if ($description == "" and $title != "") {
    echo "Description is required.";
    $skipcreate = true;
  }
  // Execute the SQL statement
  if ($skipcreate == false) {
    $sql = "INSERT INTO bugs (bug_name, bug_description, status, priority) VALUES ('$title', '$description', 'Open', '$priority')";
    if (mysqli_query($conn, $sql)) {
      header("Location: /bugkiller");
      exit;
    } else {
      echo "Something went wrong. Try again.";
    }
  }
  }
?>
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
        <input type="checkbox" name="searched" id="searched" required>
        <label for="searched"> I confirm that I have <a href="<?php echo "$path"; ?>/search.php">searched for existing bugs</a>.</label><br><br>
        <input type="submit" value="Report" class="bugkiller-button">
        </form>
</body>
</html>
