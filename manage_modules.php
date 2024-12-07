<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Modules</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&amp;display=swap" rel="stylesheet">
    <style>
        body {
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-position: top;
            width: 100%;
            height: 100%;
            font-family: Arial, Helvetica;
            letter-spacing: 0.02em;
            font-weight: 400;   
            -webkit-font-smoothing: antialiased; 
            background-color: hsla(200,40%,30%,4);
            background-image:   
            url('https://genshindle.com/data/gallery/backgrounds/bg-anemo.webp');
            
            background-position:  0 20%, 0 100%, 0 50%, 0 100%, 0 0;
            background-size: 2500px, 800px, 500px 200px, 1000px, 400px 260px;  
        }
        @keyframes para {100% {
            background-position:  -5000px 20%, -800px 95%, 500px 50%,
            1000px 100%, 400px 0;
        }
    }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        h1 {
            color: #4a4a4a;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .btn {
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            width: 93%;
            text-align: center;
            text-decoration: none;
            margin-bottom: 20px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .module-list {
            list-style-type: none;
            padding: 0;
        }
        .module-list li {
            margin-bottom: 10px;
        }
        .module-list a {
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .module-list a.edit {
            color: #4a4a4a;
        }
        .module-list a.edit:hover {
            color: #87ceeb; /* Sky Blue */
            cursor: pointer;
        }
        .module-list a.delete {
            color: #f44336; /* Red */
        }
        .module-list a.delete:hover {
            color: #ff7961; /* Lighter Red */
            cursor: pointer;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .message.success {
            background-color: #e8f5e9;
            color: #4caf50;
        }
        .message.error {
            background-color: #ffebee;
            color: #f44336;
        }
    </style>
</head>
<body>
    <?php if (isset($_GET['success'])): ?>
        <div class="message success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>

    <div class="container">
        <h1>Manage Modules</h1>
        <a href="add_module.php" class="btn">Add New Module</a>

        <!-- Form for batch edit/delete -->
        <form method="POST" action="edit_modules.php">
            <ul class="module-list">
                <?php
                // Fetch all modules from the database
                $modules = SELECT * FROM modules;
                foreach ($modules as $module) {
                    echo "<li>";
                    echo "<input type='checkbox' name='module_ids[]' value='{$module['id']}'> ";
                    echo htmlspecialchars($module['name']);
                    echo " <a href='edit_module.php?id={$module['id']}' class='edit'>Edit</a> | ";
                    echo "<a href='javascript:void(0);' class='delete' onclick=\"confirmDelete('delete_module.php?id={$module['id']}')\">Delete</a>";
                    echo "</li>";
                }
                ?>
            </ul>
        </form>

        <br>
        <a href="admin_dashboard.php" class="btn">Back to Admin Dashboard</a>
    </div>

    <script>
        function confirmDelete(url) {
            if (confirm("Are you sure you want to delete this module?")) {
                window.location.href = url;
            }
        }
    </script>
</body>
</html>
