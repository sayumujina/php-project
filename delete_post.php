<?php
session_start();
include 'db_connect.php';

// Set the header to indicate a JSON response
header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['session_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Check if a post ID is provided in the POST request
$postData = json_decode(file_get_contents("php://input"), true);
if (!isset($postData['post_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No post ID specified']);
    exit;
}

$post_id = $postData['post_id'];
$user_id = $_SESSION['session_id'];

// Delete the post from the database
try {
    // Use the correct column names from your database schema
    $stmt = $pdo->prepare("DELETE FROM posts WHERE post_id = :post_id AND user_id = :user_id");
    $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Check if the deletion was successful
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Post deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Post not found or you do not have permission to delete it']);
    }
} catch (PDOException $e) {
    // Return error message if the deletion fails
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete post: ' . $e->getMessage()]);
}
?>