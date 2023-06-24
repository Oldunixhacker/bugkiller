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
  echo "<p><b>Bad bug identifier:</b> Bug IDs must be an Arabic numeral.</p>";
  header("HTTP/1.1 400 Bad Request");
  exit;
}
echo "Got $arg";
?>
