<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Database to Excel</title>
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
            <h1>Export Database to Excel</h1>
            <p class="description">The current data residing in the student credentials table in the database will be exported to an Excel file. Please note that these data requires confidentiality. Anyone with access to this file may have access to sensitive information.</p>
            <?php
            require 'vendor/autoload.php';
            require 'db_connection.php';

            use PhpOffice\PhpSpreadsheet\Spreadsheet;
            use PhpOffice\PhpSpreadsheet\Writer\Xls;

            if (isset($_POST['export'])) {
                try {
                    $result = $conn->query("SELECT * FROM student_credentials");
                    if (!$result) {
                        throw new Exception("Database query failed: " . $conn->error);
                    }

                    $spreadsheet = new Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();

                    $sheet->setCellValue('A1', 'Student Email');
                    $sheet->setCellValue('B1', 'Student Password');
                    $sheet->setCellValue('C1', 'Reset Token');
                    $sheet->setCellValue('D1', 'SR Code');
                    $sheet->setCellValue('E1', 'Admin ID');
                    $sheet->setCellValue('F1', 'Token Timestamp');

                    $rowCount = 2;
                    while ($row = $result->fetch_assoc()) {
                        $sheet->setCellValue('A' . $rowCount, $row['student_email']);
                        $sheet->setCellValue('B' . $rowCount, $row['student_password']);
                        $sheet->setCellValue('C' . $rowCount, $row['reset_token']);
                        $sheet->setCellValue('D' . $rowCount, $row['sr_code']);
                        $sheet->setCellValue('E' . $rowCount, $row['admin_id']);
                        $sheet->setCellValue('F' . $rowCount, $row['token_timestamp']);
                        $rowCount++;
                    }

                    $writer = new Xls($spreadsheet);

                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="database_export_' . date('Y-m-d_H-i-s') . '.xls"');
                    header('Cache-Control: max-age=0');
                    header('Pragma: public');

                    ob_end_clean();

                    $writer->save('php://output');
                    exit;
                } catch (Exception $e) {
                    error_log($e->getMessage());
                    echo "<p class='error'>An error occurred while exporting the data: " . htmlspecialchars($e->getMessage()) . "</p>";
                } finally {
                    $conn->close();
                }
            } else {
                echo "<form method='post'>";
                echo "<div class='button-container'>";
                echo "<a href='HomePageForAdmin.php' class='proceed-btn'>GO BACK</a>";
                echo "<button type='submit' name='export' class='proceed-btn'>Export to Excel</button>";
                echo "</div>";
                echo "</form>";
            }
            ?>

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