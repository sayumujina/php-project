<?php 
include 'db_connect.php';

// Initialize variables
$fullname = '';
$username = '';
$email = '';
$password = '';
$success_message = '';
$error_message = '';

// Process the registration form when submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (fullname, username, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$fullname, $username, $email, $hashed_password]);
        $success_message = "Registration successful!";
        // Reset fields after successful submission
        $fullname = '';
        $username = '';
        $email = '';
        $password = '';
    } catch (PDOException $e) {
        $error_message = "An error occurred: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .container { width: 100%; max-width: 400px; padding: 20px; margin: auto; text-align: center; font-family: 'Poppins', sans-serif; }
        .form-group { display: flex; align-items: center; margin-bottom: 15px; }
        .form-control { flex: 1; padding: 10px; font-size: 16px; border: 1px solid #ddd; border-radius: 5px; margin-left: 10px; }
        .icon { font-size: 20px; }
        .btn { padding: 10px 20px; font-size: 18px; border: none; border-radius: 5px; background-color: #667eea; color: white; cursor: pointer; }
        .btn:hover { background-color: #556bdf; }
        .success-message { color: green; margin-bottom: 15px; }
        .error-message { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="container">
    <h1>sayumujina</h1>
    <div class="tab-container">
        Register
    </div>
    
    <div id="register-form">
        <form action="register.php" method="POST">
            <?php if (!empty($success_message)) : ?>
                <div class="success-message"><?php echo $success_message; ?></div>
            <?php elseif (!empty($error_message)) : ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <i class="fas fa-user icon"></i> <!-- Full Name Icon -->
                <input type="text" class="form-control" name="fullname" placeholder="Full Name" required value="<?php echo htmlspecialchars($fullname); ?>">
            </div>
            
            <div class="form-group">
                <i class="fas fa-user icon"></i> <!-- Username Icon -->
                <input type="text" class="form-control" name="username" placeholder="Username" required value="<?php echo htmlspecialchars($username); ?>">
            </div>
            
            <div class="form-group">
                <i class="fas fa-envelope icon"></i> <!-- Email Icon -->
                <input type="email" class="form-control" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($email); ?>">
            </div>
            
            <div class="form-group">
                <i class="fas fa-lock icon"></i> <!-- Password Icon -->
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            
            <button type="submit" class="btn">Register</button>
        </form>
    </div>
    
    <div class="link-container">
        <p>Already have an account? <a href="login.php">Login Here</a></p>
    </div>
    <div class="admin-link">
        <p>Are you an admin? <a href="admin_login.php">Admin Login Here</a></p>
    </div>
    <div class="contact-link">
        <a href="mailto:imestellia@gmail.com">Contact Admin</a>
    </div>

<?php include 'templates/header.php'; ?>
</body>
</html>
