<?php

session_start();
include 'db_connection.php';

// First check if student is logged in
if (!isset($_SESSION['student_email'])) {
    echo "error_not_logged_in";
    exit;
}

$logged_in_email = $_SESSION['student_email']; // This is from student_credentials

// Debug info
echo "<!-- Checking form for email: " . $logged_in_email . " -->";

// Check if this student has already submitted a form
$check_form = "SELECT COUNT(*) as count FROM form WHERE student_email = ?";
$stmt = $conn->prepare($check_form);
$stmt->bind_param("s", $logged_in_email);
$stmt->execute();
$result = $stmt->get_result();
$form_count = $result->fetch_assoc()['count'];

if ($form_count > 0) {
    echo "error_already_submitted";
    exit;
}

// If we get here, the student hasn't submitted a form yet
?>

<div class="stepper">
    <div class="step active">A</div>
    <div class="bridge"></div>
    <div class="step">B</div>
</div>

<div class="form-content">
    <div class="welcome-header">
        <h1>Welcome to Student Success Hub!</h1>
    </div>

    <div class="profile-img">
        <img src="image/profile.png" alt="Profile Icon">
    </div>

    <div class="some-text">
        <p>Ms. Maria Lourdes G. Balita, MPSyc, RPm, LPT OGC OIC-Head</p>
    </div>

</div>

<div class="button-container">
    <button type="button" class="next-btn" onclick="loadFormContent('FillingOutB.php')">NEXT</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nextBtn = document.querySelector('.next-btn');
        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                loadFormContent('FillingOutB.php');
            });
        }
    });
</script>