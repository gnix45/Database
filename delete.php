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

// Get the ID of the record to delete
$id = $_GET['id'];

// Delete the record
$sql = "DELETE FROM people_info WHERE id='$id'";
$conn->query($sql);

// Redirect back to the main page
header("Location: index.php");
$conn->close();
?>