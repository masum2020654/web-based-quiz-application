<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : 'An unexpected error occurred';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error - QuizApp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="error-container">
        <div class="error-card">
            <h2>Oops!</h2>
            <p><?php echo htmlspecialchars($error); ?></p>
            <a href="index.php" class="btn">Back to Home</a>
        </div>
    </div>
</body>
</html>
