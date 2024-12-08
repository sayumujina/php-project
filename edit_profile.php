<?php 
session_start(); // Start the session
include 'db_connect.php';

if (!isset($_SESSION['session_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

$user_id = $_SESSION['session_id'];
$error = ""; // Variable to store error messages

// Handle profile update
if (isset($_POST['update'])) {
    $email = $_POST['email'];
    $current_password = $_POST['password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current password from the database
    $query = "SELECT password FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query); // Prepare the query
    $stmt->bindParam(':id', $user_id); // Bind the user ID
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the result
    $db_password = $result['password'];

    // Verify the current password
    if (!password_verify($current_password, $db_password)) {
        $error = "Your current password is incorrect."; // Error message if wrong password
    } else {
        // Check if passwords match
        if ($new_password === $confirm_password) {
            // Update user profile, including name, email, and password
            $new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);
            $update_query = "UPDATE users SET email = :email, password = :password WHERE id = :id";
            $stmt = $pdo->prepare($update_query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $new_password_hashed);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();
            header('Location: edit_profile.php'); // Redirect after successful update
            exit;
        } else {
            $error = "New password and confirm password do not match.";
        }
    }
}

// Handle user deletion
if (isset($_POST['delete_account'])) {
    try {
        // Delete the user from the database
        $delete_query = "DELETE FROM users WHERE id = :id";
        $stmt = $pdo->prepare($delete_query);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();

        // Destroy the session and redirect to login page
        session_destroy();
        header('Location: login.php'); // Redirect to login after successful deletion
        exit;
    } catch (PDOException $e) {
        $error = "Error deleting account: " . $e->getMessage();
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        h1 {
            text-align: center;
        }
        .button:hover {
            background-color: darkblue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>

        <!-- Display error message if any -->
        <?php if (!empty($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Form to update profile -->
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Current Password:</label>
            <input type="password" name="password" required>

            <label for="new_password">New Password:</label>
            <input type="password" name="new_password">

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" name="confirm_password">

            <button type="submit" class="button" name="update">Update Profile</button>
        </form>

        <div class="submit">
            <a href="homepage.php" class="button">Back to Home</a>
        </div>

        <!-- Form to delete the user account, with a confirmation from users -->
        <form method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
            <button type="submit" class="button" style="background-color: red; max-width: 180px;" name="delete_account">Delete Account</button>
        </form>
    </div>

    <!-- Include styling template -->
    <?php include 'dashboard.php'; ?> 
</body>
</html>
