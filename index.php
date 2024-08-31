<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identification System - Admin</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 30px;
        }
        .container {
            max-width: 800px;
        }
        h2 {
            color: #007bff;
        }
        .table img {
            width: 50px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Admin Panel - Add New Record</h2>

<a href="logout.php" class="btn btn-secondary mb-4">Logout</a>


        <!-- Form for Adding Records -->
        <form method="POST" action="save.php" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age:</label>
                <input type="number" name="age" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location:</label>
                <input type="text" name="location" class="form-control" required>
            </div>
	    <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Picture:</label>
                <input type="file" name="image" class="form-control" required>
            </div>
	     

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <!-- Admin Panel to View, Edit, and Delete Records -->
        <h2 class="text-center">View Records</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Location</th>
		    <th>Phone</th>
                    <th>Picture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Connect to the database
                $conn = new mysqli('localhost', 'root', '', 'identification_db');
                // Fetch all records
                $result = $conn->query("SELECT * FROM people_info");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['age'] . "</td>";
                    echo "<td>" . $row['location'] . "</td>";
		    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td><img src='uploads/" . $row['image'] . "' alt='Picture'></td>";
                    echo "<td>
                            <a href='edit.php?id=" . $row['id'] . "' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='delete.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>