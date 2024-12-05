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

// Filters by filterOptions, date, and keyword
$filterOptions = isset($_GET['filterOptions']) && $_GET['filterOptions'] !== 'all' ? $_GET['filterOptions'] : null;
$date = isset($_GET['date']) ? $_GET['date'] : null;
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;

// Fetch data according to subjects and filter options
$query = "SELECT posts.*, subject_name as subject_name FROM posts 
          LEFT JOIN subject ON subject_id WHERE 1 = 1";
$filters = [];

if ($filterOptions) {
    $query .= " AND filterOptions = :filterOptions";
    $filters[':filterOptions'] = $filterOptions;
}

if ($date) {
    $query .= " AND DATE(creation_date) = :date";
    $filters[':date'] = $date;
}

if ($keyword) {
    $query .= " AND (title LIKE :keyword OR content LIKE :keyword)";
    $filters[':keyword'] = '%' . $keyword . '%';
}

$query .= " ORDER BY posts.creation_date DESC";

// Execute the query with filters
try {
    $stmt = $pdo->prepare($query);
    foreach ($filters as $param => $value) {
        $stmt->bindValue($param, $value);
    }
    $stmt->execute();
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
      
    input[type="date"] {
        padding: 8px ;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

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
                    echo "Welcome to Dashboard, <strong>" . htmlspecialchars($_SESSION['session_username']) . "</strong>!";
                } else {
                    echo "You are not logged in.";
                }
                ?>
            </h1>
        </div>

        <!-- Buttons -->
        <div class="action-buttons">
            <a href="homepage.php" class="button">Home</a>
            <a href="list_posts.php" class="button">Create New Post</a>
            <a href="mailto:imestellia@gmail.com" class="button">Contact Admin</a>
        </div>
        
        <!--Toggle the filter form visibility -->
        <script>
        function toggleFilterMenu() {
            const filterForm = document.getElementById('filterForm');
            filterForm.style.display = filterForm.style.display === 'block' ? 'none' : 'block';
        }
        </script>

        <!--Filter-->
        <div class="filter-menu">
            <button class="button" onclick="toggleFilterMenu()"><i class="bi bi-filter-left"></i>Filter</button>
    
        </div>

        <!-- Filter Form -->
        <div id="filterForm" class="filter-form" style="display:none;">
            <h3>Filter</h3>
            <form action="index.php" method="GET">
                <div class="filter-option">
                    <label for="filterOptions">Filter options:</label>
                    <select name="filterOptions" id="filterOptions">
                        <option value="all">All</option>
                        <option value="filterOptions1">Nearest</option>
                        <option value="filterOptions2">Recent activity</option>
                        <option value="filterOptions3">Most Frequent</option>
                        <option value="filterOptions4">Answers</option>
                    </select>
                </div>
                <div class="filter-option">
                    <label for="date">Date:</label>
                    <input type="date" name="date" id="date">
                </div>
                <div class="filter-option">
                    <label for="keyword">Keyword:</label>
                    <input type="text" name="keyword" id="keyword" placeholder="Enter keyword...">
                </div>
                <input type="submit" class="btn" value="Apply Filters">
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
                    echo "<div id='post-" . $post['id'] . "' class='post'>";
                    echo "<h2>Poster: <a href='view_post.php?post_id=" . $post['id'] . "'>" . htmlspecialchars($post['title']) . "</a></h2>";
                    echo "<p>Post Content: " . htmlspecialchars($post['content']) . "</p>";
                    echo "<p>Module: " . htmlspecialchars($post['subject_name']) . "</p>"; // Display subject name instead of ID

                    // Display the created_at timestamp
                    $creationDate = new DateTime($post['creation_date']);
                    echo "<div class='post-meta'>Posted on: " . $createdAt->format('F j, Y, g:i a') . "</div>";

                    // Calculate if 10 minutes have passed since post creation
                    $currentTime = new DateTime();
                    $timeDiff = $currentTime->getTimestamp() - $createdAt->getTimestamp();

                    // Show edit and delete buttons if within 5 minutes
                    if ($timeDiff <= 300) { // 300 seconds = 5 minutes
                        echo "<a href='edit_post.php?post_id=" . $post['id'] . "' class='btn'>Edit</a>";
                        echo "<button class='btn' onclick='deletePost(" . $post['id'] . ")'>Delete</button>";
                    }

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