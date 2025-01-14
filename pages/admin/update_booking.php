<?php
include("connect.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize input
    $stmt = $conn->prepare("SELECT * FROM scheduling WHERE scheduling_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <form method="POST" action="update_booking.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <label for="booking_date">Booking Date:</label>
            <input type="date" id="booking_date" name="booking_date" value="<?php echo htmlspecialchars($row['booking_date']); ?>" required>
            <label for="status">Status:</label>
            <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($row['status']); ?>" required>
            <button type="submit" name="update">Update Booking</button>
        </form>
        <?php
    } else {
        echo "No booking found with this ID.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $booking_date = $_POST['booking_date'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE scheduling SET booking_date = ?, status = ? WHERE scheduling_id = ?");
    $stmt->bind_param("ssi", $booking_date, $status, $id);

    if ($stmt->execute()) {
        header("Location: case.php?message=Booking+updated+successfully");
        exit();
    } else {
        echo "Error updating booking.";
    }
}
?>