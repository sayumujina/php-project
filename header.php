<?php 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Website Header</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <ul>
        <?php if (isset($_SESSION['session_id'])): ?>
        <?php endif; ?>
    </ul>
</nav>

</body>
</html>


