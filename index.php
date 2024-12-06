<?php
session_start();
include 'db_connect.php';

// Only open this page when the user session is present
if (!isset($_SESSION['session_id'])) {
    header('Location: login.php');
    exit;
}

// Create new post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $subject_id = $_POST['subject_id'];
    $creation_date = date("Y-m-d H:i:s");

    $query = "INSERT INTO posts (title, content, subject_id, user_id, create_time) VALUES (:title, :content, :subject_id, :user_id, NOW())";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':content', $content);
    $stmt->bindValue(':subject_id', $subject_id);
    $stmt->bindValue(':user_id', $_SESSION['session_id']);

    try {
        $stmt->execute();
        header('Location: list_posts.php');
        exit;
    } catch (PDOException $e) {
        echo "Error creating post: " . $e->getMessage();
    }
}

// Search with title
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;

// Fetch data according to subjects and filter options
$query = "SELECT posts.*, subject.subject_name FROM posts 
    LEFT JOIN subject ON posts.subject = subject.subject_id WHERE 1 = 1";
 
$search = [];

if ($keyword) {
    $query .= " AND (posts.title LIKE :keyword OR posts.content LIKE :keyword)";
    $search[':keyword'] = '%' . $keyword . '%';
}

$query .= " ORDER BY posts.creation_date DESC";

// Exceute searching
try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($search);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Error fetching posts: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <style>
    

    </style>
    <script>
        function deletePost(postId) {
            if (confirm('Are you sure you want to delete this post?')) {
                fetch('delete_post.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ post_id: postId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById(`post-${postId}`).remove();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the post.');
                });
            }
        }
    </script>
</head>
<body>
<div class="container">
        <div class="welcome">
            <h1>
                <?php
                if (isset($_SESSION['session_username'])) {
                    echo "Dashboard<strong>";
                } else {
                    echo "You are not logged in.";
                }
                ?>
            </h1>
        </div>

        <!-- Buttons -->
        <div>
            <a href="homepage.php" class="button">Home</a>
            <a href="list_posts.php" class="button">Create New Post</a>
            <a href="mailto:imestellia@gmail.com" class="button">Contact Admin</a>
        </div>

        <!--Search -->
        <div id="search" class="search">
            <form>
                <div class="search">
                    <label for="keyword">Keyword:</label>
                    <input type="text" name="keyword" id="keyword" placeholder="Enter keyword...">
                </div>
                <input type="submit" class="button" value="Search">
            </form>
        </div>

        <!-- Display Posts -->
        <h2>All Posts</h2>
        <div class="posts">
            <?php
            if (isset($error_message)) {
                echo "<p style='color: red;'>" . htmlspecialchars($error_message) . "</p>";
            } elseif ($posts) {
                foreach ($posts as $post) {
                    echo "<div title='post-" . $post['title'] . "' class='post'>";
                    echo "<h2><a href='view_post.php?title=" . $post['title'] . "'>" . htmlspecialchars($post['title']) . "</a></h2>";
                    echo "<p>" . htmlspecialchars($post['content']) . "</p>";
                    echo "<p>Subject: " . htmlspecialchars($post['subject_name']) . "</p>"; 

                    // Display creation date
                    $creationDate = new DateTime($post['creation_date']);
                    echo "<p>Created on: " . $creationDate->format('d M Y, H:i') . "</p>";

                    // Show edit and delete buttons if within 5 minutes
                    // if ($timeDiff <= 300) { // 300 seconds = 5 minutes
                    //     echo "<a href='edit_post.php?post_id=" . $post['id'] . "' class='btn'>Edit</a>";
                    //     echo "<button class='btn' onclick='deletePost(" . $post['id'] . ")'>Delete</button>";
                    // }

                    echo "</div>";
                }
            } else {
                echo "<p>No posts found.</p>";
            }
            ?>
        </div>
        <?php include 'templates/headercontent.php'; ?>
    </div>
</body>
</html>