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

$qry = "
    SELECT COUNT(DISTINCT u.user_id) AS total_clients
    FROM user u
    JOIN user_roles ur ON u.user_id = ur.user_user_id
    JOIN user_role r ON ur.roles_id = r.id
    WHERE r.role = 'ROLE_CUSTOMER'
";
$result = myQuery($qry);
$total_clients = ($result && mysqli_num_rows($result) > 0) ? intval(mysqli_fetch_assoc($result)['total_clients']) : 0;

$today_date = date('Y-m-d');
$qry = "
    SELECT COUNT(*) AS total_appointments_today
    FROM scheduling
    WHERE DATE(booking_date) = '$today_date' AND status = b'1'
";
$result = myQuery($qry);
$total_appointments_today = ($result && mysqli_num_rows($result) > 0) ? intval(mysqli_fetch_assoc($result)['total_appointments_today']) : 0;

$qry = "SELECT COUNT(*) AS total_cases FROM tblcase";
$result = myQuery($qry);
$total_cases = ($result && mysqli_num_rows($result) > 0) ? intval(mysqli_fetch_assoc($result)['total_cases']) : 0;

$qry = "
    SELECT COUNT(*) AS active_cases
    FROM tblcase
    WHERE current_stage NOT IN ('Closed', 'Resolved')
";
$result = myQuery($qry);
$active_cases = ($result && mysqli_num_rows($result) > 0) ? intval(mysqli_fetch_assoc($result)['active_cases']) : 0;

$qry = "
    SELECT COUNT(*) AS closed_cases
    FROM tblcase
    WHERE current_stage IN ('Closed', 'Resolved')
";
$result = myQuery($qry);
$closed_cases = ($result && mysqli_num_rows($result) > 0) ? intval(mysqli_fetch_assoc($result)['closed_cases']) : 0;

$recent_activities = [];
$qry = "
    SELECT u.first_name, u.last_name, 'Appointment' AS activity_type, 
           CONCAT('Scheduled appointment with Attorney ID ', s.attorney_id) AS description, 
           s.booking_date AS date
    FROM scheduling s
    JOIN user u ON s.user_user_id = u.user_id
    ORDER BY s.booking_date DESC
    LIMIT 10
";
$result = myQuery($qry);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $recent_activities[] = $row;
    }
}

$appointments_dates = [];
$appointments_counts = [];

$appointments_dates = [];
$appointments_counts = [];
$weekend_flags = []; 

for ($i = 1; $i <= 7; $i++) {
    $date = date('Y-m-d', strtotime("+$i days")); 
    $appointments_dates[] = date('d-m', strtotime($date)); 

    $day_of_week = date('N', strtotime($date)); 
    $weekend_flags[] = ($day_of_week == 6 || $day_of_week == 7); 

    $start_of_day = "$date 00:00:00";
    $end_of_day = "$date 23:59:59";

    $qry = "
        SELECT COUNT(*) AS count
        FROM scheduling
        WHERE booking_date >= '$start_of_day' AND booking_date <= '$end_of_day'
          AND status = '1'
    ";

    $result = myQuery($qry);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $appointments_counts[] = intval($row['count']); 
    } else {
        $appointments_counts[] = 0; 
    }
}

$cases_status_labels = [];
$cases_status_counts = [];
$qry = "
    SELECT current_stage, COUNT(*) AS count
    FROM tblcase
    GROUP BY current_stage
