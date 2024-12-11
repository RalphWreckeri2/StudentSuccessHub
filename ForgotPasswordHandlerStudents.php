<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_unset();
    session_destroy();
    header("Location: WelcomePage1.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Link</title>
    <link rel="stylesheet" href="styles10.css">
</head>
<body>
    <div class="container">
        <div class="warning-box">
            <div class="warning-icon">📧</div>
            <h2 class="notice-text">Password Reset Link Sent</h2>
            <p class="message">Please visit your email account.</p>
            <div class="button-group">
                <a href="WelcomePage1.php" class="proceed-btn">OK</a>
            </div>
        </div>
    </div>
</body>
</html>
