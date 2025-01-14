<?php
$DEBUG_MODE = false;

require("connect.php");

if (isset($_POST['submit_booking'])) {
    // Get the selected scheduling ID from the client
    $schedulingId = htmlspecialchars($_POST['scheduling_id']);
    $userId = htmlspecialchars($_POST['user_id']);

    // Update the selected slot to mark it as booked (status = 1) and assign the user ID
    $q = "UPDATE scheduling SET user_user_id = '$userId', status = 1 WHERE scheduling_id = '$schedulingId' AND status = 0";

    if ($DEBUG_MODE) {
        echo $q;
    }

    if (myQuery($q)) {
        echo "<p style='color: green;'>Booking successfully completed!</p>";
    } else {
        echo "<p style='color: red;'>Error processing booking. Please try again.</p>";
    }
} else {
    // Fetch available slots (status = 0)
    $result = myQuery("SELECT * FROM scheduling WHERE status = 0");

    // Display available slots
    echo "<form action='insertSchedule.php' method='post' style='max-width: 500px; margin: auto; font-family: Arial, sans-serif;'>";
    echo "<h3 style='text-align: center;'>Available Slots</h3>";

    if (mysqli_num_rows($result) > 0) {
        echo "<label for='scheduling_id'>Choose a Slot:</label><br>";
        echo "<select id='scheduling_id' name='scheduling_id' required style='width: 100%; padding: 10px; margin-bottom: 10px;'>";
        
        // Populate the dropdown with available slots
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['scheduling_id'] . "'>Attorney ID: " . $row['attorney_id'] . " - Date: " . $row['booking_date'] . "</option>";
        }
        
        echo "</select><br>";
    } else {
        echo "<p style='color: red; text-align: center;'>No available slots at the moment.</p>";
    }

    echo "<label for='user_id'>User ID:</label><br>";
    echo "<input type='number' id='user_id' name='user_id' placeholder='Enter Your User ID' required style='width: 100%; padding: 10px; margin-bottom: 10px;'><br>";

    echo "<button type='submit' name='submit_booking' style='width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; cursor: pointer;'>Book Slot</button>";
    echo "</form>";
}
?>
