<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "forum");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the specific discussion based on ID from URL
$discussion_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Increment view count in the discussions table
$update_view_sql = "UPDATE discussions SET view_count = view_count + 1 WHERE id = $discussion_id";
if ($conn->query($update_view_sql) !== TRUE) {
    echo "Error updating view count: " . $conn->error;
}

// Fetch the updated discussion details
$discussion_sql = "SELECT * FROM discussions WHERE id = $discussion_id";
$result = $conn->query($discussion_sql);

if ($result->num_rows > 0) {
    $discussion = $result->fetch_assoc();
} else {
    echo "Discussion not found.";
    exit();
}
// Handle new comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $comment_content = $conn->real_escape_string($_POST['comment']);
    $sql = "INSERT INTO comments (discussion_id, content, author, created_at) VALUES ($discussion_id, '$comment_content', 'Anonymous', NOW())";
    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch comments for the discussion
$comments_sql = "SELECT * FROM comments WHERE discussion_id = $discussion_id ORDER BY created_at DESC";
$comments_result = $conn->query($comments_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="home.css">
    <title>Discussion</title>
    <style>
        /* CSS for enlarging the discussion box and adding a "View More" button */
        .forum-discussion {
            width: auto;
            max-height: 250px; /* limit initial height */
            padding: 50px;
            margin: 20px 0;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden; /* hide overflow */
            transition: max-height 0.5s ease;
            position: relative;
        }
        .subforum-description p {
    margin: 10px 0;
    word-wrap: break-word; /* Ensures long words break and wrap */
    max-width: 100%; /* Adjust as per your design */
}

.discussion-image {
    max-width: 100%; /* Adjust as per your design */
    height: auto;
    margin-top: 10px;
}

        .expanded {
            max-height: 1000px; /* arbitrary large value to show full content */
        }

        .forum-discussion .subforum-avatar i {
            font-size: 24px;
            margin-right: 10px;
        }

        .forum-discussion h1 {
            margin: 10px 0;
            font-size: 24px;
        }

        .forum-discussion p,
        .forum-discussion ul {
            margin: 10px 0;
            font-size: 16px;
        }

        .forum-discussion ul {
            list-style-type: disc;
            padding-left: 20px;
        }

        .view-more {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: transparent;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s ease;
            text-align: center;
            cursor: pointer;
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
        }

        .view-more:hover {
            color: #0056b3;
        }

        .view-count {
            position: absolute;
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 14px;
            color: #555;
        }

        .comment-section {
            margin-top: 20px;
            padding: 20px;
            border-top: 1px solid #ddd;
        }

        .comment {
            display: flex;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .comment .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            overflow: hidden;
        }

        .comment .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .comment-content {
            flex: 1;
        }

        .comment-meta {
            font-size: 12px;
            color: #888;
        }
        .comment p {
            margin: 5px 0;
        }

        .comment-author {
            font-weight: bold;
        }

        .comment-input {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .comment-input textarea {
            width: 100%;
            resize: none;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .comment-input button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .comment-input button:hover {
            background-color: #0056b3;
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
        <a href="trending.php"><i class="fas fa-chart-line"></i> Trending</a>
        <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
    </div>
    <div class="top-bar">
        <input type="text" placeholder="Search Discussion" class="search-bar">
        <a href="create.php" class="create-container">
            <img src="image/edit.png" alt="create" class="create">
            <span>Create</span>
        </a>
        <i class="fas fa-user profile-icon"> lee yong</i>
    </div>
    <div class="content">
        <div class="forum-discussion" id="discussion1">
            <div class="subforum-avatar">
                <i class="fas fa-user profile-icon"> lee yong</i>
            </div>
            <div class="subforum-date">
                <small>Posted on <?php echo date("d M Y", strtotime($discussion['created_at'])); ?></small>
            </div>
            <div class="description">
                <h1><?php echo htmlspecialchars($discussion['title']); ?></h1>
            </div>
            <div class="subforum-description">
            <p><?php echo nl2br(htmlspecialchars(wordwrap($discussion['content'], 150, "<br>\n"))); ?></p>
         <?php if (!empty($discussion['image_path'])): ?>
        <img src="<?php echo htmlspecialchars($discussion['image_path']); ?>" alt="Discussion Image" class="discussion-image">
            <?php endif; ?>
            </div>

           
            <button class="view-more" onclick="toggleContent('discussion1', 'viewCount1')">View More</button>
        </div>

        <div class="count-info" id="countInfo">
            Total Comments: <span id="totalComments"><?php echo $comments_result->num_rows; ?></span>
        </div>

        <div class="comment-input" id="commentInput1">
            <form method="post">
                <textarea rows="4" name="comment" placeholder="Add a comment..."></textarea>
                <button type="submit">Submit</button>
            </form>
        </div>

        <div class="comment-section" id="comments1">
            <h2>Comments</h2>
            <?php
            if ($comments_result->num_rows > 0) {
                while ($comment = $comments_result->fetch_assoc()) {
                    echo '<div class="comment">';
                    echo '<div class="avatar"><img src="image/gold.png" alt="Avatar"></div>';
                    echo '<div class="comment-content">';
                    echo '<p class="comment-author">' . htmlspecialchars($comment['author']) . '</p>';
                    echo '<p>' . nl2br(htmlspecialchars($comment['content'])) . '</p>';
                    echo '<div class="comment-meta" data-timestamp="' . $comment['created_at'] . '"></div>';
                    echo '</div></div>';
                }
            } else {
                echo '<p>No comments yet. Be the first to comment!</p>';
            }
            ?>
        </div>
    </div>

    <script>
        function toggleContent(discussionId) {
    var discussionElement = document.getElementById(discussionId);

    if (discussionElement.classList.contains('expanded')) {
        discussionElement.classList.remove('expanded');
        document.querySelector(`#${discussionId} .view-more`).innerText = 'View More';
    } else {
        discussionElement.classList.add('expanded');
        document.querySelector(`#${discussionId} .view-more`).innerText = 'View Less';
    }
}

        
        // Function to calculate time ago
        function getTimeAgo(dateString) {
            var date = new Date(dateString);
            var seconds = Math.floor((new Date() - date) / 1000);

            var interval = Math.floor(seconds / 31536000);
            if (interval > 1) {
                return interval + " years ago";
            }
            interval = Math.floor(seconds / 2592000);
            if (interval > 1) {
                return interval + " months ago";
            }
            interval = Math.floor(seconds / 86400);
            if (interval > 1) {
                return interval + " days ago";
            }
            interval = Math.floor(seconds / 3600);
            if (interval > 1) {
                return interval + " hours ago";
            }
            interval = Math.floor(seconds / 60);
            if (interval > 1) {
                return interval + " minutes ago";
            }
            return Math.floor(seconds) + " seconds ago";
        }

        // Update comment timestamps
        document.addEventListener('DOMContentLoaded', function() {
            var commentMetas = document.querySelectorAll('.comment-meta');
            commentMetas.forEach(function(meta) {
                var timestamp = meta.getAttribute('data-timestamp');
                meta.innerText = getTimeAgo(timestamp);
            });
        });
    </script>
</body>
</html>