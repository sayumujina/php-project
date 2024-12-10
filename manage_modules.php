<?php
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['session_id'])) {
    header('Location: login.php');
    exit;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    try {
        if ($action === 'add') {
            // Add a new module
            $module_name = $_POST['module_name'];
            $query = "INSERT INTO module (module_name) VALUES (:module_name)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':module_name', $module_name, PDO::PARAM_STR);
            $stmt->execute();
            $success_message = "Module added successfully.";
        } elseif ($action === 'edit') {
            // Edit an existing module
            $module_id = $_POST['module_id'];
            $module_name = $_POST['module_name'];
            $query = "UPDATE module SET module_name = :module_name WHERE module_id = :module_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':module_id', $module_id, PDO::PARAM_INT);
            $stmt->bindParam(':module_name', $module_name, PDO::PARAM_STR);
            $stmt->execute();
            $success_message = "Module updated successfully.";
        } elseif ($action === 'delete') {
            // Delete a module
            $module_id = $_POST['module_id'];
            $query = "DELETE FROM module WHERE module_id = :module_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':module_id', $module_id, PDO::PARAM_INT);
            $stmt->execute();
            $success_message = "Module deleted successfully.";
        }
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}

// Fetch all modules
$query = "SELECT * FROM module";
$stmt = $pdo->query($query);
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Modules</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Manage Modules</h1>

        <!-- Display success and error messages -->
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <!-- Add Module -->
    <h2>Add Module</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="module_name_add" class="form-label">Module Name</label>
            <input type="text" name="module_name" id="module_name_add" class="form-control" required>
        </div>
        <button type="submit" name="action" value="add" class="button button-primary">Add Module</button>
    </form>

    <!-- Edit Module -->
    <h2>Edit Module</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="module_id_edit" class="form-label">Select Module</label>
            <select name="module_id" id="module_id_edit" class="form-select" required>
                <!-- Loop through all modules -->
                <?php foreach ($modules as $module): ?> 
                    <option value="<?php echo $module['module_id']; ?>"><?php echo $module['module_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="module_name_edit" class="form-label">New Module Name</label>
            <input type="text" name="module_name" id="module_name_edit" class="form-control" required>
        </div>
        <button type="submit" name="action" value="edit" class="button button-warning">Edit Module</button>
    </form>

    <!-- Delete Module -->
    <h2>Delete Module</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="module_id_delete" class="form-label">Select Module</label>
            <select name="module_id" id="module_id_delete" class="form-select" required>
                <!-- Loop through all modules -->
                <?php foreach ($modules as $module): ?>
                    <option value="<?php echo $module['module_id']; ?>"><?php echo $module['module_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="action" value="delete" class="button button-danger">Delete Module</button>
    </form>

    <a href="index.php" class="button button-secondary mt-3">Back to Dashboard</a>

    <!-- Include styling template -->
    <?php include 'dashboard.php'; ?>
</div>
</body>
</html>

    