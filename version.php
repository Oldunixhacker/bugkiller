<link rel="stylesheet" href="/style.css">
<?php
require "./vendor/autoload.php";
require_once "topbar.php";
require_once "configure.php";
?>
<link rel="stylesheet" href='style.css'>
<h1>License</h1>
<pre><code>
<?php
echo file_get_contents("$IP/LICENSE");
?>
</code></pre>
<h1>Software stack</h1>
<?php
echo '<table>';
echo '<thead><tr><th>Software</th><th>Version</th></tr></thead>';
echo '<tbody>';
// Bugkiller
echo '<tr><td><a href="https://github.com/TylerMS887/bugkiller">Bugkiller</a></td><td>' . $bugkiller_version . '</td></tr>';
// PHP
echo '<tr><td><a href="https://php.net">PHP</a></td><td>' . phpversion() . '</td></tr>';
// MySQL
$mysql_version = shell_exec('mysql -V');
preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $mysql_version, $version);
echo '<tr><td><a href="https://mysql.com">MySQL</a></td><td>' . $version[0] . '</td></tr>';
// Apache HTTP Server
$apache_version = apache_get_version();
preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $apache_version, $version);
echo '<tr><td><a href="https://httpd.apache.org">Apache HTTP Server</a></td><td>' . $version[0] . '</td></tr>';

echo '</tbody>';
echo '</table>';
?>
<h1>Composer packages</h1>
<?php

// Get the list of installed Composer packages.
$packages = shell_exec('composer show -i');

// Split the list of packages into an array.
$packages = explode("\n", $packages);

// Create an HTML table.
echo '<table border="1">';
echo '<thead>';
echo '<tr>';
echo '<th>Package</th>';
echo '<th>Description</th>';
echo '<th>Version</th>';
echo '<th>License</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

// Loop through the list of packages and add them to the table.
foreach ($packages as $package) {
  $parts = explode(' ', $package);
  $name = $parts[0];
  $version = $parts[1];
  $description = $parts[2];
  $license = $parts[3];

  echo '<tr>';
  echo '<td>' . $name . '</td>';
  echo '<td>' . $description . '</td>';
  echo '<td>' . $version . '</td>';
  echo '<td>' . $license . '</td>';
  echo '</tr>';
}

echo '</tbody>';
echo '</table>';

?>
