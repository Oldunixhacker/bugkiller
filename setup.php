<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = $_POST['servername'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $dbname = $_POST['dbname'];
    $projectname = $_POST['projectname'];

    // Write the config values to the config.ini file
    $config = "servername = \"$servername\"\n";
    $config .= "username = \"$username\"\n";
    $config .= "password = \"$password\"\n";
    $config .= "dbname = \"$dbname\"\n";
    $config .= "projectname = \"$projectname\"\n";

    echo "<title>Bugkiller SQL Setup</title>";
    echo "<link rel=\"stylesheet\" href=\"/style.css\">";
    echo "<h1>Bugkiller configuration was generated!</h1>";
    echo "<p>Paste the following text into config.ini in your Bugkiller root directory:</p>";
    echo "<pre>";
    echo $config;
    echo "</pre>";
    echo "<p><strong>Remember to configure your web server to disallow requests to config.ini, as it contains your database password. Bugkiller will still be able to retrieve the file for configuration.</strong></p>";
    exit;
}
if (file_exists('config.ini')) {
  echo "Already configured.";
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
        <title>Bugkiller SQL Setup</title>
</head>
<body>
        <h1>Bugkiller SQL Setup</h1>
        <form method="post">
                <label for="servername">Server name:</label>
                <input type="text" name="servername" required><br><br>

                <label for="username">MySQL username:</label>
                <input type="text" name="username" required><br><br>

                <label for="password">MySQL user password:</label>
                <input type="password" name="password"><br><br>

                <label for="dbname">Database name:</label>
                <input type="text" name="dbname" required><br><br>

                <label for="projectname">Project name:</label>
                <input type="text" name="projectname" required><br><br>
            
                <input type="checkbox" id="wwallowed" name="wwallowed" value="1">
                <label for="wwallowed"> Allow Wikitext formatting in bug descriptions</label><br>

                <input type="submit" value="Display Configuration File" class="bugkiller-button">
        </form>
</body>
</html>
