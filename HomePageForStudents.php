<?php
session_start();
include 'db_connection.php';

// Make sure we have a valid connection and student is logged in
if (!isset($_SESSION['student_email'])) {
    header("Location: login.php");
    exit;
}

// Store the form check result in a variable we can use multiple times
$has_submitted_form = false;
if ($conn) {
    $check_form = "SELECT COUNT(*) as count FROM form WHERE student_email = ?";
    if ($stmt = $conn->prepare($check_form)) {
        $stmt->bind_param("s", $_SESSION['student_email']);
        $stmt->execute();
        $result = $stmt->get_result();
        $form_count = $result->fetch_assoc()['count'];
        $has_submitted_form = ($form_count > 0);
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page -Student Success Hub</title>
    <link rel="stylesheet" href="styles2.css">
</head>

<body class="homepage">
    <header>
        <div class="logo">
            <img src="image/bsulogo.png" alt="BSU Logo" class="bsu-logo">
            <img src="image/logo.png" alt="Student Success Hub Logo">
            <span>Student Success Hub</span>
        </div>
        <nav class="nav">
            <a href="LogOut.php" class="logout-btn">Log Out</a>
        </nav>
    </header>

    <main>
        <div class="hero-card">
            <div class="profile-section">
                <div class="profile-content">
                    <div class="profile-icon">
                        <img src="image/profile.png" alt="Profile Icon">
                    </div>
                    <div class="profile-info">
                        <h1>Welcome Red Spartan!</h1>
                        <?php
                        if (isset($_SESSION['student_email'])) {
                            $email = $_SESSION['student_email'];

                            if ($conn) {
                                $stmt = $conn->prepare("SELECT sr_code FROM student_credentials WHERE student_email = ?");
                                $stmt->bind_param("s", $email);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    $student = $result->fetch_assoc();
                                    echo "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
                                    echo "<p><strong>SR-Code:</strong> " . htmlspecialchars($student['sr_code']) . "</p>";
                                } else {
                                    echo "<p>No account details found.</p>";
                                }
                                $stmt->close();
                            }
                        } else {
                            echo "<p>Please log in to view your account details.</p>";
                        }
                        ?>
                        <?php if ($has_submitted_form): ?>
                            <button onclick="openViewModal()" class="view-form-btn">View My Form</button>
                        <?php else: ?>
                            <button onclick="openModal()" class="fill-form-btn">Fill Out Form</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>This is Student Success Hub</h2>
            <p>A dedicated website to cater to students' support needs with the Office of Guidance and Counselling. Our service focuses exclusively on facilitating individual interview forms, streamlining the process to ensure every student receives timely and personalized support. By simplifying access to interview forms, we aim to create a seamless experience for students while fostering a supportive environment for their academic and emotional well-being.</p>

            <h2>Frequently Asked Questions</h2>
            <div class="faq-container">
                <!-- FAQ Item 1 -->
                <div class="faq-item">
                    <div class="faq-number">01</div>
                    <div class="faq-content">
                        <h2>What can I expect during my first counseling session?</h2>
                        <p>Initial counseling sessions begin with an assessment to understand the student's needs and goals.</p>
                    </div>
                    <div class="toggle-icon">▼</div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="faq-item">
                    <div class="faq-number">02</div>
                    <div class="faq-content">
                        <h2>What services are available in the Office of Guidance and Counselling?</h2>
                        <p>The office provides support with academic, personal, and emotional challenges.</p>
                    </div>
                    <div class="toggle-icon">▼</div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="faq-item">
                    <div class="faq-number">03</div>
                    <div class="faq-content">
                        <h2>Does the counseling center provide medication management?</h2>
                        <p>The center offers guidance but does not provide medication management.</p>
                    </div>
                    <div class="toggle-icon">▼</div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="faq-item">
                    <div class="faq-number">04</div>
                    <div class="faq-content">
                        <h2>What if I'm not comfortable talking to a counselor?</h2>
                        <p>We encourage students to try counseling, but they are not obligated to continue if uncomfortable.</p>
                    </div>
                    <div class="toggle-icon">▼</div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="faq-item">
                    <div class="faq-number">05</div>
                    <div class="faq-content">
                        <h2>Can a student see a counselor even if they're not struggling mentally?</h2>
                        <p>Yes, counseling is available for academic support and general well-being.</p>
                    </div>
                    <div class="toggle-icon">▼</div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="faq-item">
                    <div class="faq-number">06</div>
                    <div class="faq-content">
                        <h2>Are there any fees/charges for counseling sessions?</h2>
                        <p>No, all counseling sessions are free for students.</p>
                    </div>
                    <div class="toggle-icon">▼</div>
                </div>

                <!-- FAQ Item 7 -->
                <div class="faq-item">
                    <div class="faq-number">07</div>
                    <div class="faq-content">
                        <h2>Are counseling sessions confidential?</h2>
                        <p>Yes, all sessions are confidential unless the student poses a threat to themselves or others.</p>
                    </div>
                    <div class="toggle-icon">▼</div>
                </div>
            </div>
        </div>

        <div class="about-section">
            <h2>About Us</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>The Office of Guidance and Counseling (OGC) at Batangas State University is dedicated to supporting students throughout their academic journey. Our mission is to provide comprehensive guidance services that promote personal growth, academic success, and emotional well-being.</p>
                    <p>Our team of professional counselors works tirelessly to create a safe, welcoming environment where students can freely discuss their concerns and receive the support they need to thrive in their university life.</p>
                </div>
                <div class="about-services">
                    <h3>Our Services Include:</h3>
                    <ul>
                        <li>Individual Counseling</li>
                        <li>Academic Support</li>
                        <li>Career Guidance</li>
                        <li>Personal Development Programs</li>
                        <li>Crisis Intervention</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="developers-section">
            <h2>Meet Our Developers</h2>
            <div class="developers-content">
                <div class="developer-card">
                    <div class="developer-image">
                        <img src="image/samonte.png" alt="Developer 1">
                    </div>
                    <div class="developer-info">
                        <h3>Ralph Matthew A. Samonte</h3>
                        <p class="developer-role">Full Stack Developer</p>
                        <p class="developer-description">BSIT Student at Batangas State University</p>
                    </div>
                </div>

                <div class="developer-card">
                    <div class="developer-image">
                        <img src="image/protestante.png" alt="Developer 2">
                    </div>
                    <div class="developer-info">
                        <h3>Louisa Victoria C. Protestante</h3>
                        <p class="developer-role">Frontend Developer</p>
                        <p class="developer-description">BSIT Student at Batangas State University</p>
                    </div>
                </div>

                <div class="developer-card">
                    <div class="developer-image">
                        <img src="image/espaldon.png" alt="Developer 3">
                    </div>
                    <div class="developer-info">
                        <h3>Steven Lenard L. Espaldon</h3>
                        <p class="developer-role">Backend Developer</p>
                        <p class="developer-description">BSIT Student at Batangas State University</p>
                    </div>
                </div>

                <div class="developer-card">
                    <div class="developer-image">
                        <img src="image/barola.png" alt="Developer 4">
                    </div>
                    <div class="developer-info">
                        <h3>Prin M. Barola</h3>
                        <p class="developer-role">UI/UX Designer</p>
                        <p class="developer-description">BSIT Student at Batangas State University</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update the modal structure -->
        <div id="formModal" class="modal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <div id="modalContent"></div>
            </div>
        </div>

        <!-- Add new view form modal -->
        <div id="viewFormModal" class="modal">
            <div class="modal-content">
                <span class="close-modal" onclick="closeViewModal()">&times;</span>
                <div id="viewModalContent"></div>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Student Success Hub. All rights reserved.</p>
        <a href="https://www.facebook.com/guidanceandcounselinglipa">Office of Guidance and Counseling - Batstateu Lipa (Ogc Lipa) Facebook Page<br></a>
        <p>Email: ogc.lipa@g.batstate-u.edu.ph</p>
    </footer>

    <script>
        console.log('Script loaded');

        const modal = document.getElementById('formModal');
        const modalContent = document.getElementById('modalContent');
        const closeBtn = document.querySelector('.close-modal');

        console.log('Modal:', modal);
        console.log('Modal content:', modalContent);
        console.log('Close button:', closeBtn);

        function openModal() {
            console.log('Opening modal');
            modal.style.display = "block";

            // Load initial form content
            fetch('FillingOutA.php')
                .then(response => {
                    console.log('Response received:', response);
                    return response.text();
                })
                .then(content => {
                    console.log('Content received:', content);
                    if (content.includes('error_already_submitted')) {
                        alert("You have already submitted a form. You can only submit once.");
                        modal.style.display = "none";
                        return;
                    }
                    modalContent.innerHTML = content;
                })
                .catch(error => {
                    console.error('Error:', error);
                    modalContent.innerHTML = 'Error loading form';
                });
        }

        // Close modal when clicking X
        closeBtn.onclick = function() {
            console.log('Closing modal');
            modal.style.display = "none";
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('formModal');
            const viewModal = document.getElementById('viewFormModal');

            if (event.target == modal) {
                modal.style.display = "none";
            }
            if (event.target == viewModal) {
                viewModal.style.display = "none";
            }
        }

        // Modify the existing loadFormContent function
        function loadFormContent(page) {
            const modal = document.getElementById('formModal');
            const modalContent = document.getElementById('modalContent');

            if (modal && modalContent) {
                modal.style.display = 'block';

                fetch(page)
                    .then(response => response.text())
                    .then(content => {
                        modalContent.innerHTML = content;

                        // Keep existing form setup code
                        if (page === 'FillingOutB.php') {
                            setupFormSubmission();

                            // Restore form data if exists
                            const storedData = sessionStorage.getItem('formBData');
                            if (storedData) {
                                const formData = JSON.parse(storedData);
                                const form = document.querySelector('#modalContent form');
                                if (form) {
                                    // Restore text inputs, selects, and textareas
                                    form.querySelectorAll('input:not([type="checkbox"]):not([type="radio"]), select, textarea').forEach(element => {
                                        if (formData[element.name]) {
                                            element.value = formData[element.name];
                                        }
                                        if (element.id === 'others-input' && formData['others_specify']) {
                                            element.value = formData['others_specify'];
                                            element.style.display = 'inline-block';
                                        }
                                    });

                                    // Restore checkboxes
                                    form.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                                        const groupName = checkbox.name.replace('[]', '');
                                        if (formData[groupName] && Array.isArray(formData[groupName])) {
                                            checkbox.checked = formData[groupName].includes(checkbox.value);
                                            if (checkbox.id === 'others-checkbox' && checkbox.checked) {
                                                const othersInput = document.getElementById('others-input');
                                                if (othersInput && formData['others_specify']) {
                                                    othersInput.style.display = 'inline-block';
                                                }
                                            }
                                        }
                                    });

                                    // Restore radio buttons
                                    form.querySelectorAll('input[type="radio"]').forEach(radio => {
                                        if (formData[radio.name]) {
                                            radio.checked = (formData[radio.name] === radio.value);
                                        }
                                    });
                                }
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error loading form:', error);
                        modalContent.innerHTML = 'Error loading form';
                    });
            }
        }

        function setupFormSubmission() {
            const form = document.querySelector('#modalContent form');
            console.log('Setting up form submission handler for FillingOutB form');

            if (form) {
                // Add event listener for the "Others" checkbox
                form.addEventListener('change', function(e) {
                    if (e.target.id === 'others-checkbox') {
                        const othersInput = document.getElementById('others-input');
                        if (othersInput) {
                            othersInput.style.display = e.target.checked ? 'inline-block' : 'none';
                            if (!e.target.checked) {
                                othersInput.value = ''; // Clear the input when unchecked
                            }
                        }
                    }
                });

                // Rest of your form submission code...
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Create an object to store all form data
                    const formObject = {};

                    // Handle regular inputs, selects, and textareas
                    form.querySelectorAll('input:not([type="checkbox"]):not([type="radio"]), select, textarea').forEach(element => {
                        formObject[element.name] = element.value;
                        // Special handling for others input
                        if (element.id === 'others-input') {
                            formObject['others_specify'] = element.value;
                        }
                    });

                    // Handle checkbox groups
                    const checkboxGroups = {};
                    form.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                        const groupName = checkbox.name.replace('[]', '');
                        if (!checkboxGroups[groupName]) {
                            checkboxGroups[groupName] = [];
                        }
                        if (checkbox.checked) {
                            checkboxGroups[groupName].push(checkbox.value);
                            // Special handling for others checkbox
                            if (checkbox.id === 'others-checkbox') {
                                const othersInput = document.getElementById('others-input');
                                if (othersInput) {
                                    formObject['others_specify'] = othersInput.value;
                                }
                            }
                        }
                    });

                    // Add checkbox groups to form object
                    Object.keys(checkboxGroups).forEach(groupName => {
                        formObject[groupName] = checkboxGroups[groupName];
                    });

                    // Handle radio buttons
                    form.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
                        formObject[radio.name] = radio.value;
                    });

                    console.log('Form data to store:', formObject);

                    try {
                        sessionStorage.setItem('formBData', JSON.stringify(formObject));
                    } catch (error) {
                        console.error('Storage error:', error);
                    }

                    // Create FormData for submission
                    const formData = new FormData(form);

                    // Submit to FillOutProcessing.php
                    fetch('FillOutProcessing.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(result => {
                            console.log('Processing result:', result);

                            if (result.includes('success')) {
                                alert('Form submitted successfully!');
                                modal.style.display = "none";
                                sessionStorage.removeItem('formBData');
                            } else if (result.includes('window.location.href')) {
                                const alertMatch = result.match(/alert\('([^']+)'\)/);
                                if (alertMatch) {
                                    alert(alertMatch[1]);
                                }
                                const urlMatch = result.match(/window\.location\.href = '([^']+)'/);
                                if (urlMatch) {
                                    window.location.href = urlMatch[1];
                                }
                            } else {
                                alert('Please check your form entries and try again.');
                            }
                        })
                        .catch(error => {
                            console.error('Submission error:', error);
                            alert('An error occurred while submitting the form. Your responses have been saved. Please try again.');
                        });
                });
            } else {
                console.error('FillingOutB form not found');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Close all other FAQs
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                            const otherNumber = otherItem.querySelector('.faq-number');
                            otherNumber.classList.remove('faq-number-active');
                            otherNumber.classList.add('faq-number-inactive');
                        }
                    });

                    // Toggle current FAQ
                    this.classList.toggle('active');
                    const number = this.querySelector('.faq-number');
                    number.classList.toggle('faq-number-active');
                    number.classList.toggle('faq-number-inactive');
                });
            });

            // Add the new URL parameter checking code
            const urlParams = new URLSearchParams(window.location.search);
            const openModal = urlParams.get('openModal');
            const form = urlParams.get('form');

            if (openModal === 'true' && form === 'B') {
                const modal = document.getElementById('formModal');
                if (modal) {
                    modal.style.display = 'block';
                    loadFormContent('FillingOutB.php');
                }
            }
        });

        // Add these new functions
        function openViewModal() {
            const viewModal = document.getElementById('viewFormModal');
            const viewModalContent = document.getElementById('viewModalContent');

            viewModal.style.display = "block";

            // Load the form content
            fetch('ViewMyForm.php')
                .then(response => response.text())
                .then(content => {
                    viewModalContent.innerHTML = content;
                    // Add print button event listener after content is loaded
                    const printButton = viewModalContent.querySelector('.print-btn');
                    if (printButton) {
                        printButton.onclick = handlePrint;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    viewModalContent.innerHTML = 'Error loading form';
                });
        }

        function closeViewModal() {
            const viewModal = document.getElementById('viewFormModal');
            viewModal.style.display = "none";
        }

        // Add this to your existing script section
        function handlePrint() {
            // Get the modal and its content
            const viewModal = document.getElementById('viewFormModal');
            const printContent = document.getElementById('viewModalContent').innerHTML;

            // Create a hidden iframe for printing
            const iframe = document.createElement('iframe');
            
            // Set iframe styles to hide it
            Object.assign(iframe.style, {
                visibility: 'hidden',
                position: 'fixed',
                right: '0',
                bottom: '0',
                width: '0',
                height: '0',
                border: 'none',
                margin: '0',
                padding: '0',
                display: 'none',
                overflow: 'hidden'
            });
            
            // Add iframe to the document
            document.body.appendChild(iframe);
            
            // Write the content to the iframe
            iframe.contentDocument.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Print Form</title>
                    <style>
                        @media print {
                            /* Hide elements */
                            header, .nav, .logo, .action-container, .action-buttons,
                            .print-button, .action-btn, .proceed-btn, .mark-btn,
                            .delete-btn, .print-btn, .all-buttons-wrapper {
                                display: none !important;
                            }

                            /* Page setup */
                            @page {
                                margin: 0.5in !important;
                                size: legal !important;
                            }

                            /* Override modal styles first */
                            .modal, 
                            .modal-content, 
                            #modalContent,
                            #viewModalContent {
                                all: initial !important;
                                position: static !important;
                                padding: 0 !important;
                                margin: 0 !important;
                                width: 100% !important;
                                background: none !important;
                                box-shadow: none !important;
                                overflow: visible !important;
                            }

                            /* Reset any modal padding/margins */
                            .modal-body,
                            #modalContent .modal-body,
                            #viewModalContent .modal-body {
                                padding: 0 !important;
                                margin: 0 !important;
                            }

                            /* Base styles */
                            body {
                                padding-top: 0 !important;
                                font-size: 9pt !important;
                                line-height: 1.2 !important;
                                font-family: "Times New Roman", Times, serif !important;
                                margin: 0 !important;
                                background: none !important;
                            }

                            /* Container styles */
                            .container {
                                margin: 0 !important;
                                padding: 0 !important;
                                width: 100% !important;
                                border: none !important;
                                box-sizing: border-box !important;
                                position: relative !important;
                                padding-top: 70px !important;
                                background: none !important;
                            }

                            /* Form Header */
                            .form-header,
                            .modal .form-header,
                            .modal-content .form-header {
                                text-align: center !important;
                                border-bottom: 1px solid black !important;
                                margin: 0 0 15px 0 !important;
                                padding: 0 0 5px 0 !important;
                                position: relative !important;
                            }

                            .form-header h1,
                            .modal .form-header h1,
                            .modal-content .form-header h1 {
                                font-size: 12pt !important;
                                margin: 0 0 5px 0 !important;
                                padding: 0 !important;
                                font-weight: bold !important;
                                text-align: center !important;
                            }

                            /* Personal Information section */
                            .personal-info-section,
                            .modal .personal-info-section,
                            .modal-content .personal-info-section {
                                display: flex !important;
                                flex-wrap: wrap !important;
                                gap: 5px 20px !important;
                                margin: 10px 0 !important;
                                padding: 0 !important;
                            }

                            .personal-info-section .info-item,
                            .modal .personal-info-section .info-item,
                            .modal-content .personal-info-section .info-item {
                                flex: 0 0 calc(50% - 10px) !important;
                                margin: 0 !important;
                                padding: 0 !important;
                                min-height: 0 !important;
                            }

                            /* Container elements */
                            .container .form-container {
                                border-radius: 0 !important;
                                padding-top: 0 !important;
                                margin: 0 !important;
                                background: none !important;
                            }

                            /* Header elements */
                            .container::before {
                                content: "" !important;
                                position: absolute !important;
                                top: 10px !important;
                                left: 50% !important;
                                transform: translateX(-50%) !important;
                                width: 100% !important;
                                max-width: 600px !important;
                                height: 50px !important;
                                background-image: url("image/bsulogo.png") !important;
                                background-repeat: no-repeat !important;
                                background-size: 50px auto !important;
                                background-position: left center !important;
                                -webkit-print-color-adjust: exact !important;
                                print-color-adjust: exact !important;
                            }

                            .container::after {
                                content: "Reference No.: BatStateU-FO-OGC-09 | Effectivity Date: May 18, 2022 | Revision No.: 01" !important;
                                position: absolute !important;
                                top: 10px !important;
                                left: 50% !important;
                                transform: translateX(-50%) !important;
                                width: 100% !important;
                                max-width: 600px !important;
                                padding-left: 60px !important;
                                font-family: "Times New Roman", Times, serif !important;
                                font-size: 10pt !important;
                                font-weight: bold !important;
                                display: flex !important;
                                align-items: center !important;
                                height: 50px !important;
                                box-sizing: border-box !important;
                            }

                            /* Typography */
                            h2 {
                                font-size: 12pt !important;
                                margin: 4pt 0 !important;
                                padding: 0 !important;
                            }

                            h3 {
                                font-size: 11pt !important;
                                margin: 8pt 0 4pt 0 !important;
                                padding: 0 !important;
                            }

                            h5 {
                                font-size: 10pt !important;
                                margin: 4pt 0 2pt 0 !important;
                                padding: 0 !important;
                            }

                            /* Layout components */
                            .horizontal-layout {
                                display: flex !important;
                                flex-wrap: wrap !important;
                                gap: 4px !important;
                                margin-bottom: 4px !important;
                            }

                            /* Info items */
                            .info-item,
                            .short-info-item {
                                display: flex !important;
                                align-items: center !important;
                                page-break-inside: avoid !important;
                                min-width: 120px !important;
                            }

                            .info-item .info-label,
                            .modal .info-item .info-label,
                            .modal-content .info-item .info-label {
                                flex: 0 0 120px !important;
                                padding-right: 5px !important;
                                margin: 0 !important;
                                font-size: 9pt !important;
                            }

                            .info-item .info-value,
                            .modal .info-item .info-value,
                            .modal-content .info-item .info-value {
                                flex: 1 !important;
                                min-height: 0 !important;
                                font-size: 9pt !important;
                                border: 1px solid #000 !important;
                                padding: 2px 4px !important;
                                margin: 0 !important;
                                white-space: normal !important;
                                word-wrap: break-word !important;
                                background: white !important;
                            }

                            /* Container layouts */
                            .parents-container,
                            .consultations-container,
                            .medical-container {
                                display: flex !important;
                                gap: 20px !important;
                                page-break-inside: avoid !important;
                                margin-bottom: 8pt !important;
                                padding: 0 !important;
                            }

                            /* Column styles */
                            .parent-column,
                            .consultation-column,
                            .medical-column {
                                flex: 1 !important;
                                margin: 0 !important;
                                padding: 0 !important;
                                background: none !important;
                            }

                            .parent-column {
                                max-width: 50% !important;
                            }

                            /* Column headers */
                            .parent-column h5,
                            .consultation-column h5,
                            .medical-column h5 {
                                font-size: 10pt !important;
                                border-bottom: 1px solid #000 !important;
                                margin-bottom: 4pt !important;
                                text-align: center !important;
                                padding-bottom: 4px !important;
                            }

                            /* Form sections */
                            .info-section {
                                margin: 4pt 0 !important;
                                padding: 0 !important;
                            }

                            /* Two-column Personal Info section from reference */
                            h3:first-of-type + .info-section {
                                display: flex !important;
                                flex-wrap: wrap !important;
                                gap: 4px !important;
                            }

                            h3:first-of-type + .info-section .info-item {
                                flex: 0 0 calc(50% - 2px) !important; 
                                max-width: calc(50% - 2px) !important; 
                            }

                            /* Input styles */
                            input[type="checkbox"],
                            input[type="radio"] {
                                width: 16px !important;
                                height: 16px !important;
                                border: 2px solid black !important;
                                background: white !important;
                                margin: 0 6px !important;
                                position: relative !important;
                                display: inline-block !important;
                                -webkit-print-color-adjust: exact !important;
                                print-color-adjust: exact !important;
                            }

                            input[type="radio"] {
                                border-radius: 50% !important;
                            }

                            input[type="checkbox"]:checked::before {
                                content: '✓' !important;
                                position: absolute !important;
                                font-size: 14px !important;
                                font-weight: 900 !important;
                                color: black !important;
                                top: 45% !important;
                                left: 50% !important;
                                transform: translate(-50%, -50%) !important;
                                line-height: 1 !important;
                            }

                            input[type="radio"]:checked::after {
                                content: '' !important;
                                position: absolute !important;
                                top: 50% !important;
                                left: 50% !important;
                                transform: translate(-50%, -50%) !important;
                                width: 8px !important;
                                height: 8px !important;
                                border-radius: 50% !important;
                                background: #000000 !important;
                                -webkit-print-color-adjust: exact !important;
                                print-color-adjust: exact !important;
                                color-adjust: exact !important;
                            }

                            /* Radio groups */
                            .radio-group {
                                display: flex !important;
                                align-items: center !important;
                                gap: 10px !important;
                                margin: 0 !important;
                                padding: 0 !important;
                            }

                            .radio-options {
                                display: flex !important;
                                gap: 15px !important;
                                align-items: center !important;
                                margin: 0 !important;
                                padding: 0 !important;
                            }

                            /* Page breaks */
                            .page-break-section {
                                page-break-before: always !important;
                                margin-top: 0 !important;
                                padding-top: 0 !important;
                            }

                            /* Font family override */
                            * {
                                font-family: "Times New Roman", Times, serif !important;
                            }

                            /* Ensure all sections respect the container margin */
                            .personal-info-section,
                            .parents-container,
                            .consultations-container,
                            .medical-container,
                            .info-section {
                                margin: 0 !important;
                                width: 100% !important;
                            }

                            /* Parent Information Checkboxes - More specific targeting */
                            .parent-column .info-item:has(input[type="checkbox"]) {
                                display: flex !important;
                                flex-direction: row !important;
                                align-items: center !important;
                                gap: 4px !important;
                                margin-bottom: 4px !important;
                                border: none !important;
                            }

                            .parent-column .info-item:has(input[type="checkbox"]) input[type="checkbox"] {
                                width: 12px !important;
                                height: 12px !important;
                                margin-right: 4px !important;
                                position: static !important;
                                display: inline-block !important;
                            }

                            .parent-column .info-item:has(input[type="checkbox"]) .info-label {
                                display: inline !important;
                                width: auto !important;
                                flex: none !important;
                                padding: 0 !important;
                                margin: 0 !important;
                            }

                            /* Hide the value container for deceased checkboxes */
                            .parent-column .info-item:has(input[type="checkbox"]) .info-value {
                                display: none !important;
                            }

                            /* Parent Columns Equal Spacing */
                            .parents-container {
                                display: flex !important;
                                gap: 20px !important;
                                justify-content: space-between !important;
                            }

                            .parent-column {
                                flex: 1 !important;
                                max-width: 48% !important; /* Make both columns equal width */
                                padding: 0 !important;
                            }

                            /* Consistent spacing for all info items in both columns */
                            .parent-column .info-item {
                                display: flex !important;
                                align-items: center !important;
                                margin-bottom: 8px !important; /* Add consistent vertical spacing */
                                min-height: 24px !important; /* Ensure consistent height */
                            }

                            .info-item .info-label {
                                flex: 0 0 150px !important; /* Fixed width for labels */
                                margin: 0 !important;
                                padding-right: 5px !important;
                            }

                            .info-item .info-value {
                                flex: 1 !important;
                                margin: 0 !important;
                            }

                            /* Specific spacing for deceased checkboxes */
                            .parent-column .info-item:first-child {
                                margin-bottom: 12px !important; /* Add more space after deceased checkbox */
                            }

                            /* Fix label wrapping issues */
                            .parent-column .info-item .info-label {
                                white-space: nowrap !important; /* Prevent label text wrapping */
                                overflow: visible !important;
                                width: auto !important;
                                min-width: 120px !important;
                                font-size: 9pt !important; /* Ensure consistent font size */
                                line-height: 1.2 !important; /* Maintain single line height */
                            }

                            /* Ensure equal spacing in both columns */
                            .parent-column {
                                flex: 1 !important;
                                max-width: 48% !important;
                            }

                            /* Maintain consistent spacing between items */
                            .parent-column .info-item {
                                margin-bottom: 8px !important;
                                min-height: 20px !important;
                                gap: 2px !important;
                            }

                            /* Add proper spacing for textboxes */
                            .info-item .info-value {
                                border: 1px solid #000 !important;
                                padding: 2px 4px !important;
                                margin: 2px 0 !important;
                                background: white !important;
                                min-height: 16px !important;
                            }

                            /* Maintain column spacing */
                            .parent-column {
                                flex: 1 !important;
                                max-width: 48% !important;
                                gap: 4px !important;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <div class="form-container">
                                ${printContent}
                            </div>
                        </div>
                    </body>
                    </html>
                `);

            // Wait for content to load then print
            iframe.contentDocument.close();
            iframe.focus();

            iframe.onload = function() {
                // Print the iframe
                iframe.contentWindow.print();

                // Optional: Close the print iframe after printing is done or cancelled
                iframe.contentWindow.onafterprint = function() {
                    iframe.remove();
                };
            };

            // Keep the modal visible
            viewModal.style.display = "block";
        }
    </script>
</body>

</html>