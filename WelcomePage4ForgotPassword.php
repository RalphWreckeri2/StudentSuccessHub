<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Student Success Hub</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div class="logo-container">
            <img src="image/bsulogo.png" alt="Connect Spartans Logo" class="logo">
        </div>

        <div class="stepper">
            <div class="step">1</div>
            <div class="bridge"></div>
            <div class="step">2</div>
            <div class="bridge"></div>
            <div class="step active">3</div>
        </div>

        <div class="form-box">
            <h1>Forgot your password</h1>
            <p>Please enter the email address you use for logging in <br> so that we can send you a link to reset your password.</p>

            <form action="ProcessForgotPassword.php" method="POST" id="forgotPasswordForm">
                <input type="email" name="email" id="email" placeholder="Enter email address" required>
                <button type="submit" name="role" value="First proceed" class="proceed-btn">REQUEST</button>
            </form>

            <a href="WelcomePage3LogInStudents.php" class="back-link">Back to Login</a>
        </div>
    </div>
</body>

</html>