<?php
require("connect.php");
require("insertSchedule.php");

if (isset($_GET['date'])) {
    $selectedDate = htmlspecialchars($_GET['date']);
    
    // Fetch available slots
    $timeSlots = ["09:00:00", "10:00:00", "11:00:00", "14:30:00", "15:00:00"];
    $q = "SELECT TIME(booking_date) AS booked_time FROM scheduling WHERE DATE(booking_date) = '$selectedDate'";
    $result = myQuery($q);

    $bookedSlots = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $bookedSlots[] = $row['booked_time'];
    }

    $availableSlots = array_diff($timeSlots, $bookedSlots);

    // Return available slots as JSON
    echo json_encode(array_values($availableSlots));
}
?>
