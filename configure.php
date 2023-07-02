<?php
// Script to auto-configure your bugkiller pages.
// For end-users: Do not modify this file.
// If you want to edit your bugkiller configuration, edit
// config.ini which contains your config values.
$bugkiller_version = "0.1";
$IP = __dir__;
function isSecure() {
  return
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || $_SERVER['SERVER_PORT'] == 443;
}
$config = parse_ini_file("config.ini");
$servername = $config['servername'];
$username = $config['username'];
$password = $config['password'];
$dbname = $config['dbname'];
$projectname = $config['projectname'];
$path = "//" . $config['path'];
if (isSecure()) {
  $pathwithhttp = "https://" . $config['path'];
} else {
  $pathwithhttp = "http://" . $config['path'];
}
if ($password == "") {
  header("HTTP/1.1 503 Service Unavailable");
  echo "<strong>Note for users: $projectname is attempting to resolve a security issue related to this Bugkiller. Please wait until the site comes back online.</strong><br><br><strong>Note for the operator: For security reasons, it is no longer possible to use Bugkiller without a MySQL database password.</strong><br>Please alter the <code>$username</code> user to have a password.";
  exit;
}
if ($password == "YES") {
  header("HTTP/1.1 503 Service Unavailable");
  echo "<strong>Note for users: $projectname is attempting to resolve a security issue related to this Bugkiller. Please wait until the site comes back online.</strong><br><br><strong>Note for the operator: For security reasons, it is not possible to use Bugkiller with a MySQL database password set to (the Y word, check your config). MySQL uses this in errors and this can lead to hackers thinking the password is the same as the Y word that, according to the Oxford English Dictionary, means to give an affirmative response.</strong><br>Please alter the <code>$username</code> user to have a more secure password.";
  exit;
}
echo "<span id=\"configpath\">Path defined in config.ini: $path</span>";
echo "<noscript id=\"js-disabled\">Bugkiller works best with a JavaScript-compatible browser if JavaScript is turned on.</noscript>";
?>
