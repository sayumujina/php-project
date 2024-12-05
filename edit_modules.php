<?php
include 'db_connect.php'; // Database connection

// Check if subject IDs and action are set
if (isset($_POST['subject_ids']) && isset($_POST['action'])) {
    $subjectIds = $_POST['subject_ids'];
    $action = $_POST['action'];

    if ($action == 'edit') {
        // Redirect to a page for batch editing
        header("Location: batch_edit.php?ids=" . implode(",", $subjectIds));
        exit();
    } elseif ($action == 'delete') {
        // Delete selected subjects
        $placeholders = implode(',', array_fill(0, count($subjectIds), '?'));
        $query = "DELETE FROM subjects WHERE id IN ($placeholders)";
        $stmt = $pdo->prepare($query);
        
        if ($stmt->execute($subjectIds)) {
            header("Location: manage_subjects.php?success=Selected subjects deleted successfully.");
        } else {
            echo "<p class='message error'>Failed to delete selected subjects.</p>";
        }
    }
} else {
    echo "<p class='message error'>No subjects selected or action specified.</p>";
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Module</title>
    <style>
        bo
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .container label, .container input, .container textarea {
            width: 100%;
            margin-bottom: 10px;
            font-size: 1rem;
        }
        .container button {
            padding: 10px 20px;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Module</h1>

        <!-- Form to edit the subject -->
        <form method="POST" action="">
            <label for="name">Module Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($subject['name']); ?>" required>

            <label for="description">Module Description</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($subject['description']); ?></textarea>

            <button type="submit">Save Changes</button>
        </form>
    </div>
    <?php include 'templates/headercontent.php'; ?>
</body>
</html>

