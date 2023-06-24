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
$path = $config['path'];
if ($password == "") {
  echo "<strong>For security reasons, it is no longer possible to use Bugkiller without a MySQL database password.</strong><br>Please alter the <code>$username</code> user to have a password.";
  exit 1;
}
?>
