<?php
if (PHP_SAPI !== 'cli-server') {
  echo "This script cannot be run unless a PHP development server is available.";
  exit;
}
if (posix_getuid() !== 0) {
   echo "Please run the development server as root.\n";
   exit;
}
echo "<h1>Bugkiller</h1>";
chdir(dirname(__DIR__));
echo "<h3>Update packages</h3>";
echo "<p>Bugkiller updated your Composer packages to the latest version.</p><pre><code>";
echo nl2br(shell_exec("composer update --no-dev"));
echo "</code></pre>";
echo "<h3>Update from Git</h3>";
echo "<p>Bugkiller was updated to the latest version.</p><pre><code>";
echo nl2br(shell_exec("git reset"));
echo "\n";
echo nl2br(shell_exec("git pull"));
echo "</code></pre>";
echo "The update has been completed.";
