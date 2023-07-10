<?php
if (PHP_SAPI == 'apache2handler') {
   header("Content-Type: text/plain");
   header("HTTP/1.1 403 Forbidden");
   echo "BUGKILLER MAINTENANCE\n\nPlease run maintenance scripts from your server's command-line shell.\nContact your administrator if you do not have access.";
   exit;
}
if (PHP_SAPI != 'cli') {
   $runtype = PHP_SAPI;
   echo "Run this script via the command-line shell. If you do not have access to your server's shell contact your server administrator. Detected PHP_SAPI: $runtype\n";
   exit;
}
if (posix_getuid() !== 0) {
   echo "Please run this script as root.\n";
   exit;
}
echo "Bugkiller Server Updater\n";
echo "Attempting to update packages...\n";
chdir(dirname(__DIR__));
shell_exec("COMPOSER_ALLOW_SUPERUSER=1 composer update");
echo "Pulling git changes...\n";
shell_exec("git reset");
shell_exec("git pull --no-rebase");
chdir("maintenance");
echo "Restarting Apache server...\n";
shell_exec("apachectl restart");
echo "Update finished!\n";
