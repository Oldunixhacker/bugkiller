<?php
require_once "configure.php";
$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$segments = explode('/', $path);
$arg = utf8_decode(urldecode($segments[2]));
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Create table for comments
    $sql = "CREATE TABLE IF NOT EXISTS comments (bug INT(6) UNSIGNED PRIMARY KEY, text VARCHAR(10000000) NOT NULL, date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);";

    if (!$conn->query($sql) === TRUE) {
        echo "Error preparing the Bugkiller database.<br>" . $conn->error;
        echo "<p><a href=\"$path/view.php/$arg\">Return to bug</a>.</p>";
        exit;
    }
    $description = $_POST["text"];
    $description = $conn->real_escape_string($description);
    $skipcreate = false;
    if ($description == "") {
      echo "Text is required.";
      $skipcreate = true;
    }
    // Execute the SQL statement
    if ($skipcreate == false) {
      $sql = "INSERT INTO comments (bug, text) VALUES ('$arg', '$description')";
      if (mysqli_query($conn, $sql)) {
        header("Location: $pathwithhttp/view.php/$arg");
        exit;
      } else {
        echo "Something went wrong. Try again. " . mysqli_error($conn);
        echo "<p><a href=\"$path/view.php/$arg\">Return to bug</a>.</p>";
        exit;
      }
    } else {
        echo "<p><a href=\"$path/view.php/$arg\">Return to bug</a>.</p>";
    }
} else {
  echo "Comment information was not transmitted. Keep in mind that you can't use this script directly.";
  header("HTTP/1.1 400 Bad Request");
  exit;
}