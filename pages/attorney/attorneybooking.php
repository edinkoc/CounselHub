<?php

session_start();

require_once 'connect.php';

if (!isset($GLOBALS['DEBUG_MODE'])) {
    $GLOBALS['DEBUG_MODE'] = false; 
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /frontend/pages/signin/login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']); 

$qry = "SELECT attorney_firstname, attorney_lastname FROM attorney WHERE user_user_id = $user_id";
$result = myQuery($qry);
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $user_name = htmlspecialchars($user['attorney_firstname'] . ' ' . $user['attorney_lastname']);
} else {
    $user_name = 'Guest';
}

$appointmentsQuery = "
    SELECT 
        s.scheduling_id AS id,
        CONCAT(u.first_name, ' ', u.last_name) AS client_name,
        CONCAT(a.attorney_firstname, ' ', a.attorney_lastname) AS attorney_name,
        DATE(s.booking_date) AS date,
        TIME(s.booking_date) AS time
    FROM scheduling AS s
    JOIN user u ON s.user_user_id = u.user_id
    JOIN attorney AS a ON s.attorney_id = a.attorney_id
    WHERE a.user_user_id = $user_id
    ORDER BY s.booking_date DESC
";

$appointmentsResult = myQuery($appointmentsQuery);

if ($appointmentsResult) {
    $appointments = mysqli_fetch_all($appointmentsResult, MYSQLI_ASSOC);
} else {
    if ($GLOBALS['DEBUG_MODE']) {
        echo "Error fetching appointments: " . mysqli_error($GLOBALS['conn']);
    }
    $appointments = [];
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attorney Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
    <?php require_once "attorney_booking.css" ?>
    </style>
</head>
<body>
    
    <div class="sidebar">
        <div>
            <div class="sidebar-header">
                <img 
                    src="/frontend/assets/components/customer/home/about/Warner-Spencer.ico"
                    alt="Law Firm Logo"
                    class="circular-img" 
                    width="120"
                >
                <h5 class="mt-2">Welcome, <?php echo $user_name; ?>!</h5>
            </div>

            <ul class="nav flex-column px-2">

                <li class="nav-item mb-2">
                    <a class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>" 
                       href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-2 icon-dashboard"></i> 
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link <?= $current_page == 'attorneyclients.php' ? 'active' : '' ?>" 
                       href="attorneyclients.php">
                        <i class="fas fa-user-friends me-2 icon-clients"></i> 
                        Clients
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link <?= $current_page == 'attorneybooking.php' ? 'active' : '' ?>" 
                       href="attorneybooking.php">
                        <i class="fas fa-calendar-check me-2 icon-appointments"></i> 
                        Appointments
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link <?= $current_page == 'attorneycase.php' ? 'active' : '' ?>" 
                       href="attorneycase.php">
                        <i class="fa-solid fa-briefcase me-2 icon-cases"></i> 
                        Cases
                    </a>
                </li>
                
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $current_page == 'attorneydocument.php' ? 'active' : '' ?>"
                       href="attorneydocument.php">
                        <i class="fas fa-file me-2 icon-documents"></i> 
                        Documents
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="logout px-2">
            <a class="nav-link" href="/frontend/pages/signin/index.php">
                <i class="fas fa-sign-out-alt me-2 neon-glow icon-logout"></i> 
                Logout
            </a>
        </div>
    </div>

    <div class="main-content container-fluid">
        <h2 class="mb-4">My Appointments</h2>
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client Name</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($appointments)): ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?= htmlspecialchars($appointment['id']) ?></td>
                                <td><?= htmlspecialchars($appointment['client_name']) ?></td>
                                <td><?= htmlspecialchars($appointment['date']) ?></td>
                                <td><?= htmlspecialchars($appointment['time']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No appointments found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>