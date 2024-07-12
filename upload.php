<?php
    include('submit_discussion.php');
    if(isset($_POST['submit'])){
        $file_name = $FILES['image']['name'];
        $tempname = $_FILES['image']['tmp_name'];
        $folder = 'image/'.$file_name;

        $query = mysqli_query($con, "Insert into discussions (file) value ('$file_name')");
        
        if(move_uploaded_file($tempname, $folder)){
            ech
        }
    }
?>