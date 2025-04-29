<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "application"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input (replace with actual form data or any other way to get input)
$firstname=$_POST['firstname'];
$email = $_POST['email'];
$lastname = $_POST['lastname'];

// Check if email or last_name already exists
$sql_check = "SELECT * FROM student_details WHERE email = ? OR lastname = ?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("ss", $email, $lastname);
$stmt->execute();
$result = $stmt->get_result();

// If a record is found, return an error message
if ($result->num_rows > 0) {
    echo "Error: Email or Last Name is already taken.";
} else {
    // No duplicates, proceed to insert the data
    $sql_insert = "INSERT INTO student_details (firstname, email, lastname) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("sss", $firstname, $email, $lastname);
    
    if ($stmt->execute()) {
        echo "Record inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
$stmt->close();
$conn->close();
?>