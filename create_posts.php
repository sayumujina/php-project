<?php
session_start();
include 'db_connect.php';

    // Redirect to login page if the user is not logged in
    if (!isset($_SESSION['session_id'])) {
        header('Location: login.php');
        exit;
    }

    // Process data upon submitting
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = trim($_POST['title']);
        $content = trim($_POST['content']);
        $user_id = $_SESSION['session_id'];
        $module_id = $_POST['module_id'];
        $creation_date = (new DateTime())->format('Y-m-d H:i:s');

        // Insert post to the database'
        if (!empty($title) && !empty($content)) {
            try {
                $query = "INSERT INTO posts (user_id, username, title, content, module_id, creation_date) VALUES (:user_id, :username, :title, :content, :module_id, :creation_date)";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':user_id', $_SESSION['session_id'], PDO::PARAM_INT);
                $stmt->bindParam(':username', $_SESSION['session_username'], PDO::PARAM_STR);
                $stmt->bindParam(':title', $title, PDO::PARAM_STR);
                $stmt->bindParam(':content', $content, PDO::PARAM_STR);
                $stmt->bindParam(':module_id', $module_id, PDO::PARAM_STR);
                $stmt->bindParam(':creation_date', $creation_date);
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
        // Fetch modules from the database
        $query = "SELECT module_name FROM module";
        $stmt = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
    <style>
        h1 {
            text-align: center;
        }
        s
        .form-group, .submit {
            font-family: 'Nunito Sans', sans-serif;
            margin-bottom: 20px;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h1>Create a New Post</h1>
        <!--Display error message if there is one -->
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form action="create_posts.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" required>
            </div>

            <div class="form-group">
                <label for="content">Content:</label>
                <textarea type="text" name="content" id="content" rows="5" required></textarea>
            </div>

            <!-- Select module -->
            <div class="form-group">
                <label for="module_id">Module</label>
                <select name="module_id" id="module_id">
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <!-- Makes the module names visible -->
                        <option value="<?php echo $row['module_name']; ?>"><?php echo $row['module_name']; ?></option>
                    <?php endwhile; ?>
            </div>
            <button type="submit" class="button">Submit Post</button>
        </form>

        <div class="submit">
            <a href="index.php" class="button">Back to Dashboard</a>
        </div>
    </div>

    <?php include 'dashboard.php'; ?>
</body>
</html>