";
$result = myQuery($qry);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cases_status_labels[] = $row['current_stage'];
        $cases_status_counts[] = intval($row['count']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="module_dashboard.css" rel="stylesheet">
</head>
<body>

    <div class="sidebar">
        <div>
            <div class="sidebar-header">
                <img src="/frontend/assets/components/customer/home/about/Warner-Spencer.ico" 
                    alt="Law Firm Logo" 
                    class="circular-img" 
                    width="120">
                <h5 class="mt-2">Welcome, <?php echo $user_name; ?>!</h5>
            </div>
            <ul class="nav flex-column px-2">
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-2 icon-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="clients.php">
                        <i class="fas fa-user-friends me-2 icon-clients"></i> Clients
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="attorneys.php">
                        <i class="fa-solid fa-gavel me-2 icon-attorneys"></i> Attorneys
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="appointments.php">
                        <i class="fas fa-calendar-check me-2 icon-appointments"></i> Appointments
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="cases.php">
                        <i class="fa-solid fa-briefcase me-2 icon-cases"></i> Cases
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="documents.php">
                        <i class="fas fa-file me-2 icon-documents"></i> Documents
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="logout px-2">
            <a class="nav-link" href="/frontend/pages/signin/index.php">
                <i class="fas fa-sign-out-alt me-2 neon-glow icon-logout"></i> Logout
            </a>
        </div>
    </div>

    <div class="main-content container-fluid">

        <div class="widgets-grid">

            <div class="widget widget-total-clients">
                <i class="fas fa-user-friends neon-glow"></i>
                <div>
                    <div class="widget-title">Total Clients</div>
                    <div class="widget-value"><?= htmlspecialchars($total_clients) ?></div>
                </div>
            </div>
            <div class="widget widget-todays-appointments">
                <i class="fas fa-calendar-check neon-glow"></i>
                <div>
                    <div class="widget-title">Today's Appointments</div>
                    <div class="widget-value"><?= htmlspecialchars($total_appointments_today) ?></div>
                </div>
            </div>
            <div class="widget widget-total-cases">
                <i class="fas fa-gavel neon-glow"></i>
                <div>
                    <div class="widget-title">Total Cases</div>
                    <div class="widget-value"><?= htmlspecialchars($total_cases) ?></div>
                </div>
            </div>
            <div class="widget widget-active-cases">
                <i class="fas fa-hourglass-half neon-glow"></i>
                <div>
                    <div class="widget-title">Active Cases</div>
                    <div class="widget-value"><?= htmlspecialchars($active_cases) ?></div>
                </div>
            </div>
            <div class="widget widget-new-cases">
                <i class="fas fa-briefcase neon-glow"></i>
                <div>
                    <div class="widget-title">New Cases</div>
                    <div class="widget-value">5</div>
                </div>
            </div>
            <div class="widget widget-closed-cases">
                <i class="fas fa-check-circle neon-glow"></i>
                <div>
                    <div class="widget-title">Closed Cases</div>
                    <div class="widget-value"><?= htmlspecialchars($closed_cases) ?></div>
                </div>
            </div>
        </div>

        <div class="charts-section">
            <div class="custom-card">
                <div class="custom-card-header">
                    Appointments in the Next 7 Days
                </div>
                <div class="custom-card-body">
                    <div class="chart-container">
                        <canvas id="appointmentsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="custom-card">
                <div class="custom-card-header">
                    Cases Status Distribution
                </div>
                <div class="custom-card-body">
                    <div class="chart-container">
                        <canvas id="casesChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="custom-card">
                <div class="custom-card-header">
                    Recent Activities
                </div>
                <div class="custom-card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Client Name</th>
                                    <th>Activity Type</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recent_activities)): ?>
                                    <?php foreach ($recent_activities as $activity): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($activity['first_name'] . ' ' . $activity['last_name']) ?></td>
                                            <td><?= htmlspecialchars($activity['activity_type']) ?></td>
                                            <td><?= htmlspecialchars($activity['description']) ?></td>
                                            <td><?= date('d-m-Y H:i', strtotime($activity['date'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No recent activities found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        const ctxAppointments = document.getElementById('appointmentsChart').getContext('2d');
        const weekendFlags = <?= json_encode($weekend_flags) ?>; 
        const appointmentsChart = new Chart(ctxAppointments, {
            type: 'line',
            data: {
                labels: <?= json_encode($appointments_dates) ?>, 
                datasets: [{
                    label: 'Appointments',
                    data: <?= json_encode($appointments_counts) ?>, 
                    backgroundColor: 'rgba(0, 123, 255, 0.2)', 
                    borderColor: '#007bff', 
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: weekendFlags.map(isWeekend => isWeekend ? 'red' : '#007bff'),
                    pointBorderColor: weekendFlags.map(isWeekend => isWeekend ? 'red' : '#ffffff'),
                    pointHoverBackgroundColor: weekendFlags.map(isWeekend => isWeekend ? '#ffffff' : 'red'),
                    pointHoverBorderColor: weekendFlags.map(isWeekend => isWeekend ? 'red' : '#007bff')
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false 
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#6c757d' 
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)' 
                        }
                    },
                    x: {
                        ticks: {
                            color: (ctx) => {
                                const index = ctx.index;
                                return weekendFlags[index] ? 'red' : '#6c757d';
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)' 
                        }
                    }
                }
            }
        });

        const ctxCases = document.getElementById('casesChart').getContext('2d');
        const casesChart = new Chart(ctxCases, {
            type: 'pie',
            data: {
                labels: <?= json_encode($cases_status_labels) ?>,
                datasets: [{
                    data: <?= json_encode($cases_status_counts) ?>,
                    backgroundColor: [
                        '#17a2b8',
                        '#28a745',
                        '#ffc107',
                        '#6f42c1',
                        '#dc3545'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>

