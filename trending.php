<?php
session_start(); // Start session

// Database connection
$conn = new mysqli("localhost", "root", "", "forum");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Determine the filter type
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all'; // Default filter is all time

// Prepare the SQL query based on filter
switch ($filter) {
    case 'past7':
        $sql = "SELECT * FROM discussions WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY view_count DESC";
        break;
    case 'past30':
        $sql = "SELECT * FROM discussions WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) ORDER BY view_count DESC";
        break;
    case 'all':
    default:
        $sql = "SELECT * FROM discussions ORDER BY view_count DESC";
        break;
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="home.css">
    <title>Trending</title>
    <style>
        .medal {
            display: inline-block;
            width: 30px; /* Adjust size as needed */
            height: auto;
            margin-right: 5px;
        }

        .content{
          margin-left: 240px;
        }
        .filter{
          margin-left: -15px;
        }


    </style>
</head>
<body>
    <div class="vertical-menu">
        <div class="menu-header">
            <a href="home.php">
                <img src="image/project logo.png" alt="Logo" class="logo">
            </a>
        </div>
        <a href="home.php"><i class="fas fa-home"></i> Home</a>
        <a href="trending.php?filter=all" <?php if ($filter == 'all') echo 'class="active"'; ?>><i class="fas fa-chart-line"></i> Trending</a>
        <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
    </div>
    <div class="top-bar">
        <input type="text" placeholder="Search Discussion" class="search-bar">
        <a href="create.html" class="create-container">
            <img src="image/edit.png" alt="create" class="create">
            <span>Create</span>
        </a>
        <a href="login page.html" class="fas fa-user profile-icon"></a> <!-- Icon with user's name -->
    </div>
    <div class="content">
        <div class="filter w3-container">
            <div class="w3-bar w3-border">
                <a href="trending.php?filter=all" class="w3-bar-item w3-button <?php if ($filter == 'all') echo 'w3-black'; ?>">All Time</a>
                <a href="trending.php?filter=past7" class="w3-bar-item w3-button <?php if ($filter == 'past7') echo 'w3-black'; ?>">Past 7 Days</a>
                <a href="trending.php?filter=past30" class="w3-bar-item w3-button <?php if ($filter == 'past30') echo 'w3-black'; ?>">Past 30 Days</a>
            </div>

            <?php
            $rank = 1;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $medalClass = '';
                    switch ($rank) {
                        case 1:
                            $medalClass = 'gold-medal.png';
                            break;
                        case 2:
                            $medalClass = 'silver-medal.png';
                            break;
                        case 3:
                            $medalClass = 'bronze-medal.png';
                            break;
                        default:
                            $medalClass = '';
                            break;
                    }

                    echo "<a href='discussion.php?id=" . $row["id"] . "' class='forum-discussion-link'>";
                    echo "<div class='forum-discussion'>";
                    if ($medalClass) {
                        echo "<img src='images/$medalClass' class='medal' alt='Medal'>";
                    }
                    echo "<div class='subforum-date'><small>Posted on " . $row["created_at"] . "</small></div>";
                    echo "<div class='description'><h1>" . $row["title"] . "</h1></div>";
                    echo "<div class='subforum-description'><p>" . $row["content"] . "</p></div>";
                    echo "</div></a>";
                    
                    $rank++;
                }
            } else {
                echo "No discussions yet.";
            }

            $conn->close();
            ?>
        </div>
    </div>
    <script>
        function showFilters() {
            var filterOptions = document.getElementById("filterOptions");
            filterOptions.classList.toggle("show");
        }
    </script>
</body>
</html>
