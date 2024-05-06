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

// Process login form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $emailid = $conn->real_escape_string($_POST['mailid']);
    $password = $conn->real_escape_string($_POST['password']);

    // Check if default email and password are used
    if ($emailid === 'admin@gmail.com' && $password === 'admin@123') {
        // Redirect to ListVoter.html
        header("Location: ListVoter.html");
        exit();
    }

    // Prepare SQL statement to retrieve user from database
    $sql = "SELECT * FROM users WHERE emailid=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $emailid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['createpassword'])) {
            // Redirect the user to another page after successful login
            // For example:
            header("Location: index.html");
            exit();
        } else {
            echo "<script>alert('Invalid Password');</script>";
            // header("Location: login.html");
            // exit();
        }
    } else {
        echo "<script>alert('User not found');</script>";
        // header("Location: login.html");
            // exit();
    }
}

// Close database connection
$conn->close();
?>
