<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Helper to send the search query back to the input box.
  $search_query = mysqli_real_escape_string($conn, $_POST["search"]);
else {
  $search_query = "";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Bug Search</title>
  <link rel="stylesheet" href="/bugkiller/style.css">
</head>
<body>

  <h1>Bug Search</h1>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="text" id="search" name="search" value="<?php echo '$search_query'; ?>">
    <input type="submit" value="Search" class="bugkiller-button">
  </form>

  <?php
  $config = parse_ini_file("config.ini");
  $servername = $config['servername'];
  $username = $config['username'];
  $password = $config['password'];
  $dbname = $config['dbname'];
  $projectname = $config['projectname'];

  // Connect to the database
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Check if the form has been submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the search term from the form
    $search = mysqli_real_escape_string($conn, $_POST["search"]);

    // Prepare the SQL statement
    $sql = "SELECT * FROM bugs WHERE bug_name LIKE '%$search%' OR bug_description LIKE '%$search%'";

    // Execute the SQL statement
    $result = mysqli_query($conn, $sql);

    // Check if any results were found
    if (mysqli_num_rows($result) > 0) {
      // Output the results in a table
      $resultcount = mysqli_num_rows($result);
      if ($resultcount == 1) {
        echo "One result found.";
      } else {
        echo "$resultcount results found.";
      }
      echo "<table>";
      echo "<tr><th>Bug Name</th><th>Bug Description</th><th>Status</th><th>Priority</th><th>Date Created</th></tr>";
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["bug_name"] . "</td><td>" . $row["bug_description"] . "</td><td>" . $row["status"] . "</td><td>" . $row["priority"] . "</td><td>" . $row["date_created"] . "</td></tr>";
      }
      echo "</table>";
    } else {
      // Output a message if no results were found
      echo "<p>Couldn't find any bugs that match \"$search\". You can <a href=\"/bugkiller/reportbug.php\">report a bug</a> with that name.</p>";
    }
  }

  // Close the database connection
  mysqli_close($conn);
  ?>

</body>
</html>
