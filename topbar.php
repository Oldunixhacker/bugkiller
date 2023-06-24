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
echo '<div id="bugkiller-topbar">';
echo "<span style="float: right">Profile placeholder</span>";
echo "<b><a href='$path'>Bugkiller</a></b><span style='margin-right: 10px'></span>";
echo "<a href='$path/reportbug.php'>Report a Bug</a><span style='margin-right: 10px'></span>";
