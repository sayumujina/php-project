<?php 
include 'db_connect.php';

// Variables
$username = '';
$email = '';
$password = '';
$register_complete = '';
$error= '';

// Process the registration form when submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Check if the email already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $emailExists = $stmt->fetchColumn();

        // Hash the password 
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if ($emailExists) {
            $error = "This email is already registered.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)"); // Prepare an insert statement with placeholders
            $stmt->execute([$username, $email, $hashed_password]);
            $register_complete = "Registration successful!";
            // Reset fields after successful submission
            $username = '';
            $email = '';
            $password = '';
        }
    } catch (PDOException $e) {
        $error = "An error occurred: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
        .register-complete{ 
            color: rgba(127, 171, 112); 
            margin-bottom: 15px; 
        }
        .error { 
            color: red; 
            margin-bottom: 15px; 
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Overflow</h1>
    <div id="register-form">
        <form action="register.php" method="POST">
            <!-- Display success message if registration is successful -->
            <?php if (!empty($register_complete)) : ?>
                <div class="register-complete"><?php echo $register_complete; ?></div>
            <!-- Otherwise, display error message -->
            <?php elseif (!empty($error)) : ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <!-- Registration form -->
            <div class="form-group">
                <i class="bi bi-person" ></i><input type="text" class="form-control" name="username" placeholder="Username" required value="<?php echo htmlspecialchars($username); ?>">
            </div>
            
            <div class="form-group">
                <i class="bi bi-envelope"></i><input type="email" class="form-control" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($email); ?>">
            </div>
            
            <div class="form-group">
                <i class="bi bi-lock" ></i><input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            
            <!-- Register button -->
            <button type="submit" class="btn">Register</button>
        </form>
    </div>
    
    <!-- Link to login page -->
    <div class="link-container">
        <p><b>Already have an account? </b><a href="login.php">Login Here</a></p>
    </div>

    <!-- Include styling template -->
    <?php include 'style.php'; ?>
</body>
</html>
