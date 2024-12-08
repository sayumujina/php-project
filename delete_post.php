<?php
session_start();
include 'db_connect.php';

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['session_id'])) {
    header('Location: login.php');
    exit;
}

// Check if a post ID is provided in the GET request
if (!isset($_GET['post_id'])) {
    echo "No post ID specified.";
    exit;
}

$post_id = $_GET['post_id'];

// Try deleting the post from the database
try {
    $stmt = $pdo->prepare("DELETE FROM posts WHERE post_id = :post_id");
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();

    // Check if the post was deleted successfully
    if ($stmt->rowCount() > 0) {
        echo "Post deleted successfully.";
        // Redirect back to index.php after deletion
        header('Location: index.php');
        exit;
    } else {
        echo "Post not found.";
    }
} catch (PDOException $e) {
    // Return error message if the deletion fails
    echo "Failed to delete post: " . $e->getMessage();
}
?>
