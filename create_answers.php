<?php
session_start();
include 'db_connect.php';

    // Redirect to login page if the user is not logged in
    if (!isset($_SESSION['session_id'])) {
        header('Location: login.php');
        exit;
    }

    // Fetch the post based on post_id from URL
    if (isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];

        try {
            // Fetch the post
            $posts = "SELECT * FROM posts WHERE post_id = :post_id";
            $stmt = $pdo->prepare($posts);
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->execute();
            $post = $stmt->fetch(PDO::FETCH_ASSOC);

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
    LEFT JOIN users ON answers.user_id = users.id WHERE post_id = :post_id";
    $stmt_answers = $pdo->prepare($answers);
    $stmt_answers->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt_answers->execute();
    $answers = $stmt_answers->fetchAll(PDO::FETCH_ASSOC);
    $creation_date = (new DateTime())->format('Y-m-d H:i:s');

    // Handle reply form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $content = trim($_POST['content']);
        $user_id = $_SESSION['session_id'];

        if (!empty($content)) {
            try {
                $posts = "INSERT INTO answers (post_id, user_id, username, content, answer_date) VALUES (:post_id, :user_id, :username, :content, :answer_date)";
                $stmt = $pdo->prepare($posts);
                $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
                $stmt->bindParam(':content', $content, PDO::PARAM_STR);
                $stmt->bindParam(':answer_date', $answer_date);
                $stmt->execute();

                // Reload the page to show the new reply
                header("Location: view_post.php?post_id=" . $post_id);
                exit;
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

            <!-- Reply form -->
            <h2>Reply to this post</h2>

            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <form method="POST">
                <textarea name="content" rows="4" cols="50" placeholder="Reply..." required></textarea>
                
                    <button type="submit" class="button">Submit Reply</button>
                    <div class="submit">
                    <a href="index.php" class="button">Back to Dashboard</a>
                </div>
            </form>
        </div>
        <?php include 'dashboard.php'; ?>
    </body>
</html>