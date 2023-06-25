<?php
require "vendor/autoload.php";
require_once "topbar.php";
require_once "configure.php";
?>
<link rel="stylesheet" href='<?php echo "$path"; ?>'>
<h1>License</h1>
<pre><code>
MIT License

Copyright (c) 2023 TylerMS887

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
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
// Composer
include 'vendor/autoload.php';
use Composer\InstalledVersions;
$composer_version = InstalledVersions::getPrettyVersion('composer/composer');
echo '<tr><td><a href="https://getcomposer.org">Composer</a></td><td>' . $composer_version . '</td></tr>';

echo '</tbody>';
echo '</table>';
?>
<h1>Composer packages</h1>
<?php
$packages = [];
foreach (InstalledVersions::getAllInstalledPackages() as $package) {
    $packages[] = [
        'name' => $package->getName(),
        'description' => $package->getDescription(),
        'version' => $package->getPrettyVersion(),
        'license' => implode(', ', $package->getLicense()),
    ];
}

echo '<table>';
echo '<thead><tr><th>Name</th><th>Description</th><th>Version</th><th>License</th></tr></thead>';
echo '<tbody>';
foreach ($packages as $package) {
    echo '<tr>';
    echo '<td>' . $package['name'] . '</td>';
    echo '<td>' . $package['description'] . '</td>';
    echo '<td>' . $package['version'] . '</td>';
    echo '<td>' . $package['license'] . '</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
?>