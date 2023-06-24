<?php
// A part of the Bugkiller UI.
//
//          ------------ What it looks like ------------
//
// /-----------------------------------------------------------------\  <-- Browser UI
// | / something Bugkiller \                                   _ ⛶ X | <-- Browser UI
// |-----------------------------------------------------------------| <-- Browser UI
// | [ https://example.org/bugkiller                     ] ★ 🧩 🗣 ⋅⋅⋅| <-- Browser UI
// |-----------------------------------------------------------------|
// | BUGKILLER | Top Bugs | Report Bug    [ Search...      ] Foo [v] | <-- This is the component loaded by this script
// |-----------------------------------------------------------------|
// | This page is intentionally left blank.                          | <-- Page content
// |                                                                 |
// |                                                                 |
// |                                                                 |
// |                                                                 |
// |                                                                 |
// \-----------------------------------------------------------------/

$config = parse_ini_file("config.ini");
$path = "//" . $config['path'];
$projectname = $config['projectname'];

// Font Awesome icon
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">';

echo '<div id="bugkiller-topbar">';
echo <<<endofhtml
<form method="post" action="$path/search.php" style="float: right;">
    <input type="text" id="search" name="search" style="width: 300px;" value="" required="" placeholder="Search bugs...">
    <button class="bugkiller-button" type="submit" action="search.php" method="post"><i class="fa-solid fa-search"></i></button>
</form>
endofhtml;
echo "<a href='$path' id='bugkiller-logo'>$projectname</a><span style='margin-right: 10px'></span>";
echo "<a href='$path/reportbug.php'>Report a Bug</a><span style='margin-right: 10px'></span>";

// Move on to the rest of the UI using CSS
echo "</div><div id='bugkiller-ui'>";
