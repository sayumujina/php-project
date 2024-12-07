<?php 
session_start(); // Start the session
if (!isset($_SESSION['session_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Include the PDO connection file
include 'db_connect.php';

$user_id = $_SESSION['session_id'];
$error = ""; // Variable to store error messages

if (isset($_POST['update'])) {
    $email = $_POST['email'];
    $current_password = $_POST['password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Retrieve current password from the database
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
        // Check if new password and confirm password match
        if ($new_password === $confirm_password) {
            // Update user profile, including name, email, and password
            $new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);
            $update_query = "UPDATE users SET email = :email, password = :password WHERE id = :id";
            $stmt = $conn->prepare($update_query);
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
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&amp;display=swap" rel="stylesheet">
    <style>
        h1{
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Edit Profile</h1>
    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <label for="password">Current Password:</label>
        <input type="password" name="password">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password">
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password">
        <div class="submit">
        <button type="submit" class="button"  name="update">Update Profile</button>
    </form>
    </div>
  
    <div class="submit">
    <a href="homepage.php" class="button">Back to Home</a>
    </div>
    <!-- Display error message if any -->
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <span id="PING_IFRAME_FORM_DETECTION" style="display: none;"></span>

<?php include 'dashboard.php'; ?> <!-- Include header content -->
</body>
</html>