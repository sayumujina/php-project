<?php 
include 'db_connect.php'; 
session_start(); // Start the session

// Variables
$username = '';
$password = '';
$error = '';

// Process the login form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user using input
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and password is correct and set session variables if true
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['session_id'] = $user['id'];
            $_SESSION['session_username'] = $user['username'];
            // Redirect to homepage after successful login
            header('Location: homepage.php'); 
            exit;
        // Display error message if user credentials are wrong
        } else {
            $error_message = "Incorrect username or password!";
        }
    } catch (PDOException $e) {
        $error= "An error occurred: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <style>
        .container { 
            width: 100%; 
            max-width: 400px; 
            padding: 20px; 
            margin: auto; 
            text-align: center;
        }
        .form-group { 
            display: flex; 
            align-items: center; 
            margin-bottom: 15px; 
        }
        .form-control { 
            flex: 1; 
            padding: 10px; 
            font-size: 16px;
            border: 1px solid #ddd; 
            border-radius: 5px; 
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Overflow</h1>
    <div id="login-form" style="display: block;">
        <form action="login.php" method="POST">
            <!-- Display error message if login fails -->
            <?php if (!empty($error_message)) : ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <!-- Login form -->
            <div class="form-group">
                <i class="bi bi-person"></i><input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            
            <div class="form-group">
                <i class="bi bi-lock"></i><input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            
            <!-- Login button -->
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
    
    <!-- Link to register page -->
    <div class="link-container">
        <p><b>or </b><a href="register.php">Register here</a></p>
    </div>

    <!-- Include styling template -->
    <?php include 'style.php'; ?>

</body>
</html>
