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
echo '<div id="bugkiller-topbar">';
echo """  <form method=\"post\" action=\"/search.php\">
    <input type=\"text\" id=\"search\" name=\"search\" style=\"width: 300px;\" value=\"\" required=\"\">
    <input type=\"submit\" value=\"Search\" class=\"bugkiller-button\">
  </form>""";
echo "<span style='float: right'>Profile placeholder</span>";
echo "<a href='$path' id='bugkiller-logo'>$projectname</a><span style='margin-right: 10px'></span>";
echo "<a href='$path/reportbug.php'>Report a Bug</a><span style='margin-right: 10px'></span>";

// Move on to the rest of the UI using CSS
echo "</div><div id='bugkiller-ui'>";
