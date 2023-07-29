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

if (PHP_SAPI === 'cli') {
   echo "Please run this script on the web.\n";
   exit;
}

$config = parse_ini_file("config.ini");
$path = "//" . $config['path'];
$projectname = $config['projectname'];

// Use search icon from Font Awesome
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">';

// Echo out the toolbar
echo '<div id="bugkiller-topbar">';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchb = $_POST["search"];
} else {
    $searchb = "";
}
echo <<<endofhtml
<form method="post" action="$path/search.php" style="float: right;">
    <input type="text" id="barsearch" name="search" style="width: 300px;" value="" placeholder="Search bugs..." value="$searchb">
    <button class="bugkiller-button the-past" type="submit" action="
endofhtml . $pathwithttp . <<<endofhtml
" method="post"><span><i class="fa-solid fa-search"></i></span></button>
</form>
endofhtml;
echo "<a href='$path' id='bugkiller-logo'>$projectname</a><span style='margin-right: 10px'></span>";
echo "<a href='$path/reportbug'>Report a Bug</a><span style='margin-right: 10px'></span>";

// Move on to the rest of the UI using CSS
echo "</div><div id='bugkiller-ui'>";
