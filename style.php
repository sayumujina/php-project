<?php 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Website Header</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <!-- Navigation Links -->
    <ul>
        <?php if (isset($_SESSION['session_id'])): ?>
        <?php endif; ?>
    </ul>
</nav>

</body>
</html>


