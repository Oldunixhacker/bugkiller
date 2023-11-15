<link rel="stylesheet" href="style.css">
<?php
require "vendor/autoload.php";
require_once "topbar.php";
require_once "configure.php";
$iswiki = $config['wikitextallowed'];
$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$numSegments = count($segments); 
$arg = $segments[$numSegments - 1];
if ($arg == "") {
  header("HTTP/1.1 400 Bad Request");
  echo "<p><b>Bad bug identifier:</b> No bug ID provided.</p>";
  exit;
}
if (!is_numeric($arg)) {
  echo "<p><b>Bad bug identifier:</b> Due to the nature of how the Bugkiller database works, bug IDs must be an Arabic numeral (1, 2, 3, and so on).</p>";
  header("HTTP/1.1 400 Bad Request");
  exit;
}
$mysqli = new mysqli($servername, $username, $password, $dbname);
if ($mysqli->connect_errno) {
    echo 'Failed to connect to the Bugkiller database: ' . $mysqli->connect_error;
    exit;
}
$stmt = $mysqli->prepare('SELECT id, bug_name, bug_description, status, priority FROM bugs WHERE id = ?');
$stmt->bind_param('i', $arg);
$stmt->execute();
$result = $stmt->get_result();
$bug = $result->fetch_assoc();
if ($bug) {
    $id = htmlspecialchars($bug['id']);
    $bug_name = htmlspecialchars($bug['bug_name']);
    $bug_description = htmlspecialchars($bug['bug_description']);
    $status = htmlspecialchars($bug['status']);
    $priority = htmlspecialchars($bug['priority']);
    echo '<title>' . '#' . $id . ": " . $bug_name . ' - ' . $projectname . ' Bugkiller</title>';
    echo '<h1>' . $bug_name . '</h1>';
    if ($iswiki) {
      $htmlDescription = (new Parser())
        ->setWikitext($bug_description)
        ->setFormat(Format::HTML)
        ->parse();
      echo $htmlDescription;
    } else {
      echo '<pre class="user-generated-content">';
      echo wordwrap($bug_description, 125);
      echo '</pre>';
    }
    if ($status == "Closed") {
      echo "<b>This bug report has been closed. No new comments are accepted.</b>";
    } elseif ($priority == "Needs Triage") {
      echo "<b>This bug report has no priority, and is waiting for triage.</b>";
    } else {
      echo "<b>This bug report has been ranked with the following priority: " . $priority . "</b>";
    }
    echo "<h2>Comments</h2>";
    echo "<h3>New Comment</h3>";
    echo "<form action=\"$path/comment.php\" method=\"post\">";
    echo '<textarea id="description" name="description" placeholder="Description"></textarea>';
    echo '</form>';
} else {
    echo 'Bug not found.<br>';
    echo '<a href="#barsearch">Search for existing bugs</a>.';
    header("HTTP/1.1 404 Not Found");
    exit;
}
$stmt->close();
$mysqli->close();
?>
