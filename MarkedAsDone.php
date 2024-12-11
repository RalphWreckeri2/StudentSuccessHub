<?php
session_start();
include 'db_connection.php';


if (isset($_GET['action']) && isset($_GET['name'])) {
    $student_name = $_GET['name'];

    if ($_GET['action'] == 'mark_done') {
        $status = 'done';
    } else if ($_GET['action'] == 'unmark_done') {
        $status = 'pending';
    }

    $update_query = "UPDATE form SET status = ? WHERE student_name = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ss", $status, $student_name);

    if ($update_stmt->execute()) {
        echo "<script>alert('Student record updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating record: " . addslashes($conn->error) . "');</script>";
    }
    $update_stmt->close();

    if (isset($_GET['redirect']) && $_GET['redirect'] === 'viewlogs') {
        header("Location: ViewLogs.php");
        exit();
    }
}

$pending_query = "SELECT COUNT(*) as pending_count FROM form WHERE status = 'pending'";
$pending_result = $conn->query($pending_query);
$pending_count = $pending_result->fetch_assoc()['pending_count'];

$done_query = "SELECT COUNT(*) as done_count FROM form WHERE status = 'done'";
$done_result = $conn->query($done_query);
$done_count = $done_result->fetch_assoc()['done_count'];

$query = "SELECT student_name, student_sr_code, date, status 
          FROM form
          WHERE status = 'done'
          ORDER BY date DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marked as Done Records - Student Success Hub</title>
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
        <div class="form-container">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <h2 class="section-header">Marked as Done Records</h2>

            <div class="search-container">
                <input type="text" id="search-input" class="search-input" placeholder="Type SR Code, Name, or Date">
                <label for="search-input" class="search-label">Search</label>
            </div>

            <div class="counts-container">
                <div class="total-done-logs">Total Done Logs: <?php echo $done_count; ?></div>
                <button onclick="confirmArchiveAll()" class="archive-all-btn">ARCHIVE ALL</button>
            </div>

            <div class="form-row">
                <?php
                if (!$result) {
                    echo "Error executing query: " . $conn->error;
                } else {
                    if ($result->num_rows > 0) {
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
                        echo "<p>No records marked as done yet.</p>";
                        echo "</div>";
                    }
                }
                $conn->close();
                ?>
            </div>

            <div class="button-container">
                <a href="Archive.php" class="proceed-btn">ARCHIVE</a>
                <a href="ViewLogs.php" class="proceed-btn">GO BACK</a>
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
                    const message = document.createElement("div");
                    message.classList.add("no-results-message");
                    message.textContent = "No student records found.";
                    container.appendChild(message);
                }
            } else {
                if (noResultsMessage) noResultsMessage.remove();
            }
        });

        function confirmArchiveAll() {
            if (confirm("Are you sure you want to archive all done logs?")) {
                window.location.href = 'process_archive_all.php?redirect=archive';
            }
        }
    </script>
</body>

</html>