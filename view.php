<?php
require_once "topbar.php";
require_once "configure.php";
$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$segments = explode('/', $path);
$arg = $segments[2];
if ($arg == "") {
  header("Location: $path/search.php");
  exit;
}
echo "Working!";
?>
