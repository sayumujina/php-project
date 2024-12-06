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
    $creation_date = (new DateTime())->format('d M Y, H:i');

    // Insert post to the database'
    if (!empty($title) && !empty($content)) {
        try {
            $query = "INSERT INTO posts (user_id, title, content, creation_date) VALUES (:user_id, :title, :content, :creation_date)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':creation_date', $creation_date, PDO::PARAM_STR);
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
    // Initialize subject
    $query = "SELECT subject_name FROM subject";
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
        s
        .form-group, .submit {
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
                <label for="subject_id">Subject</label>
                <select name="subject_name" id="subject_id">
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo $row['subject_name']; ?>"><?php echo $row['subject_name']; ?></option>
                    <?php endwhile; ?>
            </div>

            <button type="submit" class="button">Submit Post</button>
            
        </form>

        <div class="submit">
            <a href="index.php" class="button">Back to Dashboard</a>
        </div>
    </div>

    <?php include 'templates/headercontent.php'; ?>
</body>
</html>

