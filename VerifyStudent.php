<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verifies student credentials against the database
 * 
 * @param mysqli $conn The database connection object
 * @param string $form_email The student's email from form
 * @param string $form_sr_code The student's SR code from form
 * @return string Status of verification
 */
function verifyStudentCredentials($conn, $form_email, $form_sr_code)
{
    if (!isset($_SESSION['student_email'])) {
        return "not_logged_in";
    }

    
    $stmt = $conn->prepare("SELECT student_email, sr_code FROM student_credentials WHERE student_email = ?");
    $stmt->bind_param("s", $_SESSION['student_email']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return "user_not_found";
    }

    $student = $result->fetch_assoc();

    
    if ($form_email !== $_SESSION['student_email']) {
        return "email_mismatch";
    }

    if ($form_sr_code !== $student['sr_code']) {
        error_log("SR Code mismatch - Form: $form_sr_code, DB: " . $student['sr_code']);
        return "sr_code_mismatch";
    }

    $stmt->close();
    return "success";
}
