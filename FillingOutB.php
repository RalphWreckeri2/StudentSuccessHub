<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Interview Form - Student Success Hub</title>
    <link rel="stylesheet" href="styles2.css">
    <link rel="stylesheet" href="styles4.css">
    <script>
        <?php
        session_start();
        $userEmail = $_SESSION['student_email'] ?? '';
        ?>

        // Others checkbox functionality
        document.addEventListener('DOMContentLoaded', function() {
            const othersCheckbox = document.getElementById('others-checkbox');
            const othersInput = document.getElementById('others-input');

            if (othersCheckbox && othersInput) {
                // Initial setup
                othersInput.style.display = othersCheckbox.checked ? 'inline-block' : 'none';

                // Add event listener
                othersCheckbox.addEventListener('change', function() {
                    othersInput.style.display = this.checked ? 'inline-block' : 'none';
                    if (!this.checked) {
                        othersInput.value = '';
                    }
                });

                // Add input event listener
                othersInput.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        othersCheckbox.checked = true;
                    }
                });
            }
        });

        // Modal handler
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const openModal = urlParams.get('openModal');
            if (openModal === 'FillingOutB') {
                loadFormContent('FillingOutB.php');
            }
        });
    </script>
</head>

<body class="filling-out-b">
    <div class="stepper">
        <div class="step">A</div>
        <div class="bridge"></div>
        <div class="step active">B</div>
    </div>

    <form id="interviewForm" method="post" action="FillOutProcessing.php">
        <section class="form-container">
            <h2 style="text-align: center;margin-bottom: 0;">Individual Interview Form</h2>
            <h5 style="text-align: center;margin-top:0;color:#ff3131">Fields with asterisks(*) are required.</h5>
            <h2>Personal Information</h2>
            <div>
                <div class="form-row">
                    <div class="form-field">
                        <label class="input-label">Name *</label>
                        <input type="text" name="student_name" placeholder="Enter Name (Last Name, First Name Middle Initial)">
                    </div>
                    <div class="form-field">
                        <label class="input-label">Student Email *</label>
                        <input type="text" name="student_email" placeholder="Enter Student Email" value="<?php echo htmlspecialchars($_SESSION['student_email']); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label class="input-label">SR-Code *</label>
                        <input type="text" name="student_sr_code" placeholder="Enter SR-Code" value="<?php echo htmlspecialchars($_SESSION['student_sr_code'] ?? ''); ?>" required>
                    </div>
                    <div class="form-field">
                        <label class="input-label">Age *</label>
                        <input type="number" name="student_age" placeholder="Enter Age">
                    </div>
                    <div class="form-field">
                        <label class="input-label">Date *</label>
                        <?php
                        $today = date('Y-m-d');
                        echo "<input type='date' class='input-field' name='date' id='dateInput' value='$today' required>";
                        ?>
                    </div>
                    <div class="form-field">
                        <label class="input-label">Sex *</label>
                        <select name="student_sex">
                            <option value="">Select</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label class="input-label">Program *</label>
                        <input type="text" name="student_program_year" placeholder="Enter Program (Abbreviation Only)">
                    </div>
                    <div class="form-field">
                        <label class="input-label">Phone Number *</label>
                        <input type="text" name="student_mobile_number" placeholder="Enter Phone Number">
                    </div>
                </div>

                <h2>Educational Information</h2>
                <div class="section">
                    <label for="reason">Why are you on your present academic program? *</label>
                    <textarea id="reason" name="student_educational_program_reason" placeholder="Your answer"></textarea>
                    <div class="row">
                        <div class="column">
                            <label>Easiest Subject/Course</label>
                            <input type="text" name="student_easiest_subject" placeholder="Type here">
                        </div>
                        <div class="column">
                            <label>Most Difficult Subject/Course</label>
                            <input type="text" name="most_difficult_subject" placeholder="Type here">
                        </div>
                    </div>
                    <div class="row">
                        <div class="column">
                            <label>Subjects with Lowest Grades/What Grades</label>
                            <input type="text" name="lowest_grades_subject" placeholder="Type here">
                        </div>
                        <div class="column">
                            <label>Subjects with Highest Grades/What Grades</label>
                            <input type="text" name="highest_grades_subject" placeholder="Type here">
                        </div>
                    </div>
                </div>

                <div class="section">
                    <h2>Family Background</h2>
                    <div class="form-row">
                        <div class="column">
                            <label><b>Father</b></label>
                            <label><input type="checkbox" name="father_deceased"> (Check box if deceased)</label>
                            <label><br><br>Name *</label>
                            <input type="text" name="father_name" placeholder="Enter Name">
                            <label>Present Address *</label>
                            <input type="text" name="father_present_address" placeholder="Enter Present Address">
                            <label>Permanent Address *</label>
                            <input type="text" name="father_permanent_address" placeholder="Enter Permanent Address">
                            <label>Home Phone Number</label>
                            <input type="text" name="father_home_phone_number" placeholder="Enter Home Phone No.">
                            <label>Mobile Phone Number *</label>
                            <input type="text" name="father_mobile_phone_number" placeholder="Enter Mobile No.">
                            <label for="email_address">Email Address</label>
                            <input type="text" name="father_email" placeholder="Enter Email Address">
                            <label>Educational Attainment</label>
                            <input type="text" name="father_educational_attainment" placeholder="Enter Educational Attainment">
                            <label for="occupation">Occupation</label>
                            <input type="text" name="father_occupation" placeholder="Enter Occupation">
                            <label for="business_address">Business Address</label>
                            <input type="text" name="father_business_address" placeholder="Enter Business Address">
                            <label for="business_address">Business Telephone No.</label>
                            <input type="text" name="father_business_phone" placeholder="Enter Business Phone">
                            <label for="annual_income">Annual Income (Optional)</label>
                            <input type="text" name="father_annual_income" placeholder="Enter Annual Income">
                            <label for="languages_spoken">Language/s Spoken (Separate by comma)</label>
                            <input type="text" name="father_languages_spoken" placeholder="Enter Language/s Spoken">
                            <label for="religion">Religion</label>
                            <input type="text" name="father_religion" placeholder="Enter Religion">
                        </div>

                        <div class="column">
                            <label><br><b>Mother </b></label>
                            <label><input type="checkbox" name="mother_deceased"> (Check box if deceased) </label>
                            <label><br><br>Name *</label>
                            <input type="text" name="mother_name" placeholder="Enter Name">
                            <label>Present Address *</label>
                            <input type="text" name="mother_present_address" placeholder="Enter Present Address">
                            <label>Permanent Address *</label>
                            <input type="text" name="mother_permanent_address" placeholder="Enter Permanent Address">
                            <label>Home Phone Number</label>
                            <input type="text" name="mother_home_phone_number" placeholder="Enter Home Phone No.">
                            <label>Mobile Phone Number *</label>
                            <input type="text" name="mother_mobile_phone_number" placeholder="Enter Mobile No.">
                            <label for="email_address">Email Address</label>
                            <input type="text" name="mother_email" placeholder="Enter Email Address">
                            <label>Educational Attainment</label>
                            <input type="text" name="mother_educational_attainment" placeholder="Enter Educational Attainment">
                            <label for="occupation">Occupation</label>
                            <input type="text" name="mother_occupation" placeholder="Enter Occupation">
                            <label for="business_address">Business Address</label>
                            <input type="text" name="mother_business_address" placeholder="Enter Business Address">
                            <label for="business_address">Business Telephone No.</label>
                            <input type="text" name="mother_business_phone" placeholder="Enter Business Phone">
                            <label for="annual_income">Annual Income (Optional)</label>
                            <input type="text" name="annual_income" placeholder="Enter Annual Income">
                            <label for="languages_spoken">Languages Spoken (Separate by comma)</label>
                            <input type="text" name="mother_languages_spoken" placeholder="Enter Language/s Spoken">
                            <label for="religion">Religion</label>
                            <input type="text" name="mother_religion" placeholder="Enter Religion">
                        </div>
                    </div>
                </div>

                <h7><br><b>Parent Status:</b> Put a check mark on the appropriate space:<br><br></h7>
                <div class="checkbox-container">
                    <label><input type="checkbox" name="parent_status[]" value="Living Together"> Living Together</label>
                    <label><input type="checkbox" name="parent_status[]" value="Marriage annulled/legally separated"> Marriage annulled/legally separated</label>
                    <label><input type="checkbox" name="parent_status[]" value="Mother, OFW"> Mother, OFW</label>
                    <label><input type="checkbox" name="parent_status[]" value="Father, OFW"> Father, OFW</label>
                    <label><input type="checkbox" name="parent_status[]" value="Temporarily Separated"> Temporarily Separated</label>
                    <label><input type="checkbox" name="parent_status[]" value="Permanently Separated"> Permanently Separated</label>
                </div>

                <div>
                    <div class="form-row">
                        <div class="column">
                            <label class="input-label"><br>Guardian (if not living with Parents):</label>
                            <input type="text" name="guardian_name" placeholder="Type here">
                            <label class="input-label">Address</label>
                            <input type="text" name="guardian_address" placeholder="Type here">
                            <label type="tel" class="input-label">Telephone of Guardian, Landline:</label>
                            <input type="tel" name="guardian_landline" placeholder="Type here">
                            <label type="tel" class="input-label">Mobile Number:</label>
                            <input type="tel" name="guardian_mobile" placeholder="Type here">
                            <label class="input-label">Person to contact in case of Emergency:</label>
                            <input type="text" name="guardian_emergency_contact_name" placeholder="Type here">
                            <label class="input-label">Relationship</label>
                            <input type="text" name="guardian_relationship" placeholder="Type here">
                            <label class="input-label">Contact Number</label>
                            <input type="text" name="guardian_emergency_contact_number" placeholder="Type here">
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Co-curricular Activities</h2>
                        <label for="organizations">Membership in Organizations</label>
                        <textarea id="reason" name="student_curricular_program" placeholder="Enter Membership Organizations (Kindly specify if Inside or Outside the University)"></textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Person/s Who Greatly Influenced Your Life</h2>
                    <div class="form-section">
                        <div class="form-field">
                            <label for="influencer-name">Name *</label>
                            <input type="text" id="influencer-name" name="student_influential_person_name" placeholder="Enter Name">
                        </div>
                        <div class="form-field">
                            <label for="influencer-relationship">Relationship *</label>
                            <input type="text" id="influencer-relationship" name="influence_relationship" placeholder="Relationship">
                        </div>
                        <div class="form-field">
                            <label for="why">Briefly State Why *</label>
                            <textarea id="why" name="student_reason" placeholder="Briefly state why this person influenced you"></textarea>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Other Personal Circumstances/Features</h2>

                        <label for="friends-university">Friends in the University *</label>
                        <input type="text" id="friends-university" name="student_friends_in_university" placeholder="Enter names or details">

                        <label for="friends-outside">Friends outside the University *</label>
                        <input type="text" id="friends-outside" name="student_friends_outside_university" placeholder="Enter names or details">

                        <label for="special-interests">Special Interests *</label>
                        <input type="text" id="special-interests" name="student_special_interests" placeholder="Enter your interests">

                        <label for="special-skills">Special Skills/Talents *</label>
                        <input type="text" id="special-skills" name="student_special_skills" placeholder="Enter your skills/talents">
                    </div>

                    <div class="form-section">
                        <label for="hobbies">Hobbies/Recreational Activities *</label>
                        <input type="text" id="hobbies" name="student_hobbies_recreational_activities" placeholder="Enter your hobbies or recreational activities">

                        <label for="ambitions">Ambitions/Goals *</label>
                        <input type="text" id="ambitions" name="student_ambitions_goals" placeholder="Enter your ambitions or goals">

                        <label for="principle">Guiding Principle in Life/Motto *</label>
                        <input type="text" id="principle" name="student_guiding_principle_motto" placeholder="Enter your guiding principle or motto">

                        <label for="characteristics">Characteristics that describe You best *</label>
                        <input type="text" id="characteristics" name="student_personal_characteristics" placeholder="Enter characteristics that describe you">

                        <label for="event">State the most significant event in your life *</label>
                        <input type="text" id="event" name="student_significant_event_in_life" placeholder="Enter the most significant event in your life">

                        <label for="concerns">Present CONCERNS/PROBLEMS *</label>
                        <input type="text" id="concerns" name="student_present_concerns_problems" placeholder="Enter your present concerns or problems">

                        <label for="fears">Present FEARS *</label>
                        <input type="text" id="fears" name="student_present_fears" placeholder="Enter your present fears">

                        <label for="expectations">EXPECTATIONS in Batangas State University *</label>
                        <input type="text" id="expectations" name="student_future_expectations" placeholder="Enter your expectations in Batangas State University">

                        <label for="future">How do you see yourself ten years from now? *</label>
                        <input type="text" id="future" name="student_future_vision" placeholder="How do you see yourself ten years from now?">

                        <label for="dreams">State your DREAMS & ASPIRATIONS IN LIFE *</label>
                        <input type="text" id="dreams" name="student_dreams_aspirations" placeholder="Enter your dreams and aspirations">

                        <h2>How did you choose your present course? (Please check) *</h2>
                        <div class="checkbox-container">
                            <label><input type="checkbox" name="course_selection[]" value="Family tradition or suggestion"> Family tradition or suggestion</label>
                            <label><input type="checkbox" name="course_selection[]" value="My personal interest"> My personal interest</label>
                            <label><input type="checkbox" name="course_selection[]" value="Friend's or teacher's advice"> Friend's or teacher's advice</label>
                            <label><input type="checkbox" name="course_selection[]" value="Choice was forced upon me"> Choice was forced upon me</label>
                            <label><input type="checkbox" name="course_selection[]" value="Good financial prospects"> Good financial prospects</label>
                            <label><input type="checkbox" name="course_selection[]" value="My parents' decision"> My parents' decision</label>
                            <label><input type="checkbox" name="course_selection[]" value="I have a calling for this work"> I have a calling for this work</label>
                            <label><input type="checkbox" name="course_selection[]" value="It is the vocation of someone I admire or respect"> It is the vocation of someone I admire or respect</label>
                            <label><input type="checkbox" name="course_selection[]" value="Best suited to my interests/abilities"> Best suited to my interests/abilities</label>
                            <label><input type="checkbox" name="course_selection[]" id="others-checkbox" value="Others, please specify:"> Others, please specify:</label>
                            <input type="text" id="others-input" name="others_specify" style="display: none; padding: 5px; margin-left: 5px;" placeholder="Please specify">
                        </div>

                        <h2>Previous Psychological Consultations</h2>

                        <div class="radio-group">
                            <label>Have you consulted a Psychiatrist before?</label>
                            <label><input type="radio" name="student_consulted_psychiatrist" value="1"> Yes</label>
                            <label><input type="radio" name="student_consulted_psychiatrist" value="0"> No</label>
                        </div>

                        <label>If yes, when?</label>
                        <input type="text" name="student_psychiatrist_when" placeholder="Type here">

                        <label>For how many sessions/how long?</label>
                        <input type="text" name="student_psychiatrist_sessions_count" placeholder="Type here">

                        <label>For what reason:</label>
                        <input type="text" name="student_psychiatrist_reason" placeholder="Type here">

                        <div class="radio-group">
                            <label>Have you consulted a Psychologist before?</label>
                            <label><input type="radio" name="student_consulted_psychologist" value="1"> Yes</label>
                            <label><input type="radio" name="student_consulted_psychologist" value="0"> No</label>
                        </div>

                        <label>If yes, when?</label>
                        <input type="text" name="student_psychologist_when" placeholder="Type here">

                        <label>For how many sessions/how long?</label>
                        <input type="text" name="student_psychologist_sessions_count" placeholder="Type here">

                        <label>For what reason:</label>
                        <input type="text" name="student_psychologist_reason" placeholder="Type here">
                    </div>

                    <div class="container">
                        <div class="radio-group">
                            <label>Have you consulted a Counselor before?</label>
                            <label><input type="radio" name="student_consulted_counselor" value="1"> Yes</label>
                            <label><input type="radio" name="student_consulted_counselor" value="0"> No</label>
                        </div>

                        <label>If yes, when?</label>
                        <input type="text" name="student_counselor_when" placeholder="Type here">

                        <label>For how many sessions/how long?</label>
                        <input type="text" name="student_counselor_sessions_count" placeholder="Type here">

                        <label>For what reason:</label>
                        <input type="text" name="student_counselor_reason" placeholder="Type here">

                        <label>Counselor's Name:</label>
                        <input type="text" name="student_counselor_name" placeholder="Type here">

                        <label>Where</label>
                        <input type="text" name="counselor_location" placeholder="Type here">

                        <div class="radio-group">
                            <label>Any test given?</label>
                            <label><input type="radio" name="tests_taken" value="1"> Yes</label>
                            <label><input type="radio" name="tests_taken" value="0"> No</label>
                        </div>

                        <label>If yes, what kind?</label>
                        <input type="text" name="test_details" placeholder="Type here">

                        <div class="radio-group">
                            <label>Are you taking any medications right now?</label>
                            <label><input type="radio" name="medications" value="1"> Yes</label>
                            <label><input type="radio" name="medications" value="0"> No</label>
                        </div>

                        <label>If yes, what kind?</label>
                        <input type="text" name="medication_details" placeholder="Type here">

                        <label>When did you start taking it?</label>
                        <input type="date" name="medication_start_date">

                        <label>Frequency:</label>
                        <input type="text" name="medication_frequency" placeholder="Type here">
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
            </div>
        </section>

        <div class="ps-container">
            <p class="note">
                Make sure to fill out all field that applies to you. If there is a field that does not apply to you, please leave it blank.
                <br>
                You will be able to sign this form once the Office of the Guidance and Counselling contacts you.
            </p>
        </div>
    </form>

    <div class="navigation-buttons">
        <button type="button" onclick="loadFormContent('FillingOutA.php')" class="prev-btn">Previous</button>
        <button type="submit" form="interviewForm" class="save-btn">Save</button>
    </div>

    
</body>

</html>