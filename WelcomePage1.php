<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page - Student Success Hub</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div class="logo-container">
            <img src="image/bsulogo.png" alt="Connect Spartans Logo" class="logo">
        </div>

        <div class="stepper">
            <div class="step active">1</div>
            <div class="bridge"></div>
            <div class="step">2</div>
            <div class="bridge"></div>
            <div class="step">3</div>
        </div>

        <div class="welcome-header">
            <h1>Welcome to Connect Spartans</h1>
            <p>Your journey matters to us - let this form be set forth as the foundation of the guidance and support you truly deserve.</p>
        </div>

        <div class="proceed-selection">
            <form method="post" action="WelcomePage2RoleSelection.php">
                <button type="submit" name="role" value="First proceed" class="proceed-btn">PROCEED</button>
            </form>
        </div>

    </div>

</body>

</html>