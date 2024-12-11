<?php
session_start();
include 'db_connection.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    
    $stmt = $conn->prepare("SELECT token_timestamp FROM admin_credentials WHERE reset_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $token_timestamp = strtotime($row['token_timestamp']);
        $current_time = time();
        $time_difference = $current_time - $token_timestamp;
        
        
        if ($time_difference > 300) {
            
            $stmt = $conn->prepare("UPDATE admin_credentials SET reset_token = NULL, token_timestamp = NULL WHERE reset_token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            
            echo "<script>
                alert('Password reset link has expired. Please request a new one.');
                window.location.href = 'WelcomePage4ForgotPasswordAdmin.php';
            </script>";
            exit();
        }
    } else {
        echo "<script>
            alert('Invalid reset link.');
            window.location.href = 'WelcomePage4ForgotPasswordAdmin.php';
        </script>";
        exit();
    }
}

$message = "";

if (isset($_GET['token'])) {
    $token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING); 

    
    $stmt = $conn->prepare("SELECT admin_email FROM admin_credentials WHERE reset_token = ?");
    $stmt->bind_param("s", $token); 
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_email = $row['admin_email'];
    } else {
        $message = 'Invalid token.';
        exit; 
    }
} else {
    $message = 'No token provided.';
    exit; 
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $token = $_POST['token'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    
    $token = filter_var($token, FILTER_SANITIZE_STRING);

    
    $stmt = $conn->prepare("SELECT admin_email FROM admin_credentials WHERE reset_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_email = $row['admin_email'];
        
        if (strlen($new_password) < 8 || strlen($new_password) > 255) {
            $message = 'Password must be between 8 and 255 characters long.';
        } else if ($new_password !== $confirm_password) {
            $message = 'Passwords do not match.';
        } else {
            $updateStmt = $conn->prepare("UPDATE admin_credentials SET admin_password = ?, reset_token = NULL WHERE admin_email = ?");
            $updateStmt->bind_param("ss", $new_password, $user_email); 
            $updateStmt->execute();

            if ($updateStmt->affected_rows > 0) {
                $message = 'Password has been reset successfully.';
                header("Location: WelcomePage1.php");
            } else {
                $message = 'Failed to reset password. Please try again.';
            }

            $updateStmt->close();
        }
    } else {
        $message = 'Invalid token.';
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles11.css"> 
    <title>Reset Password</title>
</head>
<body>
    <div class="container">
        <h2>Reset Your Password</h2>

       
        <?php if ($message): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            
            <div class="password-requirement">
                Password must be at least 8 characters long
            </div>
            
            <div class="password-container">
                <input type="password" 
                    name="new_password" 
                    id="newPassword"
                    placeholder="Enter new password" 
                    minlength="8" 
                    maxlength="255" 
                    required>
                <span id="toggleNewPassword" class="password-toggle">👁️‍🗨️</span>
            </div>

            <div class="password-container">
                <input type="password" 
                    name="confirm_password" 
                    id="confirmPassword"
                    placeholder="Confirm new password" 
                    minlength="8" 
                    maxlength="255" 
                    required>
                <span id="toggleConfirmPassword" class="password-toggle">👁️‍🗨️</span>
            </div>

            <div id="password-match-message" style="color: red; display: none;">
                Passwords do not match!
            </div>

            <input type="submit" value="Reset Password" id="submit-btn">
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const newPassword = document.querySelector('input[name="new_password"]');
        const confirmPassword = document.querySelector('input[name="confirm_password"]');
        const submitBtn = document.getElementById('submit-btn');
        const matchMessage = document.getElementById('password-match-message');
        const form = document.querySelector('form');

        function checkPasswords() {
            if (confirmPassword.value === '') {
                matchMessage.style.display = 'none';
                submitBtn.disabled = false;
                return;
            }

            if (newPassword.value !== confirmPassword.value) {
                matchMessage.style.display = 'block';
                submitBtn.disabled = true;
            } else {
                matchMessage.style.display = 'none';
                submitBtn.disabled = false;
            }
        }

        newPassword.addEventListener('input', checkPasswords);
        confirmPassword.addEventListener('input', checkPasswords);

        
        document.getElementById('toggleNewPassword').addEventListener('click', function() {
            const passwordField = document.getElementById('newPassword');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.textContent = '👁️';
            } else {
                passwordField.type = 'password';
                this.textContent = '👁️‍🗨️';
            }
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const passwordField = document.getElementById('confirmPassword');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.textContent = '👁️';
            } else {
                passwordField.type = 'password';
                this.textContent = '👁️‍🗨️';
            }
        });

        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to reset your admin password?')) {
                this.submit();
            }
        });
    });
    </script>
</body>
</html>
