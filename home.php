<?php
session_start(); // Start session

// Database connection
$conn = new mysqli("localhost", "root", "", "forum");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'newest'; // Default filter is newest

// Prepare the SQL query based on filter
switch ($filter) {
    case 'oldest':
        $sql = "SELECT * FROM discussions ORDER BY created_at ASC";
        break;
    case 'newest':
    default:
        $sql = "SELECT * FROM discussions ORDER BY created_at DESC";
        break;
}

// Fetch discussions with user information
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>MDIS Forum</title>
</head>
<body>
    <div class="vertical-menu">
        <div class="menu-header">
            <a href="home.php">
                <img src="image/project logo.png" alt="Logo" class="logo">
            </a>
        </div>
        <a href="home.php" class="active"><i class="fas fa-home"></i> Home</a>
        <a href="trending.php"><i class="fas fa-chart-line"></i> Trending</a>
        <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
    </div>
    <div class="top-bar">
        <input type="text" placeholder="Search Discussion" class="search-bar">
        <a href="create.php" class="create-container">
            <img src="image/edit.png" alt="create" class="create">
            <span>Create</span>
        </a>
        <a href="login page.html" class="fas fa-user profile-icon"></a> <!-- Icon with user's name -->
    </div>
    <div class="content">
        <div class="w3-bar w3-border w3-light-grey">
            <a href="home.php?filter=newest" class="w3-bar-item w3-button <?php if ($filter == 'newest') echo 'w3-black'; ?>">Newest</a>
            <a href="home.php?filter=oldest" class="w3-bar-item w3-button <?php if ($filter == 'oldest') echo 'w3-black'; ?>">Oldest</a>
        </div>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<a href='discussion.php?id=" . $row["id"] . "' class='forum-discussion-link'>";
                echo "<div class='forum-discussion'>";
                echo "<div class='subforum-date'><small>Posted on " . $row["created_at"] . "</small></div>";
                echo "<div class='description'><h1>" . $row["title"] . "</h1></div>";
                echo "<div class='subforum-description'><p>" . $row["content"] . "</p></div>";
                echo "</div></a>";
            }
        } else {
            echo "No discussions yet.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
