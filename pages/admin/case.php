<?php
include("connect.php");

$list = myQuery("
    SELECT 
        s1.scheduling_id AS id, 
        CONCAT(u.first_name, ' ', u.last_name) AS client_name, 
        CONCAT(a.attorney_firstname, ' ', a.attorney_lastname) AS attorney_name, 
        s2.booking_date AS booking_date, 
        s2.status AS booking_status
    FROM scheduling AS s1
    LEFT JOIN user AS u ON s1.user_user_id = u.user_id
    LEFT JOIN scheduling AS s2 ON s1.scheduling_id = s2.scheduling_id
    LEFT JOIN attorney AS a ON s2.attorney_id = a.attorney_id
");

if ($list && $list->num_rows > 0) {
    echo "<table border='1' cellspacing='0' cellpadding='10'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Client Name</th>";
    echo "<th>Attorney Name</th>";
    echo "<th>Booking Date</th>";
    echo "<th>Booking Status</th>";
    echo "<th>Actions</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = $list->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['client_name'] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row['attorney_name'] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row['booking_date'] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row['booking_status'] ?? 'N/A') . "</td>";
        echo "<td>
            <a href='update_booking.php?id=" . $row['id'] . "'>Update</a> | 
            <a href='delete_booking.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this booking?')\">Delete</a>
        </td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "No records found.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $booking_date = $_POST['booking_date'];
    $status = $_POST['status'];

    myQuery("
        UPDATE scheduling
        SET booking_date = '$booking_date', status = '$status'
        WHERE scheduling_id = $id
    ");

    echo "Booking updated successfully.";
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    myQuery("
        DELETE FROM scheduling
        WHERE scheduling_id = $id
    ");

    echo "Booking deleted successfully.";
}
?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = myQuery("SELECT * FROM scheduling WHERE scheduling_id = $id");

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <label for="booking_date">Booking Date:</label>
            <input type="date" id="booking_date" name="booking_date" value="<?php echo htmlspecialchars($row['booking_date']); ?>">
            <label for="status">Status:</label>
            <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($row['status']); ?>">
            <button type="submit" name="update">Update Booking</button>
        </form>
        <?php
    } else {
        echo "No booking found with this ID.";
    }
}
?>