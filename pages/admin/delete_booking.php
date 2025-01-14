<?php
include("connect.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize input
    $stmt = $conn->prepare("DELETE FROM scheduling WHERE scheduling_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: case.php?message=Booking+deleted+successfully");
        exit();
    } else {
        echo "Error deleting booking.";
    }
}
?>