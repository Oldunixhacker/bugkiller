<?php
if (PHP_SAPI != 'cli') {
   $runtype = PHP_SAPI;
   echo "Run this script via the command-line shell. If you do not have access to your server's shell contact your server administrator. Detected PHP_SAPI: $runtype\n";
   exit;
}
echo "Bugkiller Server Updater\n";
echo "Attempting to update packages...\n";
chdir(dirname(__DIR__));
shell_exec("COMPOSER_ALLOW_SUPERUSER=1 composer update");
echo "Pulling git changes...\n";
shell_exec("git pull --no-rebase");
chdir("maintenance");
echo "Update finished!\n";
