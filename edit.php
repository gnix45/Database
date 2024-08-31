<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'identification_db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update record
    $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];

    $sql = "UPDATE people_info SET name='$name', age='$age', phone='$phone', location='$location' WHERE id='$id'";
    $conn->query($sql);
    
    header("Location: index.php");  // Redirect to the main page after update
} else {
    // Get record details for editing
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM people_info WHERE id='$id'");
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="text-center">Edit Record</h2>
        <form method="POST" action="edit.php">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age:</label>
                <input type="number" name="age" class="form-control" value="<?php echo $row['age']; ?>" required>
            </div>
	    <div class="mb-3">
                <label for="location" class="form-label">Phone:</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $row['phone']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location:</label>
                <input type="text" name="location" class="form-control" value="<?php echo $row['location']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>