<?php
session_start();

// Create connection
$conn = new mysqli("localhost", "root", "", "forum");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST['id'];
    $password = $_POST['password'];

    // SQL query to fetch user details
    $sql = "SELECT * FROM users WHERE user_id='$userid'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, start session and redirect to home page
            $_SESSION['userid'] = $row['user_id']; // Store user ID in session for future use
            header("Location: home.php");
            exit();
        } else {
            // Redirect back to login page with error message
            header("Location: index.html");
            exit();
        }
    } else {
        // Redirect back to login page with error message
        header("Location: index.html");
        exit();
    }
}

$conn->close();
?>