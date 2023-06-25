<?php
require_once "topbar.php";
require_once "configure.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $searchq = $_POST["search"];
} else {
  $searchq = "";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Bug Search</title>
  <link rel="stylesheet" href='<?php echo "$path"; ?>/style.css'>
</head>
<body>

  <h1>Bug Search</h1>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="text" id="search" name="search" style="width: 300px;" value='<?php echo "$searchq" ?>' autocomplete="off">
    <input type="submit" value="Search" class="bugkiller-button">
  </form>

  <?php
  // Connect to the database
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Check connection
  if (!$conn) {
    die("Search is impossible due to database connection error. " . mysqli_connect_error() . ".");
  }

  // Check if the form has been submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the search term from the form
    $search = mysqli_real_escape_string($conn, $_POST["search"]);

    // Ensure that the user provided a search query to Bugkiller
    if ($search == "") {
      echo "<p>Search query is empty.</p>";
    }
    
    // Prepare the SQL statement
    $sql = "SELECT * FROM bugs WHERE bug_name LIKE '%$search%' OR bug_description LIKE '%$search%'";

    // Execute the SQL statement
    $result = mysqli_query($conn, $sql);

    // Check if any results were found
    if (mysqli_num_rows($result) > 0) {
      // Display Google-styled results
      $resultcount = mysqli_num_rows($result);
      if ($resultcount == 1) {
        echo "<p>1 result found.</p>";
      } else {
        echo "<p>$resultcount results found.</p>";
      }
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<a style=\"font-size: 2em;\" href=\"" . $path . "/view.php/" . $row["id"] . "\">" . $row["bug_name"] . "</a> <span style=\"opacity: 70%; font-family: monospace\">#" . $row["id"] . "</span><br><span class=\"search-result-description\">" . substr($row["bug_description"], 0, 55) . "</span><br><br>";
      }
      echo "<p>You can <a href=\"$path/reportbug.php\">report a bug</a> if these search results did not help.</p>";
    } else {
      // Output a message if no results were found
      echo "<p>Couldn't find any bugs that match \"$search\". You can <a href=\"$path/reportbug.php\">report a bug</a> with that name.</p>";
    }
  }

  // Close the database connection
  mysqli_close($conn);
  ?>

</body>
</html>
