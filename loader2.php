<?php
session_start();


if (!isset($_SESSION['student_email']) || !isset($_GET['redirect'])) {
    header("Location: WelcomePage3LogInStudents.php");
    exit();
}

$redirectUrl = filter_var($_GET['redirect'], FILTER_SANITIZE_URL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging In...</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url("image/bsubg.png");
        }

        .loader-content {
            text-align: center;
        }

        .loader-content p {
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .loading-image {
            width: 150px;
            height: 150px;
            animation: pulse 2s ease-in-out infinite;
            margin: 0 auto 10px;
            display: block;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.8);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(0.8);
            }
        }
    </style>
</head>

<body>
    <div class="loader"></div>
    <script>
        setTimeout(function() {
            window.location.href = '<?php echo $redirectUrl; ?>';
        }, 3000);
    </script>
    <div class="loader-content">
        <img src="image/bsulogo.png" class="loading-image" alt="Loading">
        <p>Processing, please wait...</p>
    </div>
</body>

</html>