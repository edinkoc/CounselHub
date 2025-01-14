<?php
include("connect.php");

$current_page = basename($_SERVER['PHP_SELF']);

$list = myQuery("
    SELECT 
        u.user_id, 
        u.first_name, 
        u.last_name, 
        c.case_id, 
        c.case_details, 
        c.current_stage, 
        a.attorney_firstname, 
        a.attorney_lastname
    FROM user AS u
    INNER JOIN tblcase AS c ON u.user_id = c.user_user_id
    INNER JOIN attorney AS a ON c.attorney_id = a.attorney_id
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Case Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        
        body {
            background-color: #000000;
            color: #ffffff;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
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

        .sidebar a:hover::after, .sidebar a.active::after {
            width: 100%;
        }

        .sidebar a.active, .sidebar a:hover {
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

        .widget::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(0, 209, 178, 0.1);
            border-radius: 50%;
            filter: blur(15px);
            z-index: -1;
        }

        .widget:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 25px rgba(0, 209, 178, 0.8);
        }

        .table-container {
            overflow-x: auto;
        }

        .table, 
        .table thead, 
        .table tbody, 
        .table tr, 
        .table td, 
        .table th {
            background-color: #2c2c2c !important; 
            color: #ffffff !important; 
        }

        .table thead {
            background-color: #343a40 !important; 
        }

        .table thead th {
            color: #00d1b2 !important; 
            text-transform: uppercase;
            font-weight: 600;
            padding: 1rem;
            font-size: 0.9rem;
            border-bottom: 2px solid #00d1b2;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .table tbody tr {
            transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
            cursor: pointer; 
        }

        .table tbody tr:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            background-color: #505050 !important; 
        }

        .table tbody td {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid #333;
            font-size: 0.9rem;
            color: #ffffff !important; 
        }

        .selected {
            background-color: #00d1b2 !important; 
            color: #000 !important;
        }

        .btn-download {
            background-color: #00d1b2; 
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.85rem;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease-in-out;
            text-decoration: none;
        }

        .btn-download:hover {
            background-color: #00a898; 
        }

        .no-data {
            text-align: center;
            font-size: 1rem;
            color: #ccc;
            padding: 1rem;
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

        .icon-attorneys {
            color: #b4654a;
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

    </style>
</head>
<body>
    <button class="sidebar-toggle d-block d-md-none">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar">
        <div>
            <div class="sidebar-header">
                <img src="/frontend/assets/components/customer/home/about/Warner-Spencer.ico" 
                    alt="Law Firm Logo" 
                    class="circular-img" 
                    width="120">
            </div>
            <ul class="nav flex-column px-2">
                <li class="nav-item mb-2">
                    <a class="nav-link <?php if($current_page == 'dashboard.php') echo 'active'; ?>" href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-2 icon-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?php if($current_page == 'clients.php') echo 'active'; ?>" href="clients.php">
                        <i class="fas fa-user-friends me-2 icon-clients"></i> Clients
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?php if($current_page == 'attorneys.php') echo 'active'; ?>" href="attorneys.php">
                        <i class="fa-solid fa-gavel me-2 icon-attorneys"></i> Attorneys
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?php if($current_page == 'appointments.php') echo 'active'; ?>" href="appointments.php">
                        <i class="fas fa-calendar-check me-2 icon-appointments"></i> Appointments
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?php if($current_page == 'cases.php') echo 'active'; ?>" href="cases.php">
                        <i class="fa-solid fa-briefcase me-2 icon-cases"></i> Cases
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?php if($current_page == 'documents.php') echo 'active'; ?>" href="documents.php">
                        <i class="fas fa-file me-2 icon-documents"></i> Documents
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="logout px-2">
            <a class="nav-link" href="/frontend/pages/signin/index.php">
                <i class="fas fa-sign-out-alt me-2 icon-logout"></i> Logout
            </a>
        </div>
    </div>

    <div class="main-content">
        <h1>Case Details Dashboard</h1>
        <?php if ($list && $list->num_rows > 0): ?>
            <div class="widget">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Client Name</th>
                                <th>Case ID</th>
                                <th>Case Details</th>
                                <th>Current Stage</th>
                                <th>Attorney Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $list->fetch_assoc()): ?>
                                <?php
                                    $clientName = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
                                    $attorneyName = htmlspecialchars($row['attorney_firstname'] . ' ' . $row['attorney_lastname']);

                                    if (stripos($clientName, 'John') !== false) {
                                        $rowClass = 'highlight-john';
                                    } elseif (stripos($attorneyName, 'Smith') !== false) {
                                        $rowClass = 'highlight-smith';
                                    } else {
                                        $rowClass = '';
                                    }
                                ?>
                                <tr class="<?php echo $rowClass; ?>">
                                    <td data-label="User ID"><?php echo htmlspecialchars($row['user_id']); ?></td>
                                    <td data-label="Client Name"><?php echo $clientName; ?></td>
                                    <td data-label="Case ID"><?php echo htmlspecialchars($row['case_id']); ?></td>
                                    <td data-label="Case Details"><?php echo htmlspecialchars($row['case_details']); ?></td>
                                    <td data-label="Current Stage"><?php echo htmlspecialchars($row['current_stage']); ?></td>
                                    <td data-label="Attorney Name"><?php echo $attorneyName; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <p class="no-data">No data found.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.sidebar-toggle').on('click', function(){
                $('.sidebar').toggleClass('active');
            });

            $('.table tbody tr').on('click', function(){
                $('.table tbody tr').removeClass('selected');
                $(this).addClass('selected');
            });
        });
    </script>
</body>
</html>