<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    // Validate inputs (simplified)
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    // Send email
    $to = 'imestellia@gmail.com'; // Placeholder email address
    $module = 'Customer Support Request'; // Placeholder email subject
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $email";

    // Since this code is running on local host and will not actually send an email, the warning message will be suppressed 
    if (@mail($to, $module, $body, $headers)) {
        $statusMessage = 'Message sent successfully.';
    }
}
?>

<!doctype html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>

    .contact-panel {
        background-color: #fff;
        border: 3px solid rgb(174, 144, 106);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        width: 100%;
        max-width: 600px;
        margin: 2rem auto;
    }

    .contact-panel h2 {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 1.5rem;
    }

    .contact-panel .form-group {
        margin-bottom: 1.5rem;
    }

    .contact-panel .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .contact-panel .form-control {
        width: 100%;
        padding: 0.8rem;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .send-successful {
        color: green;
        font-weight: 600;
        text-align: center;
        margin-top: 1rem;
    }

    @media (max-width: 768px) {
        .contact-panel {
            padding: 1.5rem;
        }

        .contact-panel h2 {
            font-size: 1.8rem;
        }
    }

</style>
<body>
    <div class="contact-panel">
    <h2>Contact Admin</h2>
    <!-- Display the status message -->
    <?php if (!empty($statusMessage)): ?>
        <div class="send-successful"> <?php echo $statusMessage ?> </div>
    <?php endif; ?>
    
    <!-- Form to contact admin -->
    <form id="contact-form" method="POST" action="">
        <!-- Name input -->
        <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
        </div>
        <!-- Email input -->
        <div class="form-group">
            <label for="email">Your Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <!-- Message input -->
        <div class="form-group">
            <label for="message">Your Message</label>
            <textarea id="message" name="message" class="form-control" rows="5" placeholder="Message" required></textarea>
        </div>
        <!-- Submit button -->
        <button type="submit" class="button">Send Message</button>
        <a class="button" href="homepage.php">Back to Home</a>
    </form>        
    </div>

    <!-- Include styling template -->
    <?php include 'dashboard.php'; ?>
</body>
