<?php
include 'db_connect.php'; // Database connection

// Check if module IDs and action are set
if (isset($_POST['module_ids']) && isset($_POST['action'])) {
    $moduleIds = $_POST['module_ids'];
    $action = $_POST['action'];

    if ($action == 'edit') {
        // Redirect to a page for batch editing
        header("Location: batch_edit.php?ids=" . implode(",", $moduleIds));
        exit();
    } elseif ($action == 'delete') {
        // Delete selected modules
        $placeholders = implode(',', array_fill(0, count($moduleIds), '?'));
        $query = "DELETE FROM modules WHERE id IN ($placeholders)";
        $stmt = $pdo->prepare($query);
        
        if ($stmt->execute($moduleIds)) {
            header("Location: manage_modules.php?success=Selected modules deleted successfully.");
        } else {
            echo "<p class='message error'>Failed to delete selected modules.</p>";
        }
    }
} else {
    echo "<p class='message error'>No modules selected or action specified.</p>";
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

        <!-- Form to edit the module -->
        <form method="POST" action="">
            <label for="name">Module Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($module['name']); ?>" required>

            <label for="description">Module Description</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($module['description']); ?></textarea>

            <button type="submit">Save Changes</button>
        </form>
    </div>
    <?php include 'templates/headercontent.php'; ?>
</body>
</html>

