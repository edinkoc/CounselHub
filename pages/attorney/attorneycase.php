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
    SELECT c.case_id, c.case_details, c.current_stage 
    FROM tblcase AS c
    JOIN attorney AS a
    ON a.attorney_id = c.attorney_id
    WHERE a.user_user_id = $user_id
    ORDER BY c.case_id DESC
    LIMIT 10
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

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Attorney Dashboard</title>
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
        rel="stylesheet">
    <link 
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" 
        rel="stylesheet">
    <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #000000; 
            color: #ffffff;
            font-family: 'Roboto', sans-serif;
        }

        .sidebar {
            height: 100vh;
            width: 220px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #1f1f1f;
            padding-top: 2.5rem;
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar a {
            color: #b0b0b0;
            display: block;
            padding: 0.6rem 1rem;
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
            position: relative;
        }

        .sidebar a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0%;
            height: 2px;
            background: #00d1b2;
            transition: width 0.3s;
        }

        .sidebar a:hover::after,
        .sidebar a.active::after {
            width: 100%;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background-color: #343a40;
            color: #ffffff;
        }

        .sidebar-header {
            text-align: center;
            padding: 1.5rem 0;
            border-bottom: 1px solid #343a40;
        }

        .nav {
            margin-top: 1.5rem;
        }

        .logout {
            margin-bottom: 2rem;
        }

        .main-content {
            margin-left: 220px; 
            padding: 4rem 3rem 3rem 3rem;
            margin-top: 2.5rem;
            transition: margin-left 0.3s ease-in-out;
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                width: 100%;
                height: auto;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                padding: 1rem;
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .sidebar-header {
                display: none;
            }
            .nav {
                display: flex;
                flex-direction: row;
                padding: 0;
            }
            .nav-link {
                padding: 0.5rem;
            }
            .logout {
                display: none;
            }
            .main-content {
                margin-left: 0;
                padding: 2rem 1.5rem;
            }
            .sidebar-toggle {
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1100;
                background-color: #1f1f1f;
                border: none;
                color: #fff;
                padding: 0.5rem 1rem;
                border-radius: 4px;
                cursor: pointer;
            }
        }

        h1 {
            text-align: center;
            color: #00d1b2; 
            margin-bottom: 2rem;
            font-size: 2rem;
        }
        h2 {
            margin-bottom: 1.5rem;
        }

        .widget {
            background-color: #2c2c2c; 
            border: 2px solid #00d1b2;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 209, 178, 0.5);
            padding: 1.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .widget:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 25px rgba(0, 209, 178, 0.8);
        }

        .table-container {
            overflow-x: auto;
            margin-bottom: 2rem;
        }

        .activity-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .activity-table thead {
            background-color: #343a40;
        }

        .activity-table th {
            color: #00d1b2;
            text-transform: uppercase;
            font-weight: 600;
            padding: 1rem;
            font-size: 0.9rem;
            text-align: center;
            border-bottom: 2px solid #00d1b2;
        }

        .activity-table tbody tr {
            background-color: #2a2a2a; 
            transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
            cursor: pointer; 
        }
        .activity-table tbody tr:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            background-color: #505050 !important;
        }

        .activity-table td {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid #333;
            font-size: 0.9rem;
            color: #ffffff;
        }

        .no-data {
            text-align: center;
            font-size: 1rem;
            color: #ccc;
            padding: 1rem;
        }

        .circular-img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 2px solid #00d1b2;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s;
        }
        .circular-img:hover {
            transform: scale(1.05);
        }

        .icon-dashboard {
            color: #a67c52;
        }
        .icon-clients {
            color: #6d9886;
        }
        .icon-appointments {
            color: #d3a588;
        }
        .icon-cases {
            color: #c5b358;
        }
        .icon-documents {
            color: #748cab;
        }
        .icon-logout {
            color: #8b5e3c;
        }

        .btn {
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.85rem;
            transition: background-color 0.3s, color 0.3s;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .view-btn {
            background-color: #00d1b2;
            color: #fff;
            margin-right: 0.5rem;
        }
        .edit-btn {
            background-color: #343a40;
            color: #fff;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background-color: #343a40;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background-color: #495057;
        }
    </style>
</head>
<body>

    <button class="sidebar-toggle d-lg-none" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar" id="sidebar">
        <div>
            <div class="sidebar-header">
                <img 
                    src="/frontend/assets/components/customer/home/about/Warner-Spencer.ico" 
                    alt="Law Firm Logo" 
                    class="circular-img" 
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
                <i class="fas fa-sign-out-alt me-2 icon-logout"></i> 
                Logout
            </a>
        </div>
    </div>

    <div class="main-content">
        <section class="recent-activities">
            <h2>Recent Activities</h2>
            <div class="table-container">
                <?php if (!empty($recent_activities)): ?>
                    <table class="activity-table">
                        <thead>
                            <tr>
                                <th>Case ID</th>
                                <th>Case Details</th>
                                <th>Current Stage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_activities as $activity): ?>
                                <tr>
                                    <td data-label="Case ID"><?php echo htmlspecialchars($activity['case_id']); ?></td>
                                    <td data-label="Case Details"><?php echo htmlspecialchars($activity['case_details']); ?></td>
                                    <td data-label="Current Stage"><?php echo htmlspecialchars($activity['current_stage']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-data">No recent activities found.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</body>
</html>