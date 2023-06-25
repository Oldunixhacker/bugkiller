<link rel="stylesheet" href="/style.css">
<?php
require_once "topbar.php";
require_once "configure.php";
$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$segments = explode('/', $path);
$arg = utf8_decode(urldecode($segments[2]));
if ($arg == "") {
  header("Location: $pathwithhttp/search.php");
  exit;
}
if (!is_numeric($arg)) {
  echo "<p><b>Bad bug identifier:</b> Due to the nature of how the Bugkiller database works, bug IDs must be an Arabic numeral (1, 2, 3, and so on).</p>";
  header("HTTP/1.1 400 Bad Request");
  exit;
}
<?php
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
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
    echo '<h1>' . $bug_name . '</h1>';
    echo '<pre><code>';
    echo $bug_description;
    echo '</code></pre>';
    if ($status == "Closed") {
      echo "<b>This bug report has been closed. No new comments are accepted.</b>";
    } elseif (priority == "Needs Triage") {
      echo "<b>This bug report has no priority, and is waiting for triage.</b>";
    } else {
      echo "<b>This bug report has been ranked with the following priority: " . $priority . "</b>";
    }
} else {
    echo 'Bug not found.<br>';
    echo '<a href="#barsearch">Search for existing bugs</a>.';
    exit;
}
$stmt->close();
$mysqli->close();
