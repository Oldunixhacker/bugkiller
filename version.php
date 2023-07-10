<link rel="stylesheet" href="/style.css">
<?php
require "./vendor/autoload.php";
require_once "topbar.php";
require_once "configure.php";
?>
<link rel="stylesheet" href='<?php echo "$path"; ?>'>
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
