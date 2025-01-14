<?php
include("connect.php");


if (isset($_GET['scheduling_id'])) {
    $scheduling_id = intval($_GET['scheduling_id']); 

    $scheduling = myQuery("
        SELECT 
            s.scheduling_id,
            u.user_id,
            CONCAT(u.first_name, ' ', u.last_name) AS Client,
            a.attorney_id,
            CONCAT(a.attorney_firstname, ' ', a.attorney_lastname) AS Attorney,
            s.booking_date,
            s.status
        FROM scheduling AS s
        INNER JOIN user AS u
            ON u.user_id = s.user_user_id
        INNER JOIN attorney AS a
            ON a.attorney_id = s.attorney_id
        WHERE s.scheduling_id = $scheduling_id
    ");
    
    if ($scheduling && $scheduling->num_rows > 0) {
        echo "<table class='table table-striped table-bordered'>";
        echo "<thead class='table-dark'>";
        echo "<tr>";
        echo "<th>Scheduling ID</th>";
        echo "<th>User ID</th>";
        echo "<th>Client</th>";
        echo "<th>Attorney ID</th>";
        echo "<th>Attorney</th>";
        echo "<th>Booking Date</th>";
        echo "<th>Status</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($sched = $scheduling->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($sched['scheduling_id']) . "</td>";
            echo "<td>" . htmlspecialchars($sched['user_id']) . "</td>";
            echo "<td>" . htmlspecialchars($sched['Client']) . "</td>";
            echo "<td>" . htmlspecialchars($sched['attorney_id']) . "</td>";
            echo "<td>" . htmlspecialchars($sched['Attorney']) . "</td>";
            echo "<td>" . htmlspecialchars($sched['booking_date']) . "</td>";
            echo "<td>" . htmlspecialchars($sched['status'] == 1 ? 'Active' : 'Inactive') . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<div class='alert alert-warning'>No scheduling data found for this ID.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Invalid request.</div>";
}
?>