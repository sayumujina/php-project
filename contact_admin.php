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

    // Send email or save to database (example: email)
    $to = 'admin@example.com';
    $subject = 'New Contact Form Message';
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(['status' => 'success', 'message' => 'Message sent successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send the message.']);
    }
}
?>

<!doctype html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
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
        color: rgb(174, 144, 106);
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

    .contact-panel .button {
        width: 100%;
        padding: 0.8rem;
        font-size: 1rem;
        font-weight: 600;
        background-color: rgba(127, 171, 112);
        color: #fff;
        border: none;
        border-radius: 40px;
        cursor: pointer;
        transition: all 0.3s ease;
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
    <div class="contact-panel">
    <h2>Contact Admin</h2>
    <form id="contact-form">
        <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
        </div>
        <div class="form-group">
            <label for="email">Your Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label for="message">Your Message</label>
            <textarea id="message" name="message" class="form-control" rows="5" placeholder="Enter your message" required></textarea>
        </div>
        <button type="submit" class="button">Send Message</button>
    </form>
    
    <?php include 'dashboard.php'; ?>
    
</div>
