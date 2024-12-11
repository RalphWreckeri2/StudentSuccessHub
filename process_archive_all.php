<?php
session_start();
include 'db_connection.php';

try {
   
    $update_query = "UPDATE form SET status = 'archived' WHERE status = 'done'";
    
    if ($conn->query($update_query)) {
        header("Location: MarkedAsDone.php");
        exit();
    } else {
        throw new Exception($conn->error);
    }

} catch (Exception $e) {
    header("Location: MarkedAsDone.php");
    exit();
}

if (isset($_GET['redirect']) && $_GET['redirect'] === 'archive') {
    header("Location: Archive.php");
    exit();
}

$conn->close();
?> 