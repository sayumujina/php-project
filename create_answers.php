<?php
session_start();
include 'db_connect.php';

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['session_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch the post based on post_id 
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    try {
        // Fetch the post
        $posts = "SELECT * FROM posts WHERE post_id = :post_id";
        $stmt = $pdo->prepare($posts);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
    // Handle errors
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
    } else {
        echo "Post not found.";
        exit;
    }
    
// Fetch answers to the post
$answers = "SELECT answers.*, users.username FROM answers
LEFT JOIN users ON answers.user_id = users.id WHERE post_id = :post_id"; // Join users and answers table
$stmt_answers = $pdo->prepare($answers);
$stmt_answers->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$stmt_answers->execute();
$answers = $stmt_answers->fetchAll(PDO::FETCH_ASSOC);
$creation_date = (new DateTime())->format('Y-m-d H:i:s');

// Fetch the user that is answering the post
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Anonymous';

// Handle answers submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = trim($_POST['content']);
    $user_id = $_SESSION['session_id'];
    $answer_date = (new DateTime())->format('Y-m-d H:i:s');

    // Insert the answer into the database, providing that content is not empty
    if (!empty($content)) {
        try {
            $posts = "INSERT INTO answers (post_id, user_id, username, content, answer_date) VALUES (:post_id, :user_id, :username, :content, :answer_date)";
            $stmt = $pdo->prepare($posts);
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $_SESSION['session_id'], PDO::PARAM_INT);
            $stmt->bindParam(':username', $_SESSION['session_username'], PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':answer_date', $answer_date);
            $stmt->execute();

            // Reload the page to show the new reply
            header("Location: create_answers.php?post_id=" . $post_id);
            exit;
        // Handle errors
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $error_message = "Please enter a reply.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
    .reply-container {
        margin-top: 20px;
        border: 3px solid rgb(174,144,106);
        border-radius: 12px;
        padding: 10px;
    }
</style>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($post['title']); ?></h1>
        <p><?php echo htmlspecialchars($post['content']); ?></p>
        <p>Creation date: <?php echo $post['creation_date']; ?></p>

        <hr>

        <!-- Display answers -->
        <h2>Answers</h2>
        <?php if ($answers): ?>
            <?php foreach ($answers as $answer): ?>
                <div class="reply-container">
                    <b><p><?php echo htmlspecialchars($answer['content']); ?></p></b>
                    <p>By: <?php echo htmlspecialchars($answer['username']); ?></p>
                    <p>Answer date: <?php echo $answer['answer_date']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No answers yet.</p>
        <?php endif; ?>
        
        <hr>

        <!-- Answer form -->
        <h2>Answer this question</h2>
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form method="POST">
            <textarea name="content" rows="4" cols="50" placeholder="Answer..." required></textarea>
                <button type="submit" class="button">Submit Reply</button>
                <div class="submit">
                <a href="index.php" class="button">Back to Dashboard</a>
            </div>
        </form>
    </div>
        
    <!-- Include styling template -->
    <?php include 'dashboard.php'; ?>
</body>
</html>