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
if(!isset($_SESSION['js'])||$_SESSION['js']==""){
  echo "<noscript><meta http-equiv='refresh' content='0;url=/get-javascript-status.php&js=0'> </noscript>";
   $js = true;

 }elseif(isset($_SESSION['js'])&& $_SESSION['js']=="0"){
   $js = false;
   $_SESSION['js']="";

 }elseif(isset($_SESSION['js'])&& $_SESSION['js']=="1"){
   $js = true;
   $_SESSION['js']="";
}

if (!$js) {
    echo "<div id=\"js-disabled\">This site works best with JavaScript disabled.</div>";
}
?>
