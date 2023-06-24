<?php
// Script to auto-configure your bugkiller pages.
// Do not modify this file - if you want to edit your bugkiller configuration,
// edit config.ini which contains your config values.
$config = parse_ini_file("config.ini");
$servername = $config['servername'];
$username = $config['username'];
$password = $config['password'];
$dbname = $config['dbname'];
$projectname = $config['projectname'];
$path = "//" . $config['path'];
if ($password == "") {
  header("HTTP/1.1 503 Service Unavailable");
  echo "<strong>Note for users: $projectname is attempting to resolve a security issue related to this Bugkiller. Please wait until the site comes back online.</strong><br><br><strong>Note for the operator: For security reasons, it is no longer possible to use Bugkiller without a MySQL database password.</strong><br>Please alter the <code>$username</code> user to have a password.";
  exit;
};
echo "<span id=\"configpath\">Path defined in config.ini: $path</span>";
echo "<noscript>id=\"js-disabled\">Bugkiller works best with JavaScript enabled.<br>Limited functionality is available when JavaScript is disabled, or not supported by your browser.</noscript>";
?>
