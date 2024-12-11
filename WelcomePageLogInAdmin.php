<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';

$loginMessage = '';
$redirectToLoader = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logIn'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM admin_credentials WHERE admin_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        if ($password === $admin['admin_password']) {
            $_SESSION['admin_email'] = $admin['admin_email'];
            $redirectToLoader = true;
        } else {
            $loginMessage = "Invalid password";
            $_SESSION['last_email'] = $email;
        }
    } else {
        $loginMessage = "No user found with that email address";
        unset($_SESSION['last_email']);
    }

    $stmt->close();
    $conn->close();
}

if ($redirectToLoader) {
    header("Location: loader.php?redirect=HomePageForAdmin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Log In - Student Success Hub</title>
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

        <h1>Admin Log in</h1>

        <form method="post" id="loginForm">
            <input type="email"
                name="email"
                placeholder="Enter email address"
                value="<?php echo isset($_SESSION['last_email']) ? htmlspecialchars($_SESSION['last_email']) : ''; ?>"
                required>
            <div class="password-container">
                <input type="password" name="password" id="passwordField" placeholder="Enter password" required>
                <span id="togglePassword" class="password-toggle">👁️‍🗨️</span>
            </div>

            <?php if ($loginMessage): ?>
                <div class="error-message">
                    <span class="error-icon">⚠️</span>
                    <?php echo $loginMessage; ?>
                </div>
            <?php endif; ?>

            <div class="proceed-selection">
                <button type="submit" name="logIn" value="First proceed" class="proceed-btn">LOG IN</button>
            </div>

            <a href="WelcomePage4ForgotPasswordAdmin.php">Forgot Password?</a>
        </form>
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('passwordField');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.textContent = '👁️';
            } else {
                passwordField.type = 'password';
                this.textContent = '👁️‍🗨️';
            }
        });
    </script>
</body>

</html>