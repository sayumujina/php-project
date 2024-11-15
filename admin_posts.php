<?php
session_start();
// Database connection
include 'db_connect.php'; // Ensure this file contains your database connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];
    $module_id = $_POST['module_id']; // Get the module_id from the form

    // Handle file upload if an image is provided
    $image_path = null;
    if (isset($_FILES['post_image']) && $_FILES['post_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $image_name = time() . '_' . basename($_FILES['post_image']['name']);
        $image_path = $upload_dir . $image_name;

        // Move the uploaded file to the server's upload directory
        if (!move_uploaded_file($_FILES['post_image']['tmp_name'], $image_path)) {
            $error_message = "Failed to upload image.";
            $image_path = null;
        }
    }

    // Insert the post with the image path into the database
    if (!empty($title) && !empty($content)) {
        try {
            $query = "INSERT INTO posts (user_id, title, content, image_path, module_id) VALUES (:user_id, :title, :content, :image_path, :module_id)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':image_path', $image_path, PDO::PARAM_STR);
            $stmt->bindParam(':module_id', $module_id, PDO::PARAM_INT); // Bind module_id
            $stmt->execute();

            // Redirect to manage posts page after successful post creation
            header("Location: manage_posts.php"); // Update redirection
            exit;
        } catch (PDOException $e) {
            $error_message = "Error creating post: " . $e->getMessage();
        }
    } else {
        $error_message = "Title and content are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Post</title>
    <style>
        body{
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-position: top;
            width: 100%;
            height: 100%;
            font-family: Arial, Helvetica;
            letter-spacing: 0.02em;
            font-weight: 400;   
            -webkit-font-smoothing: antialiased; 
            height: 100%;/* max-height: 600px; */
            background-color: hsla(200,40%,30%,4);
            background-image:   
            url('https://genshindle.com/data/gallery/backgrounds/bg-anemo.webp');
            background-position:  0 20%, 0 100%, 0 50%, 0 100%, 0 0;
            background-size: 2500px, 800px, 500px 200px, 1000px, 400px 260px;  
        }
        @keyframes para {100% {
            background-position:  -5000px 20%, -800px 95%, 500px 50%,
            1000px 100%, 400px 0;
        }
    }
        h1{
            text-align: center;
        }
        .back-link {
            background: linear-gradient(109.6deg, rgba(156, 252, 248, 1) 11.2%, rgba(110, 123, 251, 1) 91.1%);
            border-radius: 30px;
            padding: 10px 20px;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }
        .submit{
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Add New Post</h1>
    <form action="admin_posts.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="">
        <label for="module_id">Module:</label>
        <select name="module_id" required>
            <option value="1">GENERAL</option>
            <option value="14">HTML</option>
            <option value="12">JAVA</option>
            <option value="15">Space</option>
        </select>
        <label for="title">Title:</label>
        <input type="text" name="title" required>
        <label for="content">Content:</label>
        <textarea name="content" required></textarea>
        <label for="image">Image:</label>
        <input type="file" name="image">
        
        <button type="submit" class="btn">Add Post</button>
        
    </form>
    <div class="submit">
        <a href="manage_posts.php" class="back-link">Back to Manage Posts</a>
        </div>
</body>
</html>


    <?php include 'templates/headercontent.php'; ?>
</body>
</html>

