<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: login.php");
        exit;
    }

    // Get the id from the URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'identification_db');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT * FROM people_info WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Display detailed information
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<div class='details-container'>";
            echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' alt='Image' class='details-image'>";    
            echo "<h1 class='details-name'>" . htmlspecialchars($row['name']) . "</h1>";
            echo "<p class='details-age'>Age: " . htmlspecialchars($row['age']) . "</p>";
	    echo "<p class='details-phone'>phone: " . htmlspecialchars($row['phone']) . "</p>";
            echo "<p class='details-location'>Location: " . htmlspecialchars($row['location']) . "</p>";
            // Assuming there is a description field
            echo "</div>";
        } else {
            echo "<p>No details found!</p>";
        }

        // Close connection
        $stmt->close();
        $conn->close();
    } else {
        echo "<p>Invalid request!</p>";
    }
    ?>
</body>
</html>