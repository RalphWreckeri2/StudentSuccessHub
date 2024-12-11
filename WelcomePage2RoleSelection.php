<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Role - Student Success Hub</title>
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
            <div class="step active">2</div>
            <div class="bridge"></div>
            <div class="step">3</div>
        </div>

        <h1>Your Role</h1>

        <form method="post">
            <div class="role-selection">
                <button type="submit" name="role" value="admin" class="role-btn">ADMIN</button>
                <button type="submit" name="role" value="student" class="role-btn">STUDENT</button>
            </div>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $role = $_POST['role'];
            if ($role == 'admin') {
                header("Location: WelcomePageLogInAdmin.php");
            } elseif ($role == 'student') {
                header("Location: WelcomePage3LogInStudents.php");
            }
            exit();
        }
        ?>

    </div>
</body>

</html>