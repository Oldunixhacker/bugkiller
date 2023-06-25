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
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  echo "Unable to view bug: " . $conn->connect_error;
  exit;
}

$stmt = $pdo->prepare('SELECT bug_title, bug_description FROM bugs WHERE id = :id');
$stmt->execute(['id' => $arg]);
$bug = $stmt->fetch();
if ($bug) {
    echo '<h1>' . htmlspecialchars($bug['bug_title']) . '</h1>';
    echo '<pre><code>' . htmlspecialchars($bug['bug_description']) . '</code></pre>';
} else {
    echo "There is no bug with the ID provided.";
}
?>
