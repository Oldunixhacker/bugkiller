<?php
// If you are reading this script in your web browser then
// your server probably isn't configured properly to run
// PHP programs!
//
// See the INSTALL file for more information.

// Uncomment for debugging
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once "topbar.php";

if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    echo 'Couldn\'t find php mysqli. It is possible that your server wasn\'t configured correctly.';
    exit;
}

// Show a warning for users that haven't configured Bugkiller using config.ini
if (!file_exists('config.ini')) {
  header('HTTP/1.1 500 Internal Server Error');
  echo '<h1>Bugkiller Error: Internal Server Error</h1>';
  echo '<p><code>config.ini</code> does not exist. Please run <a href="/bugkiller/setup.php"><code>setup.php</code></a> to set up the bug tracker\'s configuration.</p>';
  echo '<p>Please note that additional errors might occur when you start the bug tracker even when configured. If you do get errors like those, ensure your MySQL database exists.</p>';
}

// Warning: Ensure config.ini is inaccessible from the web.
require_once "configure.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  echo "Connection failed: " . $conn->connect_error;
  exit;
}

// Create table for bugs
$sql = "CREATE TABLE IF NOT EXISTS bugs (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, bug_name VARCHAR(30) NOT NULL, bug_description LONGTEXT NOT NULL, status VARCHAR(30) NOT NULL, priority VARCHAR(30) NOT NULL, date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);";

if (!$conn->query($sql) === TRUE) {
  echo "Error preparing the Bugkiller database.<br>" . $conn->error;
  exit;
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $projectname . " Bugkiller"; ?></title>
<link rel="stylesheet" href="<?php echo "$path"; ?>/style.css">
</head>
<body>
<h1><?php echo $projectname . " Bugkiller"; ?></h1>
<div id="bugkiller-report-js-button" style="display:none">
<button class="bugkiller-button" onclick="window.location.href = '<?php echo "$path"; ?>/reportbug.php';"><span class="bugkiller-icon-mail"></span> Report a Bug</button>
</div>
<script>
document.getElementById('bugkiller-report-js-button').style.display='block';
</script>
<noscript>
<a href='<?php echo "$path"; ?>/reportbug.php'>Report a Bug</a>
</noscript>
</body>
</html>
