<?php
session_start();
include 'db_connect.php'; // Include database connection if needed

// Only open this page when the user session is present
if (!isset($_SESSION['session_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to the Home Page</h1>
            <?php
            if (isset($_SESSION['username'])) {
                echo "<p>Hello, <strong>" . htmlspecialchars($_SESSION['username']) . "</strong>! Glad to meet  you .</p>";
            }
            ?>
        </div>

        <!-- Navigation Links -->
        <div class="navigation">
            <a href="index.php" class="btn">Dashboard</a>
            <a href="edit_profile.php" class="btn">Edit Profile</a>
            <a href="mailto:imestellia@gmail.com" class="btn">Contact Admin</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>

        <!-- Main Content -->

        </div>
    </div>
    <?php include 'templates/home.php'; ?>
</body>
</html>
