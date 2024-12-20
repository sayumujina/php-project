<?php
session_start();
include 'db_connect.php';

// Only open this page when the user session is present
if (!isset($_SESSION['session_id'])) {
    header('Location: login.php');
    exit;
}

// Search with keyword
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;

$search = [];
$searchQuery = "WHERE 1 = 1"; // 1 = 1 is always true, therefore it works as a placeholder

// Check for posts with the keyword
if ($keyword) {
    $searchQuery .= " AND (posts.title LIKE :keyword OR posts.content LIKE :keyword)";
    $search[':keyword'] = '%' . $keyword . '%';
}

// Fetch data according to modules, newest post comes first
$query = "SELECT posts.*, module.module_name FROM posts 
    LEFT JOIN module ON posts.module_id = module.module_id $searchQuery  
    ORDER BY posts.creation_date DESC"; 
    
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
        
        body {
            font-weight: 600;
        }
        .top-button-container {
        display: flex;
        justify-content: center; 
        gap: 1rem; 
        margin: 1rem 0; 
        }

    </style>
    <script>
        // Function to delete a post
        function deletePost(postId) {
            if (confirm('Are you sure you want to delete this post?')) {
                window.location.href = 'delete_post.php?post_id=' + postId;
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
                    echo "You are not logged in."; // If the user is not logged in, display this message
                }
                ?>
            </h1>
        </div>

        <!-- Buttons -->
        <div class="top-button-container">
            <a href="homepage.php" class="button">Home</a>
            <a href="create_posts.php" class="button">Create New Post</a>
            <a href="contact_admin.php" class="button">Contact Admin</a>
            <a href="manage_modules.php" class="button">Manage Modules</a>
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
                // Loop through all posts
                foreach ($posts as $post) {
                    echo "<div title='post-" . $post['title'] . "' class='post'>";
                    echo "<h2><a href='create_answers.php?post_id=" . $post['post_id'] . "'>" . htmlspecialchars($post['title']) . "</a></h2>";
                    echo "<p>" . htmlspecialchars($post['content']) . "</p>";
                    echo "<p>Module: " . htmlspecialchars($post['module_name']) . "</p>"; 
                    echo "<p>Created by: " . htmlspecialchars($post['username']) . "</p>";
                    
                    // Display creation date
                    $creationDate = new DateTime($post['creation_date']);
                    echo "<p>Created on: " . $creationDate->format('d M Y, H:i') . "</p>";

                    // Display edit and delete buttons
                    echo "<a href='edit_post.php?post_id=" . $post['post_id'] . "' class='button'>Edit</a>";
                    echo "<button class='button' style='margin-left: 10px' onclick='deletePost(" . $post['post_id'] . ")'>Delete</button>";
                    
                    echo "</div>";
                }
            } else {
                echo "<p>No posts found.</p>"; // If no posts are found, display this message
            }
            ?>
        </div>
        
        <!-- Include styling template -->
        <?php include 'dashboard.php'; ?>
    </div>
</body>
</html>