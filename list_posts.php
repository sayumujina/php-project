<?php
session_start();
include 'db_connect.php';

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['session_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['session_id'];

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
            $query = "INSERT INTO posts (user_id, title, content, image_path) VALUES (:user_id, :title, :content, :image_path)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':image_path', $image_path, PDO::PARAM_STR);
            $stmt->execute();

            // Redirect to index.php after successful post creation
            header("Location: index.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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
        h1 {
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
        .form-group, .submit {
            margin-bottom: 20px;
        }
        .btn {
            background-color: #6e7bfb;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create a New Post</h1>

        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form action="list_posts.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" required>
            </div>

            <div class="form-group">
                <label for="content">Content:</label>
                <textarea name="content" id="content" rows="5" required></textarea>
            </div>

            <div class="form-group">
                <label for="subject_id">Module:</label>
                <select name="subject_id" id="subject_id" required>
                    <option value="1">GENERAL</option>
                    <option value="14">HTML&JAVA</option>
                    <option value="12">MYSQL</option>
                    <option value="15">PHP</option>
                </select>
            </div>

            <div class="form-group">
                <label for="post_image">Upload Image:</label>
                <input type="file" name="post_image" id="post_image" accept="image/*">
            </div>

            <button type="submit" class="btn">Submit Post</button>
        </form>

        <div class="submit">
            <a href="index.php" class="back-link">Back to Dashboard</a>
        </div>
    </div>

    <?php include 'templates/headercontent.php'; ?>
</body>
</html>

