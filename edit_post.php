<?php
session_start();
include 'db_connect.php';

    // Check if user is logged in
    if (!isset($_SESSION['session_id'])) {
        header('Location: login.php');
        exit;
    }

    // Check if post ID is provided
    if (!isset($_GET['post_id'])) {
        echo "No post ID specified.";
        exit;
    }

    $post_id = $_GET['post_id'];

    // Fetch the post data
    try {
        $query = "SELECT * FROM posts WHERE post_id = :post_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        $post_id = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if post exists
        if (!$post_id) {
            echo "Post not found.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error fetching post: " . $e->getMessage();
        exit;
    }

    // Fetch post data from the database
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $module_id = $_POST['module_id'];

        // Update the post in the database
        try {
            // Connecting the post id is necessary, otherwise it will update all posts
            $updateQuery = "UPDATE posts SET title = :title, content = :content, module_id = :module_id WHERE post_id = :post_id";
            $stmt = $pdo->prepare($updateQuery);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':module_id', $module_id, PDO::PARAM_INT);
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                // Redirect back to manage_posts.php with a success message
                header("Location: index.php");
                exit();
            } else {
                $error_message = "Failed to update post.";
            }
        } catch (PDOException $e) {
            echo "Error updating post: " . $e->getMessage();
        }
    }

    // Fetch modules from the database
    $query = "SELECT module_id, module_name FROM module";
    $stmt = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
</head>
<body>
    <div class="container">
        <h1>Edit Post</h1>  
        <form method="POST" enctype="multipart/form-data">
            <label for="title">New title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post_id['title']); ?>" required><br>
            <br>

            <label for="content">New content:</label>
            <textarea id="content" name="content" rows="5" required><?php echo htmlspecialchars($post_id['content']); ?></textarea><br>
            <br>

            <!-- Select modules -->
            <div class="form-group">
            <label for="module_id">Module</label>
                <select name="module_id" id="module_id">
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <!-- Makes the module names visible -->
                        <option value="<?php echo $row['module_id']; ?>"><?php echo $row['module_name']; ?></option>
                    <?php endwhile; ?>
            </div>
            <br>

            <button type="submit" class="button">Update Post</button>
        </form>

        <div class="submit">
        <a href="index.php" class="button">Back to Dashboard</a>
        </div>
    </div>
    <?php include 'dashboard.php'; ?>
</body>
</html> 
 