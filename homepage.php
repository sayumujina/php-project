<?php
session_start();
include 'db_connect.php'; 

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
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to the Home Page</h1>
        </div>

        <!-- Navigation Links -->
        <div class="navigation">
            <a href="index.php" class="button">Dashboard</a>
            <a href="edit_profile.php" class="button">Edit Profile</a>
            <a href="contact_admin.php" class="button">Contact Admin</a>
            <a href="logout.php" class="button">Logout</a>
        </div>
    </div>
    <?php include 'home.php'; ?>
</body>
</html>
