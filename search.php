<?php
require_once "topbar.php";
require_once "configure.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $searchq = $_POST["search"];
} else {
  echo "A search query is required.";
  header("HTTP/1.1 400 Bad Request");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Search results for "<?php echo $searchq ?>" - <?php echo $projectname ?></title>
  <link rel="stylesheet" href='style.css'>
</head>
<body>
  <h1>Search results for "<?php echo $searchq ?>"</h1>

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
    $search_no_spaces = str_replace(' ', '', $search);
    
    // Ensure that the user provided a search query to Bugkiller
    if ($search_no_spaces == "") {
      echo "Please provide a search query.";
      exit;
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
        echo "<a style=\"font-size: 2em;\" href=\"" . $path . "/" . $row["id"] . "\">" . $row["bug_name"] . "</a> <span style=\"opacity: 70%; font-family: monospace\">#" . $row["id"] . "</span><br><span class=\"search-result-description\">" . htmlspecialchars(substr($row["bug_description"], 0, 55)) . "</span><br><br>";
      }
      echo "<p>You can <a href=\"$path/reportbug.php\">report a bug</a> if these search results did not help.</p>";
    } else {
      // Output a message if no results were found
      echo "<p><b>Couldn't find any bugs that match \"$search\".</b></p><p>You can:</p>";
      echo "<ul>";
      echo "<li><a href=\"$path/reportbug.php\">Report a bug</a> with that name.</li>";
      echo "<li><a href=\"#barsearch\">Searching for something else</a>.</li>";
      echo "<li>Using a search engine if you are not looking for search results related to $projectname.<br>This site only indexes $projectname Bugkiller.</li>";
    }
  }

  // Close the database connection
  mysqli_close($conn);
  ?>
</body>
</html>
