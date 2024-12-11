<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Excel to Database</title>
    <link rel="stylesheet" href="styles14.css">
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
        <div class="container">
            <h1>Import Excel to Database</h1>

            <?php

            require 'vendor/autoload.php';
            require 'db_connection.php';

            use PhpOffice\PhpSpreadsheet\IOFactory;

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
                $inputFileName = $_FILES['excel_file']['tmp_name'];
                $successCount = 0;
                $errorCount = 0;

                try {
                    $spreadsheet = IOFactory::load($inputFileName);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $rows = $worksheet->toArray();


                    array_shift($rows);

                    foreach ($rows as $index => $row) {

                        if (empty(array_filter($row))) {
                            continue;
                        }

                        if (empty($row[0])) {
                            $errorCount++;
                            echo "<p>Row " . ($index + 2) . ": Student email cannot be empty</p>";
                            continue;
                        }

                        $student_email = $row[0];
                        $student_password = $row[1];
                        $reset_token = $row[2];
                        $sr_code = $row[3];
                        $admin_id = $row[4];
                        $token_timestamp = $row[5];


                        $check_stmt = $conn->prepare("SELECT student_email FROM student_credentials WHERE student_email = ?");
                        $check_stmt->bind_param("s", $student_email);
                        $check_stmt->execute();
                        $result = $check_stmt->get_result();

                        if ($result->num_rows > 0) {
                            $errorCount++;
                            echo "<p>Row " . ($index + 2) . ": Duplicate entry for email $student_email</p>";
                            continue;
                        }


                        $stmt = $conn->prepare("INSERT INTO student_credentials (student_email, student_password, reset_token, sr_code, admin_id, token_timestamp) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("sssssi", $student_email, $student_password, $reset_token, $sr_code, $admin_id, $token_timestamp);

                        if ($stmt->execute()) {
                            $successCount++;
                        } else {
                            $errorCount++;
                            echo "<p>Row " . ($index + 2) . ": Error inserting data - " . $stmt->error . "</p>";
                        }
                    }


                    if ($successCount > 0) {
                        echo "<p class='success'>Successfully imported $successCount records.</p>";
                    }
                    if ($errorCount > 0) {
                        echo "<p class='error'>Failed to import $errorCount records. Please check the errors above.</p>";
                    }
                    if ($successCount == 0 && $errorCount == 0) {
                        echo "<p>No data was found to import.</p>";
                    }
                } catch (Exception $e) {
                    echo "<p class='error'>Error loading file: " . $e->getMessage() . "</p>";
                }

                if (isset($stmt)) {
                    $stmt->close();
                }
                if (isset($check_stmt)) {
                    $check_stmt->close();
                }
                $conn->close();
            }

            ?>

            <form method="post" enctype="multipart/form-data">
                <div class="file-upload">
                    <label for="excel_file">Choose Excel file:</label>
                    <input type="file" name="excel_file" id="excel_file" required>
                </div>
                <div class="button-container">
                    <a href="HomePageForAdmin.php" class="proceed-btn">GO BACK</a>
                    <button type="submit" class="upload-btn">Upload</button>
                </div>
            </form>

        </div>



    </main>

    <footer>
        <footer>
            <p>&copy; 2024 Student Success Hub. All rights reserved.</p>
            <a href="https://www.facebook.com/guidanceandcounselinglipa">Office of Guidance and Counseling - Batstateu Lipa (Ogc Lipa) Facebook Page</a>
            <p>Email: ogc.lipa@g.batstate-u.edu.ph</p>
        </footer>
    </footer>

</body>

</html>

</html>