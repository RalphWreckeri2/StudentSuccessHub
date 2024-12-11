<?php
session_start();


error_reporting(E_ALL);
ini_set('display_errors', 1);


include 'db_connection.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require __DIR__ . '/vendor/autoload.php';


function sendResetEmail($email, $token)
{
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'noreplyadvcomp@gmail.com';
        $mail->Password   = 'epftpvbpjyxaybyj';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;


        $mail->setFrom('noreplyadvcomp@gmail.com', 'Student Success Hub');
        $mail->addAddress($email);
        $mail->Subject = 'Password Reset Request';
        $resetLink = "http://localhost/php_program/Student%20Success%20Hub/Student%20Success%20Hub/ResetPasswordAdmin.php?token=" . urlencode($token);
        $mail->Body = "Hi $email, <br><br>We received your request for a password change. To reset your password, kindly click the link within five minutes: <a href='$resetLink'>Reset Password Link</a><br><br>If you didn't request this link, someone might have entered your email by mistake.<br><br>Please note that this reset link expires in 5 minutes.<br><br>Thanks.";
        $mail->isHTML(true);


        $mail->SMTPDebug = 2;


        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "<script>
            alert('Mailer Error: " . addslashes($mail->ErrorInfo) . "');
            window.location.href = 'WelcomePage4ForgotPasswordAdmin.php';
        </script>";
        return false;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $stmt = $conn->prepare("SELECT * FROM admin_credentials WHERE admin_email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                $token = bin2hex(random_bytes(16));
                $timestamp = date('Y-m-d H:i:s');

                $updateStmt = $conn->prepare("UPDATE admin_credentials SET reset_token = ?, token_timestamp = ? WHERE admin_email = ?");
                if ($updateStmt) {
                    $updateStmt->bind_param("sss", $token, $timestamp, $email);
                    $updateStmt->execute();
                    $updateStmt->close();

                    if (sendResetEmail($email, $token)) {
                        header("Location: ForgotPasswordHandlerAdmin.php");
                        exit();
                    } else {
                        echo "<script>
                            alert('Message could not be sent. Please try again later.');
                            window.location.href = 'WelcomePage4ForgotPasswordAdmin.php';
                        </script>";
                    }
                } else {
                    echo "<script>
                        alert('Database error: " . addslashes($conn->error) . "');
                        window.location.href = 'WelcomePage4ForgotPasswordAdmin.php';
                    </script>";
                }
            } else {
                echo "<script>
                    alert('No account found with that email address.');
                    window.location.href = 'WelcomePage4ForgotPasswordAdmin.php';
                </script>";
            }
            $stmt->close();
        } else {
            echo "<script>
                alert('Database error: " . addslashes($conn->error) . "');
                window.location.href = 'WelcomePage4ForgotPasswordAdmin.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Invalid email format.');
            window.location.href = 'WelcomePage4ForgotPasswordAdmin.php';
        </script>";
    }
}

$conn->close();
