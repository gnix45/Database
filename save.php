<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];

    // Handle file upload
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    
    // Create uploads directory if it doesn't exist
    if (!is_dir('uploads')) {
        mkdir('uploads');
    }
    
    // Move uploaded file to uploads directory
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'identification_db');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the database
    $sql = "INSERT INTO people_info (name, age, location, image, phone) VALUES ('$name', '$age', '$location', '$image', '$phone')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Record saved successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>