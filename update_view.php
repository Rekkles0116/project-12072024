<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "forum");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the specific discussion based on ID from URL
$discussion_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "UPDATE discussions SET views = views + 1 WHERE id = $discussion_id";
$conn->query($sql);

// Fetch the updated view count
$sql = "SELECT views FROM discussions WHERE id = $discussion_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $discussion = $result->fetch_assoc();
    echo $discussion['views'];
} else {
    echo "0";
}

$conn->close();
?>
