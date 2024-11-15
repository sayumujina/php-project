<?php
session_start();
include 'db_connect.php'; // Ensure this file contains your database connection setup

// Check if `post_id` is provided in the URL
if (!isset($_GET['post_id']) || empty($_GET['post_id'])) {
    die("Post ID is missing!");
}

$post_id = $_GET['post_id'];

// Fetch post details
try {
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->bindParam(':id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$post) {
        die("Post not found!");
    }
} catch (PDOException $e) {
    die("Error fetching post: " . $e->getMessage());
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $module_id = $_POST['module_id'];

    // Update post in the database
    try {
        $updateStmt = $pdo->prepare("UPDATE posts SET title = :title, content = :content, module_id = :module_id WHERE id = :id");
        $updateStmt->bindParam(':title', $title);
        $updateStmt->bindParam(':content', $content);
        $updateStmt->bindParam(':module_id', $module_id, PDO::PARAM_INT);
        $updateStmt->bindParam(':id', $post_id, PDO::PARAM_INT);
        
        if ($updateStmt->execute()) {
            // Redirect back to manage_posts.php with a success message
            header("Location: manage_posts.php?success=Post updated successfully");
            exit();
        } else {
            $error_message = "Failed to update post.";
        }
    } catch (PDOException $e) {
        $error_message = "Error updating post: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
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
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin: auto;
        }
        h1 {
            color: black;
            margin-bottom: 20px;
            font-weight: 600;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        .btn {
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            display: inline-block;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Post</h1>
        
        <?php if (isset($error_message)) echo "<p class='error'>$error_message</p>"; ?>

        <form action="admin_edit_post.php?post_id=<?php echo htmlspecialchars($post_id); ?>" method="POST">
            <div class="form-group">
                <label for="module_id">Module:</label>
                <select id="module_id" name="module_id" class="form-control" required>
                    <option value="1" <?php if ($post['module_id'] == 1) echo 'selected'; ?>>GENERAL</option>
                    <option value="14" <?php if ($post['module_id'] == 14) echo 'selected'; ?>>HTML</option>
                    <option value="12" <?php if ($post['module_id'] == 12) echo 'selected'; ?>>JAVA</option>
                    <option value="15" <?php if ($post['module_id'] == 15) echo 'selected'; ?>>Space</option>
                </select>
            </div>

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="content">Content:</label>
                <textarea id="content" name="content" class="form-control" rows="6" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>

           <button type="submit" class="btn">Update Post</button>
        </form>
        <br>
        <a href="manage_posts.php" class="btn">Back to Manage Posts</a>
    </div>
    <?php include 'templates/headercontent.php'; ?>
</body>
</html>
