<?php
session_start();
include 'db_connection.php';

$student_name = isset($_GET['name']) ? $_GET['name'] : '';

$sql = "SELECT * FROM form WHERE student_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_name);
$stmt->execute();
$result = $stmt->get_result();

$status_query = "SELECT status FROM form WHERE student_name = ?";
$status_stmt = $conn->prepare($status_query);
$status_stmt->bind_param("s", $student_name);
$status_stmt->execute();
$status_result = $status_stmt->get_result();
$status_row = $status_result->fetch_assoc();
$current_status = $status_row['status'];

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $student_name = isset($_GET['name']) ? $_GET['name'] : '';
    if (!empty($student_name)) {
        $delete_sql = "DELETE FROM form WHERE student_name = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("s", $student_name);
        if ($delete_stmt->execute()) {
            header("Location: ViewLogs.php?deleted=1");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details - Student Success Hub</title>
    <link rel="stylesheet" href="styles13.css">
</head>

<body>

    <header>
        <div class="logo">
            <img src="image/bsulogo.png" alt="BSU Logo" class="bsu-logo">
            <img src="image/logo.png" alt="Student Success Hub Logo">
            <span>Student Success Hub</span>
        </div>
        <nav class="nav">
            <a href="HomePageForAdmin.php" class="logout-btn">Home</a>
            <a href="LogOut.php" class="logout-btn">Log Out</a>
        </nav>
    </header>

    <div class="container">
        <div class="form-container">
            <h2>Individual Interview Form</h2>

            <?php
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                echo "<h3>Personal Information</h3>";
                echo "<div class='info-section'>";
                echo "<div class='horizontal-layout'>";
                echo "<div class='info-item'><span class='info-label'>Name:</span> <span class='info-value'>" . htmlspecialchars($row['student_name']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Student Email:</span> <span class='info-value'>" . htmlspecialchars($row['student_email']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>SR Code:</span> <span class='info-value'>" . htmlspecialchars($row['student_sr_code']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Age:</span> <span class='info-value'>" . htmlspecialchars($row['student_age']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Date:</span> <span class='info-value'>" . htmlspecialchars($row['date']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Sex:</span> <span class='info-value'>" . htmlspecialchars($row['student_sex']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Program/Year:</span> <span class='info-value'>" . htmlspecialchars($row['student_program_year']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Mobile Number:</span> <span class='info-value'>" . htmlspecialchars($row['student_mobile_number']) . "</span></div>";
                echo "</div>";
                echo "</div>";

                echo "<h3>Educational Information</h3>";
                echo "<div class='info-section'>";
                echo "<div class='info-item'><span class='info-label'>Why are you in your present  academic program?</span> <span class='info-value'>" . htmlspecialchars($row['student_educational_program_reason']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Easiest Subject:</span> <span class='info-value'>" . htmlspecialchars($row['student_easiest_subject']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Most Difficult Subject:</span> <span class='info-value'>" . htmlspecialchars($row['most_difficult_subject']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Subjects with Lowest Grades/What Grades:</span> <span class='info-value'>" . htmlspecialchars($row['lowest_grades_subject']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Subjects with Highest Grades/What Grades:</span> <span class='info-value'>" . htmlspecialchars($row['highest_grades_subject']) . "</span></div>";
                echo "</div>";

                echo "<h3>Family Background</h3>";
                echo "<div class='info-section parents-container'>";

                echo "<div class='parent-column'>";
                echo "<h5>Father's Information</h5>";
                echo "<div class='info-item'><label class='info-label'><input type='checkbox' " . ($row['father_deceased'] == '1' ? 'checked' : '') . " disabled> Father Deceased</label></div>";
                echo "<div class='info-item'><span class='info-label'>Name:</span> <span class='info-value'>" . htmlspecialchars($row['father_name']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Present Address:</span> <span class='info-value'>" . htmlspecialchars($row['father_present_address']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Permanent Address:</span> <span class='info-value'>" . htmlspecialchars($row['father_permanent_address']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Home Phone Number:</span> <span class='info-value'>" . htmlspecialchars($row['father_home_phone_number']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Mobile Phone Number:</span> <span class='info-value'>" . htmlspecialchars($row['father_mobile_phone_number']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Email Address:</span> <span class='info-value'>" . htmlspecialchars($row['father_email']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Educational Attainment:</span> <span class='info-value'>" . htmlspecialchars($row['father_educational_attainment']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Occupation:</span> <span class='info-value'>" . htmlspecialchars($row['father_occupation']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Business Address:</span> <span class='info-value'>" . htmlspecialchars($row['father_business_address']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Business Telephone No:</span> <span class='info-value'>" . htmlspecialchars($row['father_business_phone']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Annual Income:</span> <span class='info-value'>" . htmlspecialchars($row['father_annual_income']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Language/s Spoken:</span> <span class='info-value'>" . htmlspecialchars($row['father_languages_spoken']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Religion:</span> <span class='info-value'>" . htmlspecialchars($row['father_religion']) . "</span></div>";
                echo "</div>";

                echo "<div class='parent-column'>";
                echo "<h5>Mother's Information</h5>";
                echo "<div class='info-item'><label class='info-label'><input type='checkbox' " . ($row['mother_deceased'] == '1' ? 'checked' : '') . " disabled> Mother Deceased</label></div>";
                echo "<div class='info-item'><span class='info-label'>Name:</span> <span class='info-value'>" . htmlspecialchars($row['mother_name']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Present Address:</span> <span class='info-value'>" . htmlspecialchars($row['mother_present_address']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Permanent Address:</span> <span class='info-value'>" . htmlspecialchars($row['mother_permanent_address']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Home Phone Number:</span> <span class='info-value'>" . htmlspecialchars($row['mother_home_phone_number']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Mobile Phone Number:</span> <span class='info-value'>" . htmlspecialchars($row['mother_mobile_phone_number']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Email Address:</span> <span class='info-value'>" . htmlspecialchars($row['mother_email']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Educational Attainment:</span> <span class='info-value'>" . htmlspecialchars($row['mother_educational_attainment']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Occupation:</span> <span class='info-value'>" . htmlspecialchars($row['mother_occupation']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Business Address:</span> <span class='info-value'>" . htmlspecialchars($row['mother_business_address']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Business Telephone No:</span> <span class='info-value'>" . htmlspecialchars($row['mother_business_phone']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Annual Income:</span> <span class='info-value'>" . htmlspecialchars($row['annual_income']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Language/s Spoken:</span> <span class='info-value'>" . htmlspecialchars($row['mother_languages_spoken']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Religion:</span> <span class='info-value'>" . htmlspecialchars($row['mother_religion']) . "</span></div>";
                echo "</div>";

                echo "</div>";

                echo "<h3>Parent Status</h3>";
                echo "<div class='info-section'>";
                echo "<div class='info-item'><span class='info-label'>Current Parental Status:</span> <span class='info-value'>" . htmlspecialchars($row['parent_status']) . "</span></div>";
                echo "</div>";

                echo "<h3>Guardian Information</h3>";
                echo "<div class='info-section'>";
                echo "<div class='info-item'><span class='info-label'>Guardian Name:</span> <span class='info-value'>" . htmlspecialchars($row['guardian_name']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Address:</span> <span class='info-value'>" . htmlspecialchars($row['guardian_address']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Telephone of Guardian,Landline:</span> <span class='info-value'>" . htmlspecialchars($row['guardian_landline']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Mobile Number:</span> <span class='info-value'>" . htmlspecialchars($row['guardian_mobile']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Person to Contact in Case of Emergency:</span> <span class='info-value'>" . htmlspecialchars($row['guardian_emergency_contact_name']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Relationship:</span> <span class='info-value'>" . htmlspecialchars($row['guardian_relationship']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Mobile Number:</span> <span class='info-value'>" . htmlspecialchars($row['guardian_emergency_contact_number']) . "</span></div>";
                echo "</div>";

                echo "<h3>Co-Curricular Activities</h3>";
                echo "<div class='info-section'>";
                echo "<div class='info-item'><span class='info-label'>Curricular Program:</span> <span class='info-value'>" . htmlspecialchars($row['student_curricular_program']) . "</span></div>";
                echo "</div>";

                echo "<h3>Person/s Who Greatly Influenced Your Life</h3>";
                echo "<div class='info-section'>";
                echo "<div class='info-item'><span class='info-label'>Name:</span> <span class='info-value'>" . htmlspecialchars($row['student_influential_person_name']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Relationship:</span> <span class='info-value'>" . htmlspecialchars($row['influence_relationship']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Briefly State Why:</span> <span class='info-value'>" . htmlspecialchars($row['student_reason']) . "</span></div>";
                echo "</div>";

                echo "<h3 class='page-break-section'>Other Personal Circumstances/Features</h3>";
                echo "<div class='info-section'>";
                echo "<div class='info-item'><span class='info-label'>Friends in University:</span> <span class='info-value'>" . htmlspecialchars($row['student_friends_in_university']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Friends Outside University:</span> <span class='info-value'>" . htmlspecialchars($row['student_friends_outside_university']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Special Interests:</span> <span class='info-value'>" . htmlspecialchars($row['student_special_interests']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Special Skills:</span> <span class='info-value'>" . htmlspecialchars($row['student_special_skills']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Hobbies/Recreational Activities:</span> <span class='info-value'>" . htmlspecialchars($row['student_hobbies_recreational_activities']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Ambitions/Goals:</span> <span class='info-value'>" . htmlspecialchars($row['student_ambitions_goals']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Guiding Principle/Motto:</span> <span class='info-value'>" . htmlspecialchars($row['student_guiding_principle_motto']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Characteristics that describe you best:</span> <span class='info-value'>" . htmlspecialchars($row['student_personal_characteristics']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>State the Most Significant Event in Life:</span> <span class='info-value'>" . htmlspecialchars($row['student_significant_event_in_life']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Present Concerns/Problems:</span> <span class='info-value'>" . htmlspecialchars($row['student_present_concerns_problems']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Present Fears:</span> <span class='info-value'>" . htmlspecialchars($row['student_present_fears']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Expectations in Batangas State University:</span> <span class='info-value'>" . htmlspecialchars($row['student_future_expectations']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>How do you see yourself ten years from now?</span> <span class='info-value'>" . htmlspecialchars($row['student_future_vision']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>State your Dreams & Aspirations in Life:</span> <span class='info-value'>" . htmlspecialchars($row['student_dreams_aspirations']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>How did you choose your present course?</span> <span class='info-value'>" . htmlspecialchars($row['course_selection']) . "</span></div>";
                echo "</div>";

                echo "<h3>Previous Psychological Consultations</h3>";
                echo "<div class='info-section consultations-container'>";

                echo "<div class='consultation-column'>";
                echo "<h5>Psychiatrist Consultation</h5>";
                echo "<div class='info-item radio-group'>
                            <span class='info-label'>Consulted Psychiatrist:</span>
                            <div class='radio-options'>
                                <label><input type='radio' name='psychiatrist' value='Yes' " . ($row['student_consulted_psychiatrist'] == '1' ? 'checked' : '') . " disabled> Yes</label>
                                <label><input type='radio' name='psychiatrist' value='No' " . ($row['student_consulted_psychiatrist'] == '0' ? 'checked' : '') . " disabled> No</label>
                            </div>
                        </div>";
                echo "<div class='info-item'><span class='info-label'>Sessions Count:</span> <span class='info-value'>" . htmlspecialchars($row['student_psychiatrist_sessions_count']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Reason:</span> <span class='info-value'>" . htmlspecialchars($row['student_psychiatrist_reason']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>When:</span> <span class='info-value'>" . htmlspecialchars($row['student_psychiatrist_when']) . "</span></div>";
                echo "</div>";

                echo "<div class='consultation-column'>";
                echo "<h5>Psychologist Consultation</h5>";
                echo "<div class='info-item radio-group'>
                            <span class='info-label'>Have you Consulted a Psychologist before?</span>
                            <div class='radio-options'>
                                <label><input type='radio' name='psychologist' value='Yes' " . ($row['student_consulted_psychologist'] == '1' ? 'checked' : '') . " disabled> Yes</label>
                                <label><input type='radio' name='psychologist' value='No' " . ($row['student_consulted_psychologist'] == '0' ? 'checked' : '') . " disabled> No</label>
                            </div>
                        </div>";
                echo "<div class='info-item'><span class='info-label'>For How Many Sessions/ How long?</span> <span class='info-value'>" . htmlspecialchars($row['student_psychologist_sessions_count']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>For What Reason?</span> <span class='info-value'>" . htmlspecialchars($row['student_psychologist_reason']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>If yes, When?</span> <span class='info-value'>" . htmlspecialchars($row['student_psychologist_when']) . "</span></div>";
                echo "</div>";

                echo "</div>";

                echo "<div class='consultation-column'>";
                echo "<h5>Counselor Consultation</h5>";
                echo "<div class='info-item radio-group'>
                        <span class='info-label'>Have you Consulted a Counselor before?</span>
                        <div class='radio-options'>
                            <label><input type='radio' name='counselor' value='Yes' " . ($row['student_consulted_counselor'] == '1' ? 'checked' : '') . " disabled> Yes</label>
                            <label><input type='radio' name='counselor' value='No' " . ($row['student_consulted_counselor'] == '0' ? 'checked' : '') . " disabled> No</label>
                        </div>
                    </div>";
                echo "<div class='info-item'><span class='info-label'>For How Many Sessions/ How long?</span> <span class='info-value'>" . htmlspecialchars($row['student_counselor_sessions_count']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>For What Reason?</span> <span class='info-value'>" . htmlspecialchars($row['student_counselor_reason']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>If yes, When?</span> <span class='info-value'>" . htmlspecialchars($row['student_counselor_when']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Counselor's Name:</span> <span class='info-value'>" . htmlspecialchars($row['student_counselor_name']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Counselor Location:</span> <span class='info-value'>" . htmlspecialchars($row['counselor_location']) . "</span></div>";
                echo "</div>";

                echo "<div class='info-section medical-container'>";

                echo "<div class='medical-column'>";
                echo "<h5>Tests Information</h5>";
                echo "<div class='info-item radio-group'>
                            <span class='info-label'>Any Test Given?</span>
                            <div class='radio-options'>
                                <label><input type='radio' name='tests_taken' value='Yes' " . ($row['tests_taken'] == '1' ? 'checked' : '') . " disabled> Yes</label>
                                <label><input type='radio' name='tests_taken' value='No' " . ($row['tests_taken'] == '0' ? 'checked' : '') . " disabled> No</label>
                            </div>
                        </div>";
                echo "<div class='info-item'><span class='info-label'>Test Details:</span> <span class='info-value'>" . htmlspecialchars($row['test_details']) . "</span></div>";
                echo "</div>";

                echo "<div class='medical-column'>";
                echo "<h5>Medications Information</h5>";
                echo "<div class='info-item radio-group'>
                            <span class='info-label'>Are you taking any medications right now?</span>
                            <div class='radio-options'>
                                <label><input type='radio' name='medications' value='Yes' " . ($row['medications'] == '1' ? 'checked' : '') . " disabled> Yes</label>
                                <label><input type='radio' name='medications' value='No' " . ($row['medications'] == '0' ? 'checked' : '') . " disabled> No</label>
                            </div>
                        </div>";
                echo "<div class='info-item'><span class='info-label'>Medication Details:</span> <span class='info-value'>" . htmlspecialchars($row['medication_details']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Medication Start Date:</span> <span class='info-value'>" . htmlspecialchars($row['medication_start_date']) . "</span></div>";
                echo "<div class='info-item'><span class='info-label'>Medication Frequency:</span> <span class='info-value'>" . htmlspecialchars($row['medication_frequency']) . "</span></div>";
                echo "</div>";

                echo "</div>";
            } else {
                echo "<p>No records found for the selected student.</p>";
            }

            $stmt->close();
            $conn->close();
            ?>

        </div>
        <div class="privacy-text">
            <p>
                Pursuant to Republic Act No. 10173, also known as the Data Privacy Act of 2012, the Batangas State University, the National Engineering University, recognizes its commitment to protect and respect the privacy of its customers and/or stakeholders and ensure that all information collected from them are all processed in accordance with the principles of transparency, legitimate purpose and proportionality mandated under the Data Privacy Act of 2012.
            </p>
            <p>
                I certify that all the facts and information stated in this form are true and correct.
            </p>
        </div>
        <div class="signature-section">
            <p><br><br>Signature over Printed Name of Student</p>
            <p>Date:</p>
            <p>Please Check: [ ]Freshman [ ]Transferee [ ]Old Student [ ]Foreign Student</p>
        </div>
    </div>

    <div class="action-container">
        <div class="action-buttons">
            <a href="<?php echo $current_status === 'archived' ? 'Archive.php' : ($current_status === 'done' ? 'MarkedAsDone.php' : 'ViewLogs.php'); ?>" class="print-btn proceed-btn">GO BACK</a>
            <a href="?name=<?php echo urlencode($student_name); ?>&action=delete" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this student record? This action cannot be undone.');">DELETE</a>
            <a href="javascript:void(0);" class="action-btn print-btn" onclick="printPage()">PRINT</a>
            <?php if ($current_status === 'pending'): ?>
                <a href="MarkedAsDone.php?name=<?php echo urlencode($student_name); ?>&action=mark_done" class="action-btn mark-btn">MARK AS DONE</a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function confirmDelete(studentName) {
            if (confirm('Are you sure you want to delete this student record? This action cannot be undone.')) {
                window.location.href = 'delete-form.php?name=' + encodeURIComponent(studentName);
            }
        }

        function printPage() {
            window.print();
        }
    </script>
</body>

</html>