<?php
session_start();

require_once 'connect.php'; 

if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']); 
    $qry = "SELECT username FROM user WHERE user_id = $user_id";
    $result = myQuery($qry);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $user_name = htmlspecialchars($user['username']);
    } else {
        $user_name = 'Guest';
    }
} else {
    $user_name = 'Guest';
}

$list = myQuery("SELECT u.user_id, u.first_name, u.last_name, u.phone
                 FROM user AS u
                 INNER JOIN user_roles AS ur
                 ON u.user_id = ur.user_user_id
                 INNER JOIN user_role AS r
                 ON ur.roles_id = r.id
                 WHERE r.role = 'ROLE_CUSTOMER'");

if ($list && $list->num_rows > 0) {
    echo "<table border='1' cellspacing='0' cellpadding='10'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>User ID</th>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "<th>Phone</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = $list->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "No customers found.";
}

$list = myQuery("SELECT 
                    u.user_id, 
                    u.first_name, 
                    u.last_name, 
                    a.attorney_id, 
                    a.attorney_firstname, 
                    a.attorney_lastname
                 FROM scheduling AS s
                 INNER JOIN user AS u
                 ON u.user_id = s.user_user_id
                 INNER JOIN attorney AS a
                 ON a.attorney_id = s.attorney_id");

if ($list && $list->num_rows > 0) {
    echo "<table border='1' cellspacing='0' cellpadding='10'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>User ID</th>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "<th>Attorney ID</th>";
    echo "<th>Attorney First Name</th>";
    echo "<th>Attorney Last Name</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = $list->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['attorney_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['attorney_firstname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['attorney_lastname']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "No data found.";
}

$list = myQuery("SELECT 
                    u.user_id, 
                    u.first_name, 
                    u.last_name, 
                    c.case_id, 
                    c.case_details, 
                    c.current_stage, 
                    a.attorney_firstname, 
                    a.attorney_lastname
                 FROM user AS u
                 INNER JOIN tblcase AS c
                 ON u.user_id = c.user_user_id
                 INNER JOIN attorney AS a
                 ON c.attorney_id = a.attorney_id");

if ($list && $list->num_rows > 0) {
    echo "<table border='1' cellspacing='0' cellpadding='10'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>User ID</th>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "<th>Case ID</th>";
    echo "<th>Case Details</th>";
    echo "<th>Current Stage</th>";
    echo "<th>Attorney First Name</th>";
    echo "<th>Attorney Last Name</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = $list->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['case_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['case_details']) . "</td>";
        echo "<td>" . htmlspecialchars($row['current_stage']) . "</td>";
        echo "<td>" . htmlspecialchars($row['attorney_firstname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['attorney_lastname']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "No data found.";
}

?>
