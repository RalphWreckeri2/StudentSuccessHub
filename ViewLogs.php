<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Interview Form - Student Success Hub</title>
    <link rel="stylesheet" href="styles12.css">

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

    <main>
        <!--<div class="profile-section">
            <div class="profile-content">
                <h1>Welcome Admin!</h1>
                <p>This is the View Pending Logs Page.</p>
                <p>Here you can view the pending logs and mark them as done.</p>
            </div>
        </div>-->

        <div class="form-container">
            <h2 class="section-header">Submitted Individual Interview Form</h2>

            <div class="search-container">
                <input type="text" id="search-input" class="search-input" placeholder="Type SR Code, Name, or Date">
                <label for="search-input" class="search-label">Search</label>
            </div>

            <div class="form-row">

                <?php
                session_start();
                include 'db_connection.php';

                $query = "SELECT student_name, student_sr_code, date, status 
                      FROM form
                      WHERE status = 'pending'
                      ORDER BY date DESC";

                $result = $conn->query($query);

                if (!$result) {
                    echo "Error executing query: " . $conn->error;
                } else {
                    if ($result->num_rows > 0) {
                        echo "<div class='counts-container'>";
                        echo "<div class='total-pending-logs'>Total Pending Logs: " . $result->num_rows . "</div>";
                        echo "</div>";

                        echo "<div class='info-container'>";
                        echo "<div class='info-item header'><span>Student Name</span><span>SR - Code</span><span>Submission Date</span></div>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='info-item' data-name='" . htmlspecialchars($row['student_name']) . "' data-date='" . htmlspecialchars($row['date']) . "' data-sr-code='" . htmlspecialchars($row['student_sr_code']) . "'>";
                            echo "<a href='ViewSpecificLog.php?name=" . htmlspecialchars($row['student_name']) . "' class='name-link'>" . htmlspecialchars($row['student_name']) . "</a>";
                            echo "<span class='sr-code'>" . htmlspecialchars($row['student_sr_code']) . "</span>";
                            echo "<span class='submission-date'>" . htmlspecialchars($row['date']) . "</span>";
                            // echo "<span class='status'>" . htmlspecialchars($row['status']) . "</span>";
                            echo "</div><hr class='separator'>";
                        }
                        echo "</div>";
                    } else {
                        echo "<div class='no-records'>";
                        echo "<p>No pending records found.</p>";
                        echo "</div>";
                    }
                }
                $conn->close();
                ?>

            </div>
            <div class="button-container">
                <a href="MarkedAsDone.php" class="proceed-btn">MARKED AS DONE</a>
                <a href="HomePageForAdmin.php" class="proceed-btn">GO BACK</a>
            </div>
        </div>

        <footer>
            <p>&copy; 2024 Student Success Hub. All rights reserved.</p>
            <a href="https://www.facebook.com/guidanceandcounselinglipa">Office of Guidance and Counseling - Batstateu Lipa (Ogc Lipa) Facebook Page<br></a>
            <p>Email: ogc.lipa@g.batstate-u.edu.ph</p>
        </footer>

    </main>


    <script>
        document.querySelector(".search-input").addEventListener("input", function() {
            const searchTerm = this.value.toLowerCase();
            const items = document.querySelectorAll(".info-item:not(.header)");

            let noResults = true;

            items.forEach(item => {
                const name = item.getAttribute("data-name").toLowerCase();
                const date = item.getAttribute("data-date").toLowerCase();
                const srCode = item.getAttribute("data-sr-code").toLowerCase();


                if (name.includes(searchTerm) || date.includes(searchTerm) || srCode.includes(searchTerm)) {
                    item.classList.remove("hidden");
                    noResults = false;
                } else {
                    item.classList.add("hidden");
                }
            });

            const container = document.querySelector(".info-container");
            const noResultsMessage = document.querySelector(".no-results-message");

            if (noResults) {
                if (!noResultsMessage) {
                    const message = document.createElement("p");
                    message.classList.add("no-results-message");
                    message.textContent = "No student records found.";
                    container.appendChild(message);
                }
            } else {
                if (noResultsMessage) noResultsMessage.remove();
            }
        });
    </script>

</body>

</html>