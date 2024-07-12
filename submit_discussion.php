<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "forum");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $created_at = date('Y-m-d H:i:s');

    // Handle image upload
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_dir = 'uploads/';
        $image_path = $image_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    $sql = "INSERT INTO discussions (title, content, image_path, created_at) VALUES ('$title', '$content', '$image_path', '$created_at')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to home page after successful submission
        header("Location: home.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
