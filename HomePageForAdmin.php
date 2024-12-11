<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page -Student Success Hub</title>
    <link rel="stylesheet" href="styles2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
                        <h1>Welcome Admin!</h1>
                        <p>Manage and Oversee the system with ease 😊.</p>
                        <p>Let's Get Started! </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>Admin Actions</h2>
            <p>Admins have the ability to efficiently manage individual interview forms by updating their status to 'Done' or 'Archived.' They can also import and export student credentials for streamlined data management. Additionally, admins can delete forms, print them when necessary, and ensure the system remains organized and up-to-date.</p>
            <div class="admin-navigation">
                <a href="ViewLogs.php" class="admin-nav-link" data-tooltip="View and manage all pending student interview forms">
                    <i class="fas fa-clock"></i>
                    View Pending Logs
                </a>
                <a href="MarkedAsDone.php" class="admin-nav-link" data-tooltip="Access completed and processed interview forms">
                    <i class="fas fa-check-circle"></i>
                    View Done Logs
                </a>
                <a href="Archive.php" class="admin-nav-link" data-tooltip="Browse through historical and archived interview records">
                    <i class="fas fa-archive"></i>
                    View Archived Logs
                </a>
                <a href="ImportDB.php" class="admin-nav-link" data-tooltip="Import student data from external files (Excel)">
                    <i class="fas fa-file-import"></i>
                    Import Student Credentials
                </a>
                <a href="ExportDB.php" class="admin-nav-link" data-tooltip="Download and export student records to your computer">
                    <i class="fas fa-file-export"></i>
                    Export Student Credentials
                </a>
            </div>

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

        <footer>
            <p>&copy; 2024 Student Success Hub. All rights reserved.</p>
            <a href="https://www.facebook.com/guidanceandcounselinglipa">Office of Guidance and Counseling - Batstateu Lipa (Ogc Lipa) Facebook Page<br></a>
            <p>Email: ogc.lipa@g.batstate-u.edu.ph</p>
        </footer>
    </main>

    <script>
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
        });
    </script>

</body>

</html>