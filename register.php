<?php
// Database connection parameters
$servername = "localhost"; // Change this if your MySQL server is hosted elsewhere
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "user_registration"; // Your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process registration form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $emailid = $_POST['mailid'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $metaid = $_POST['metaid'];
    $createpassword = $_POST['createpassword']; // Store the password in plain text for now (not recommended)

    // Hash the password for security
    $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert data into database
    $sql = "INSERT INTO users (emailid, name, age, metaid, createpassword) 
            VALUES ('$emailid', '$name', '$age', '$metaid', '$hashed_password')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        // echo "Registration successful";
        echo "<script>alert('Registration Successfully');</script>";

        header("Location: login.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>

