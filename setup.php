<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";
$projectname = "";
$wikitextallowed = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $path = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $servername = $_POST['servername'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $dbname = $_POST['dbname'];
    $projectname = $_POST['projectname'];
    $wikitextallowed = $_POST['wwallowed'];
    if ($wikitextallowed == "") {
        $wikitextallowed = "false";
    }

    // Write the config values to the config.ini file
    $config = "servername = \"$servername\"\n";
    $config .= "username = \"$username\"\n";
    $config .= "password = \"$password\"\n";
    $config .= "dbname = \"$dbname\"\n";
    $config .= "projectname = \"$projectname\"\n";
    $config .= "wikitextallowed = $wikitextallowed\n";
    $config .= "path = \"$path\";
    echo "The resulting config.ini file is:";
    echo "<pre>";
    echo "$config";
    echo "</pre>";
    exit;
}
if (file_exists('config.ini')) {
    $config = parse_ini_file("config.ini");
    $servername = $config['servername'];
    $username = $config['username'];
    $dbname = $config['dbname'];
    $projectname = $config['projectname'];
    $password = $config['password'];
    $wikitextallowed = $config['wikitextallowed'];
    echo "<p><em>Note: An existing configuration file was detected and has been loaded.</em></p>";
}
?>

<!DOCTYPE html>
<html>
<head>
        <title>Bugkiller SQL Setup</title>
</head>
<body>
        <h1>Bugkiller Setup</h1>
        <p>Get Bugkiller up and running in a few clicks.</p>
        <form method="post">
                <label for="path">Bugkiller web path: <b><?php echo "$path"; ?></b></label>
                <span id="path"><!--dummy--></span>
                
                <label for="servername">Server name:</label>
                <input type="text" name="servername" value='<?php echo "$servername"; ?>' required><br><br>

                <label for="username">MySQL username:</label>
                <input type="text" name="username" value='<?php echo "$username"; ?>' required><br><br>

                <label for="password">MySQL user password:</label>
                <input type="password" name="password"><br><br>

                <label for="dbname">Database name:</label>
                <input type="text" value='<?php echo "$dbname"; ?>' name="dbname" required><br><br>

                <label for="projectname">Project name:</label>
                <input type="text" value='<?php echo "$projectname"; ?>' name="projectname" required><br><br>
            
                <?php if ($wikitextallowed == true) {echo '<input type="checkbox" id="wwallowed" name="wwallowed" value="true" checked>';} else {echo '<input type="checkbox" id="wwallowed" name="wwallowed" value="true">';} ?>
                <label for="wwallowed"> Allow Wikitext formatting in bug descriptions</label><br><br>

                <p>After filling out the form above, you can apply the configuration.</p>
                <input type="submit" value="Configure">
        </form>
</body>
</html>
