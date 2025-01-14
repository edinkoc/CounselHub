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

$recent_activities = [];
$qry = "
    SELECT u.user_id, u.first_name, u.last_name, u.phone, u.email, s.booking_date AS date
    FROM scheduling s
    JOIN user u ON s.user_user_id = u.user_id
    JOIN attorney AS a ON a.attorney_id = s.attorney_id
    WHERE a.user_user_id = $user_id
    ORDER BY s.booking_date DESC
";
$result = myQuery($qry);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $recent_activities[] = $row;
    }
} else {
    if ($GLOBALS['DEBUG_MODE']) {
        echo "Error executing query: " . mysqli_error($GLOBALS['db_connection']);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        <?php require_once "module_attorneyclients.css" ?>
    </style>
</head>
<body>
    <div class="sidebar">
        <div>
            <div class="sidebar-header text-center p-4">
                <img src="/frontend/assets/components/customer/home/about/Warner-Spencer.ico" 
                    alt="Law Firm Logo" 
                    class="circular-img mb-2" 
                    width="120">
                <h5 class="mt-1">Welcome, <?= $user_name ?>!</h5>
            </div>
            <ul class="nav flex-column px-2 mt-4">
                <li class="nav-item mb-2">
                    <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-2 icon-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="attorneyclients.php">
                        <i class="fas fa-user-friends me-2 icon-clients"></i> Clients
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="attorneybooking.php">
                        <i class="fas fa-calendar-check me-2 icon-appointments"></i> Appointments
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="attorneycase.php">
                        <i class="fas fa-briefcase me-2 icon-cases"></i> Cases
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="attorneydocument.php">
                        <i class="fas fa-file me-2 icon-documents"></i> Documents
                    </a>
                </li>
            </ul>
        </div>
        <div class="logout px-2">
            <a class="nav-link" href="/frontend/pages/signin/logout.php">
                <i class="fas fa-sign-out-alt me-2 icon-logout"></i> Logout
            </a>
        </div>
    </div>
    <div class="main-content">
        <header class="p-4">
            <h2>Clients Overview</h2>
        </header>
        <section class="p-4">
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Client ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Last Booking Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($recent_activities)): ?>
                            <?php foreach($recent_activities as $activity): ?>
                                <tr>
                                    <td><?= htmlspecialchars($activity['user_id']) ?></td>
                                    <td><?= htmlspecialchars($activity['first_name'] . ' ' . $activity['last_name']) ?></td>
                                    <td><?= htmlspecialchars($activity['phone']) ?></td>
                                    <td><?= htmlspecialchars($activity['email']) ?></td>
                                    <td><?= htmlspecialchars(date("F j, Y, g:i a", strtotime($activity['date']))) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No recent activities found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
