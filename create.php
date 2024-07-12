
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="home.css">
    <title>Create Discussion</title>
    <style>
        body {
            background-color: #f0f2f5;
        }

        .create-form-container {
            margin-left: 30%;
            margin-top: 100px;
            padding: 20px;
            padding-bottom: 500px;
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 12px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        .create-form-container h2 {
            margin-bottom: 20px;
            color: #0079d3;
        }

        .create-form {
            display: flex;
            flex-direction: column;
        }

        .create-form input[type="text"],
        .create-form textarea,
        .create-form input[type="file"] {
            margin-bottom: 16px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 100%;
            max-width: 600px;
            box-sizing: border-box;
        }

        .create-form button {
            padding: 12px 16px;
            border: none;
            border-radius: 8px;
            background-color: #0079d3;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .create-form button:hover {
            background-color: #005bb5;
        }

        .create_title{
            margin-bottom: 8px;
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


    <div class="create-form-container">
        <h2>Create New Discussion</h2>
        <form class="create-form" action="submit_discussion.php" method="POST" enctype="multipart/form-data">

        <label for="title" class="create_title">
                  <b> Title </b> 
    </label>
    <input type="text" name="title" placeholder="Discussion Title" required>

    <label for="Description" class="create_title">
                  <b> Description </b> 
    </label>
    <textarea name="content" rows="10" placeholder="Discussion Content" required></textarea>

    <label for="image" class="create_title">
                  <b> Image </b> 
    </label>
    <input type="file" name="image" >


    <label for="tagnames" class="create_title">
                    <b>Tags</b> 
    </label>
    <input id="title" name="title" type="text" maxlength="300" placeholder="Choose up to 3 tags for your discussion" class="s-input js-post-title-field ask-title-field" value="" data-min-length="15" data-max-length="150">
    <button type="submit">Submit</button>
</form>

    </div>
</body>



<script>
document.getElementById('image').addEventListener('change', function() {
  var fileInput = document.getElementById('image');
  var fileName = fileInput.files[0].name;
  document.getElementById('file-label').innerText = fileName;
});
</script>

</html>
