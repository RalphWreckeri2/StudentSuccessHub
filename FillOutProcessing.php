<?php

include 'db_connection.php';
include 'VerifyStudent.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['student_email'])) {
    echo "Missing required parameters or not logged in";
    exit;
}

$formData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $allFieldsEmpty = true;
    $visibleFields = [
        'student_name',
        'student_email',
        'student_sr_code',
        'student_age',
        'student_sex',
        'student_program_year',
        'student_mobile_number',
        'student_educational_program_reason',
        'father_name',
        'father_present_address',
        'father_permanent_address',
        'father_mobile_phone_number',
        'mother_name',
        'mother_present_address',
        'mother_permanent_address',
        'mother_mobile_phone_number',
        'student_influential_person_name',
        'student_reason',
        'influence_relationship',
        'student_friends_in_university',
        'student_friends_outside_university',
        'student_special_interests',
        'student_special_skills',
        'student_hobbies_recreational_activities',
        'student_ambitions_goals',
        'student_guiding_principle_motto',
        'student_personal_characteristics',
        'student_significant_event_in_life',
        'student_present_concerns_problems',
        'student_present_fears',
        'student_future_expectations',
        'student_future_vision',
        'student_dreams_aspirations',
        'course_selection'
    ];

    foreach ($visibleFields as $field) {
        if (!empty($_POST[$field])) {
            $allFieldsEmpty = false;
            break;
        }
    }

    if ($allFieldsEmpty) {
        echo "<script>
            alert('You cannot submit an empty form');
            window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
        </script>";
        exit;
    }

    $form_email = $_POST['student_email'] ?? '';
    $form_sr_code = $_POST['student_sr_code'] ?? '';


    if (empty($form_email) && empty($form_sr_code)) {
        echo "<script>
            alert('Student email and SR code are required!');
            window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
        </script>";
        exit;
    } elseif (empty($form_email)) {
        echo "<script>
            alert('Student email is required!');
            window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
        </script>";
        exit;
    } elseif (empty($form_sr_code)) {
        echo "<script>
            alert('SR code is required!');
            window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
        </script>";
        exit;
    }


    $verificationResult = verifyStudentCredentials($conn, $form_email, $form_sr_code);

    switch ($verificationResult) {
        case "not_logged_in":
            echo "<script>
                alert('User not logged in');
                window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
            </script>";
            exit;
        case "user_not_found":
            echo "<script>
                alert('User not found');
                window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
            </script>";
            exit;
        case "email_mismatch":
            echo "<script>
                alert('The email you entered does not match your logged-in account');
                window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
            </script>";
            exit;
        case "sr_code_mismatch":
            echo "<script>
                alert('The SR code you entered does not match our records');
                window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
            </script>";
            exit;
        case "success":
            break;
        default:
            echo "<script>alert('An unexpected error occurred'); window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
            </script>";
            exit;
    }


    $formData['student_name'] = $_POST['student_name'] ?? '';
    $formData['student_email'] = $_POST['student_email'] ?? '';
    $formData['student_sr_code'] = $_POST['student_sr_code'] ?? '';
    $formData['student_age'] = $_POST['student_age'] ?? '';
    $formData['date'] = $_POST['date'] ?? null;
    $formData['student_sex'] = $_POST['student_sex'] ?? '';
    $formData['student_program_year'] = $_POST['student_program_year'] ?? '';
    $formData['student_mobile_number'] = $_POST['student_mobile_number'] ?? '';

    $formData['student_educational_program_reason'] = $_POST['student_educational_program_reason'] ?? '';

    $formData['student_easiest_subject'] = $_POST['student_easiest_subject'] ?? null;
    $formData['most_difficult_subject'] = $_POST['most_difficult_subject'] ?? null;
    $formData['lowest_grades_subject'] = $_POST['lowest_grades_subject'] ?? null;
    $formData['highest_grades_subject'] = $_POST['highest_grades_subject'] ?? null;

    $formData['father_deceased'] = isset($_POST['father_deceased']) ? 1 : null;
    $formData['father_name'] = $_POST['father_name'] ?? '';
    $formData['father_present_address'] = $_POST['father_present_address'] ?? '';
    $formData['father_permanent_address'] = $_POST['father_permanent_address'] ?? '';
    $formData['father_home_phone_number'] = $_POST['father_home_phone_number'] ?? null;
    $formData['father_mobile_phone_number'] = $_POST['father_mobile_phone_number'] ?? '';
    $formData['father_email'] = $_POST['father_email'] ?? null;
    $formData['father_educational_attainment'] = $_POST['father_educational_attainment'] ?? null;
    $formData['father_occupation'] = $_POST['father_occupation'] ?? null;
    $formData['father_business_address'] = $_POST['father_business_address'] ?? null;
    $formData['father_business_phone'] = $_POST['father_business_phone'] ?? null;
    $formData['father_annual_income'] = $_POST['father_annual_income'] ?? null;
    $formData['father_languages_spoken'] = $_POST['father_languages_spoken'] ?? null;
    $formData['father_religion'] = $_POST['father_religion'] ?? null;

    $formData['mother_deceased'] = isset($_POST['mother_deceased']) ? 1 : null;
    $formData['mother_name'] = $_POST['mother_name'] ?? '';
    $formData['mother_present_address'] = $_POST['mother_present_address'] ?? '';
    $formData['mother_permanent_address'] = $_POST['mother_permanent_address'] ?? '';
    $formData['mother_home_phone_number'] = $_POST['mother_home_phone_number'] ?? null;
    $formData['mother_mobile_phone_number'] = $_POST['mother_mobile_phone_number'] ?? '';
    $formData['mother_email'] = $_POST['mother_email'] ?? null;
    $formData['mother_educational_attainment'] = $_POST['mother_educational_attainment'] ?? null;
    $formData['mother_occupation'] = $_POST['mother_occupation'] ?? null;
    $formData['mother_business_address'] = $_POST['mother_business_address'] ?? null;
    $formData['mother_business_phone'] = $_POST['mother_business_phone'] ?? null;
    $formData['annual_income'] = $_POST['annual_income'] ?? null;
    $formData['mother_languages_spoken'] = $_POST['mother_languages_spoken'] ?? null;
    $formData['mother_religion'] = $_POST['mother_religion'] ?? null;

    $formData['parent_status'] = $_POST['parent_status'] ?? null;

    $formData['guardian_name'] = $_POST['guardian_name'] ?? null;
    $formData['guardian_relationship'] = $_POST['guardian_relationship'] ?? null;
    $formData['guardian_address'] = $_POST['guardian_address'] ?? null;
    $formData['guardian_landline'] = $_POST['guardian_landline'] ?? null;
    $formData['guardian_mobile'] = $_POST['guardian_mobile'] ?? null;
    $formData['guardian_emergency_contact_name'] = $_POST['guardian_emergency_contact_name'] ?? null;
    $formData['guardian_emergency_contact_number'] = $_POST['guardian_emergency_contact_number'] ?? null;

    $formData['student_curricular_program'] = $_POST['student_curricular_program'] ?? null;

    $formData['student_influential_person_name'] = $_POST['student_influential_person_name'] ?? '';
    $formData['student_reason'] = $_POST['student_reason'] ?? '';
    $formData['influence_relationship'] = $_POST['influence_relationship'] ?? '';

    $formData['student_friends_in_university'] = $_POST['student_friends_in_university'] ?? '';
    $formData['student_friends_outside_university'] = $_POST['student_friends_outside_university'] ?? '';
    $formData['student_special_interests'] = $_POST['student_special_interests'] ?? '';
    $formData['student_special_skills'] = $_POST['student_special_skills'] ?? '';
    $formData['student_hobbies_recreational_activities'] = $_POST['student_hobbies_recreational_activities'] ?? '';
    $formData['student_ambitions_goals'] = $_POST['student_ambitions_goals'] ?? '';
    $formData['student_guiding_principle_motto'] = $_POST['student_guiding_principle_motto'] ?? '';
    $formData['student_personal_characteristics'] = $_POST['student_personal_characteristics'] ?? '';
    $formData['student_significant_event_in_life'] = $_POST['student_significant_event_in_life'] ?? '';
    $formData['student_present_concerns_problems'] = $_POST['student_present_concerns_problems'] ?? '';
    $formData['student_present_fears'] = $_POST['student_present_fears'] ?? '';
    $formData['student_future_expectations'] = $_POST['student_future_expectations'] ?? '';
    $formData['student_future_vision'] = $_POST['student_future_vision'] ?? '';
    $formData['student_dreams_aspirations'] = $_POST['student_dreams_aspirations'] ?? '';

    $formData['course_selection'] = $_POST['course_selection'] ?? '';

    $formData['student_consulted_psychiatrist'] = $_POST['student_consulted_psychiatrist'] ?? null;
    $formData['student_psychiatrist_sessions_count'] = $_POST['student_psychiatrist_sessions_count'] ?? null;
    $formData['student_psychiatrist_reason'] = $_POST['student_psychiatrist_reason'] ?? null;
    $formData['student_psychiatrist_when'] = $_POST['student_psychiatrist_when'] ?? null;

    $formData['student_consulted_psychologist'] = $_POST['student_consulted_psychologist'] ?? null;
    $formData['student_psychologist_sessions_count'] = $_POST['student_psychologist_sessions_count'] ?? null;
    $formData['student_psychologist_reason'] = $_POST['student_psychologist_reason'] ?? null;
    $formData['student_psychologist_when'] = $_POST['student_psychologist_when'] ?? null;

    $formData['student_consulted_counselor'] = $_POST['student_consulted_counselor'] ?? null;
    $formData['student_counselor_sessions_count'] = $_POST['student_counselor_sessions_count'] ?? null;
    $formData['student_counselor_reason'] = $_POST['student_counselor_reason'] ?? null;
    $formData['student_counselor_when'] = $_POST['student_counselor_when'] ?? null;
    $formData['student_counselor_name'] = $_POST['student_counselor_name'] ?? null;
    $formData['counselor_location'] = $_POST['counselor_location'] ?? null;

    $formData['tests_taken'] = $_POST['tests_taken'] ?? null;
    $formData['test_details'] = $_POST['test_details'] ?? null;
    $formData['medications'] = $_POST['medications'] ?? null;
    $formData['medication_details'] = $_POST['medication_details'] ?? null;
    $formData['medication_start_date'] = $_POST['medication_start_date'] ?? null;
    $formData['medication_frequency'] = $_POST['medication_frequency'] ?? null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    }

    $form_email = $formData['student_email'] ?? '';
    $form_sr_code = $formData['student_sr_code'] ?? '';

    $verificationResult = verifyStudentCredentials($conn, $form_email, $form_sr_code);

    switch ($verificationResult) {
        case "not_logged_in":
            echo "<script>alert('User not logged in'); window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
            </script>";
            exit;
        case "user_not_found":
            echo "<script>alert('User not found'); window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
            </script>";
            exit;
        case "email_mismatch":
            echo "<script>alert('The email you entered does not match your logged-in account'); window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
            </script>";
            exit;
        case "sr_code_mismatch":
            echo "<script>alert('The SR code you entered does not match our records'); window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
            </script>";
            exit;
        case "success":
            break;
        default:
            echo "<script>alert('An unexpected error occurred'); window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
            </script>";
            exit;
    }
    $hasErrors = false;

    $requiredFields = [
        'student_name' => 'Student name',
        'student_email' => 'Student email',
        'student_sr_code' => 'SR code',
        'student_age' => 'Student age',
        'student_sex' => 'Student sex',
        'student_program_year' => 'Student program',
        'student_mobile_number' => 'Student mobile number',
        'student_educational_program_reason' => 'Educational program reason',
        'father_name' => 'Father name',
        'father_present_address' => 'Father present address',
        'father_permanent_address' => 'Father permanent address',
        'father_mobile_phone_number' => 'Father mobile phone number',
        'mother_name' => 'Mother name',
        'mother_present_address' => 'Mother present address',
        'mother_permanent_address' => 'Mother permanent address',
        'mother_mobile_phone_number' => 'Mother mobile phone number',
        'student_influential_person_name' => 'Influential person name',
        'student_reason' => 'Reason',
        'influence_relationship' => 'Influence relationship',
        'student_friends_in_university' => 'Student friends in university',
        'student_friends_outside_university' => 'Student friends outside university',
        'student_special_interests' => 'Student special interests',
        'student_special_skills' => 'Student special skills',
        'student_hobbies_recreational_activities' => 'Student hobbies recreational activities',
        'student_ambitions_goals' => 'Student ambitions goals',
        'student_guiding_principle_motto' => 'Student guiding principle motto',
        'student_personal_characteristics' => 'Student personal characteristics',
        'student_significant_event_in_life' => 'Student significant event in life',
        'student_present_concerns_problems' => 'Student present concerns or problems',
        'student_present_fears' => 'Student present fears',
        'student_future_expectations' => 'Student future expectations',
        'student_future_vision' => 'Student future vision',
        'student_dreams_aspirations' => 'Student dreams and aspirations',
        'course_selection' => 'Course selection',
    ];

    foreach ($requiredFields as $field => $label) {
        if (empty($formData[$field])) {
            $hasErrors = true;
            echo "<script>
                alert('{$label} is required!');
                window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
            </script>";
            exit;
        }
    }

    if (!$hasErrors) {
        $columns = "
                    student_name,
                    student_email,
                    student_sr_code,
                    student_age,
                    date,
                    student_sex,
                    student_program_year,
                    student_mobile_number,
                    student_educational_program_reason,
                    student_easiest_subject,
                    most_difficult_subject,
                    lowest_grades_subject,  
                    highest_grades_subject,
                    father_deceased,
                    father_name,
                    father_present_address,
                    father_permanent_address,
                    father_home_phone_number,
                    father_mobile_phone_number, 
                    father_email,
                    father_educational_attainment,
                    father_occupation,
                    father_business_address,
                    father_business_phone,
                    father_annual_income,
                    father_languages_spoken,
                    father_religion,
                    mother_deceased,
                    mother_name,
                    mother_present_address,
                    mother_permanent_address,
                    mother_home_phone_number,
                    mother_mobile_phone_number,
                    mother_email,
                    mother_educational_attainment,
                    mother_occupation,
                    mother_business_address,
                    mother_business_phone,
                    annual_income,
                    mother_languages_spoken,
                    mother_religion,
                    parent_status,
                    guardian_name,
                    guardian_relationship,
                    guardian_address,
                    guardian_landline,
                    guardian_mobile,
                    guardian_emergency_contact_name,
                    guardian_emergency_contact_number,
                    student_curricular_program,
                    student_influential_person_name,
                    student_reason,
                    influence_relationship,
                    student_friends_in_university,
                    student_friends_outside_university,
                    student_special_interests,
                    student_special_skills,
                    student_hobbies_recreational_activities,
                    student_ambitions_goals,
                    student_guiding_principle_motto,
                    student_personal_characteristics,
                    student_significant_event_in_life,      
                    student_present_concerns_problems,
                    student_present_fears,
                    student_future_expectations,
                    student_future_vision,  
                    student_dreams_aspirations,
                    course_selection,
                    student_consulted_psychiatrist,
                    student_psychiatrist_sessions_count,
                    student_psychiatrist_reason,
                    student_psychiatrist_when,
                    student_consulted_psychologist,
                    student_psychologist_sessions_count,
                    student_psychologist_reason,
                    student_psychologist_when,
                    student_consulted_counselor,
                    student_counselor_sessions_count,
                    student_counselor_reason,
                    student_counselor_when,
                    student_counselor_name,
                    counselor_location,
                    tests_taken,    
                    test_details,
                    medications,
                    medication_details,
                    medication_start_date,
                    medication_frequency";



        unset($formData['role']);

        $columnCount = substr_count($columns, ',') + 1;
        $placeholders = str_repeat('?,', $columnCount - 1) . '?';

        $sql = "INSERT INTO form ($columns) VALUES ($placeholders)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        if (isset($_POST['parent_status']) && is_array($_POST['parent_status'])) {
            $formData['parent_status'] = implode(', ', $_POST['parent_status']);
        } else {
            $formData['parent_status'] = null;
        }

        if (isset($_POST['course_selection']) && is_array($_POST['course_selection'])) {
            $course_selection = $_POST['course_selection'];

            if (in_array('Others, please specify:', $course_selection) && !empty($_POST['others_specify'])) {
                $course_selection[] = $_POST['others_specify'];
            }

            $formData['course_selection'] = implode(', ', $course_selection);
        } else {
            $formData['course_selection'] = null;
        }

        $stmt->bind_param(
            "sssisssssssssissssssssssdssissssssssssdssssssssssssssssssssssssssssssisssisssissssssssss",
            $formData['student_name'],
            $formData['student_email'],
            $formData['student_sr_code'],
            $formData['student_age'],
            $formData['date'],
            $formData['student_sex'],
            $formData['student_program_year'],
            $formData['student_mobile_number'],
            $formData['student_educational_program_reason'],
            $formData['student_easiest_subject'],
            $formData['most_difficult_subject'],
            $formData['lowest_grades_subject'],
            $formData['highest_grades_subject'],
            $formData['father_deceased'],
            $formData['father_name'],
            $formData['father_present_address'],
            $formData['father_permanent_address'],
            $formData['father_home_phone_number'],
            $formData['father_mobile_phone_number'],
            $formData['father_email'],
            $formData['father_educational_attainment'],
            $formData['father_occupation'],
            $formData['father_business_address'],
            $formData['father_business_phone'],
            $formData['father_annual_income'],
            $formData['father_languages_spoken'],
            $formData['father_religion'],
            $formData['mother_deceased'],
            $formData['mother_name'],
            $formData['mother_present_address'],
            $formData['mother_permanent_address'],
            $formData['mother_home_phone_number'],
            $formData['mother_mobile_phone_number'],
            $formData['mother_email'],
            $formData['mother_educational_attainment'],
            $formData['mother_occupation'],
            $formData['mother_business_address'],
            $formData['mother_business_phone'],
            $formData['annual_income'],
            $formData['mother_languages_spoken'],
            $formData['mother_religion'],
            $formData['parent_status'],
            $formData['guardian_name'],
            $formData['guardian_relationship'],
            $formData['guardian_address'],
            $formData['guardian_landline'],
            $formData['guardian_mobile'],
            $formData['guardian_emergency_contact_name'],
            $formData['guardian_emergency_contact_number'],
            $formData['student_curricular_program'],
            $formData['student_influential_person_name'],
            $formData['student_reason'],
            $formData['influence_relationship'],
            $formData['student_friends_in_university'],
            $formData['student_friends_outside_university'],
            $formData['student_special_interests'],
            $formData['student_special_skills'],
            $formData['student_hobbies_recreational_activities'],
            $formData['student_ambitions_goals'],
            $formData['student_guiding_principle_motto'],
            $formData['student_personal_characteristics'],
            $formData['student_significant_event_in_life'],
            $formData['student_present_concerns_problems'],
            $formData['student_present_fears'],
            $formData['student_future_expectations'],
            $formData['student_future_vision'],
            $formData['student_dreams_aspirations'],
            $formData['course_selection'],
            $formData['student_consulted_psychiatrist'],
            $formData['student_psychiatrist_sessions_count'],
            $formData['student_psychiatrist_reason'],
            $formData['student_psychiatrist_when'],
            $formData['student_consulted_psychologist'],
            $formData['student_psychologist_sessions_count'],
            $formData['student_psychologist_reason'],
            $formData['student_psychologist_when'],
            $formData['student_consulted_counselor'],
            $formData['student_counselor_sessions_count'],
            $formData['student_counselor_reason'],
            $formData['student_counselor_when'],
            $formData['student_counselor_name'],
            $formData['counselor_location'],
            $formData['tests_taken'],
            $formData['test_details'],
            $formData['medications'],
            $formData['medication_details'],
            $formData['medication_start_date'],
            $formData['medication_frequency']
        );

        try {
            if ($stmt->execute()) {
                echo "<script>
                    alert('Form submitted successfully! The Office of Guidance and Counseling will contact you.');
                    window.location.href = 'HomePageForStudents.php';
                </script>";
            } else {
                echo "<script>
                    alert('Database error occurred.');
                    window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
                </script>";
            }
        } catch (Exception $e) {

            error_log($e->getMessage());
            echo "<script>
                alert('An error occurred. Please try again.');
                window.location.href = 'HomePageForStudents.php?openModal=true&form=B';
            </script>";
        }


        $stmt->close();
    }
}

$conn->close();
