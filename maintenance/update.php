<?php
if (PHP_SAPI != 'cli') {
   echo "Run this script via the command-line shell. If you do not have access to your server's shell contact your server administrator.\n";
   exit;
}
echo "Bugkiller Server Updater\n";
echo "Attempting to update packages...\n";
shell_exec("COMPOSER_ALLOW_SUPERUSER=1 composer update");
echo "Pulling git changes...\n";
chdir(dirname(__DIR__));
shell_exec("git pull");
chdir("maintenance");
echo "Update finished!";
