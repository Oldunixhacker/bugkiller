<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";
$projectname = "";
$path = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
$wikitextallowed = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $path = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $servername = $_POST['servername'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $dbname = $_POST['dbname'];
    $projectname = $_POST['projectname'];
    $wikitextallowed = $_POST['wwallowed'];
    $setupallowed = $_POST['setupallowed'];
    if ($wikitextallowed == "") {
        $wikitextallowed = "false";
    }
    if ($setupallowed == "") {
        $setupallowed = "false";
    }

    // Write the config values to the config.ini file
    $config = "servername = \"$servername\"\n";
    $config .= "username = \"$username\"\n";
    $config .= "password = \"$password\"\n";
    $config .= "dbname = \"$dbname\"\n";
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
      echo "Invalid database options.<br>MySQL says: " . $conn->connect_error;
      exit;
    }
    $config .= "projectname = \"$projectname\"\n";
    $config .= "wikitextallowed = $wikitextallowed\n";
    $config .= "setupallowed = $setupallowed\n";
    $config .= "path = \"$path\"";
    $file = fopen(__DIR__ . "/config.ini", "w");

    // Check if the file is opened successfully
    if ($file) {
      // Write the contents of $config to the file
      fwrite($file, $config);
    
      // Close the file
      fclose($file);
    
      // Echo a success message
      header("Location: index.php");
    } else {
      // Echo an error message
      echo "File could not be created. For reference you can create config.ini in the Bugkiller folder with these contents:<br><pre>$config</pre>";
    }
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
    $setupallowed = $config['setupallowed'];
    echo "<p><em>Note: An existing configuration file was detected and has been loaded.</em></p>";
    if (!$setupallowed) {
        echo "<p>This script has been disabled by a system administrator. You must manually edit the config.ini file instead.";
        header("HTTP/1.1 403 Forbidden");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
        <title>Bugkiller Setup</title>
        <link rel="stylesheet" href="setup.css">
</head>
<body>
        <div class="titlebar">Welcome to Bugkiller!</div>
        <form method="post">
                <label for="projectname">What is your project's name?</label><br>
                <input type="text" value='<?php echo "$projectname"; ?>' name="projectname" required><br><br>
            
                <label for="path">We are assuming your site is located at:<br><input type="text" value='<?php echo "$path"; ?>' readonly></input><br>If this is incorrect you can change it through the terminal after setting up.</label>
                <span id="path"><!--dummy--></span><br><br>
                
                <label for="servername">What MySQL server should Bugkiller connect to?</label><br>
                <input type="text" name="servername" value='<?php echo "$servername"; ?>' required><br><br>

                <label for="username">Authenticate your database.</label><br>
                <input type="text" name="username" placeholder="Username" value='<?php echo "$username"; ?>' required><br>
                <input type="password" name="password" placeholder="Password"><br><br>

                <label for="dbname">What database should Bugkiller control?</label><br>
                <input type="text" value='<?php echo "$dbname"; ?>' name="dbname" required><br><br>
            
                <?php if ($wikitextallowed == true) {echo '<input type="checkbox" id="wwallowed" name="wwallowed" value="true" checked>';} else {echo '<input type="checkbox" id="wwallowed" name="wwallowed" value="true">';} ?>
                <label for="wwallowed"> Allow Wikitext formatting in bug descriptions</label><br><br>
                <input type="checkbox" id="setupallowed" name="setupallowed" value="true" checked>
                <label for="setupallowed"> Allow further use of Setup instead of manually editing config.ini</label><br><br>

                <input type="submit" value="I'm Ready">
        </form>
</body>
</html>
