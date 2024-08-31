<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to your CSS file -->
</head>
<body>
<center>
    <?php
    session_start();
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: login.php");
        exit;
    }

    // Check if the search form is submitted
    if (isset($_GET['name'])) {
        $name = $_GET['name'];

        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'identification_db');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT * FROM people_info WHERE name LIKE ?");
        $searchTerm = "%$name%";
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        // Display search results
        if ($result->num_rows > 0) {
            echo "<div class='results-container'>";
            while ($row = $result->fetch_assoc()) {
                $id = $row['id']; // Assuming 'id' is the unique identifier for the records
                echo "<a href='details.php?id=" . urlencode($id) . "' class='result-item'>";
                echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' alt='Image' class='result-image'>";    
                echo "<h3 class='result-name'>" . htmlspecialchars($row['name']) . "</h3>";
                echo "<p class='result-age'>Age: " . htmlspecialchars($row['age']) . "</p>";
	        echo "<p class='result-phone'>phone: " . htmlspecialchars($row['phone']) . "</p>";
                echo "<p class='result-location'>Location: " . htmlspecialchars($row['location']) . "</p>";
                echo "</a>";
            }
            echo "</div>";
        } else {
            echo "<p>No records found!</p>";
        }

        // Close connection
        $stmt->close();
        $conn->close();
    }
    ?>
</center>
</body>
</html>