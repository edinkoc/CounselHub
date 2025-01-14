<?php
include("connect.php");
$current_page = basename($_SERVER['PHP_SELF']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #000000;
            color: #ffffff;
            font-family: 'Roboto', sans-serif;
            margin-top: 100px;
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

        .container {
            padding: 2rem;
            background-color: #1c1c1c;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
            margin-left: 300px; 
            margin-top: 2rem;
            max-width: 1500px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .container {
                margin-left: 0;
                margin-top: 4rem;
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
            }
        }

        h1 {
            text-align: center;
            color: #00d1b2;
            margin-bottom: 2rem;
            font-size: 2rem;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead th {
            color: #00d1b2;
            text-transform: uppercase;
            font-weight: bold;
            padding: 12px;
            font-size: 0.9rem;
            border-bottom: 2px solid #00d1b2;
            text-align: center;
        }

        .table tbody td {
            background-color: #1f1f1f;
            padding: 12px;
            border-bottom: 1px solid #333;
            font-size: 0.9rem;
            color: #ffffff;
            text-align: center;
        }

        .table tbody tr:hover {
            background-color: #2c2c2c;
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
            background-color: #00a398;
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

    <button class="sidebar-toggle d-md-none" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar" id="sidebar">
        <div>
            <div class="sidebar-header">
                <img src="/frontend/assets/components/customer/home/about/Warner-Spencer.ico" 
                    alt="Law Firm Logo" 
                    class="circular-img" 
                    width="120">
            </div>
            <ul class="nav flex-column px-2">
                <li class="nav-item mb-2">
                    <a class="nav-link <?php if($current_page == 'dashboard.php') echo 'active neon-glow'; ?>" href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-2 icon-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?php if($current_page == 'clients.php') echo 'active neon-glow'; ?>" href="clients.php">
                        <i class="fas fa-user-friends me-2 icon-clients"></i> Clients
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?php if($current_page == 'attorneys.php') echo 'active neon-glow'; ?>" href="attorneys.php">
                        <i class="fa-solid fa-gavel me-2 icon-attorneys"></i> Attorneys
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?php if($current_page == 'appointments.php') echo 'active neon-glow'; ?>" href="appointments.php">
                        <i class="fas fa-calendar-check me-2 icon-appointments"></i> Appointments
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?php if($current_page == 'cases.php') echo 'active neon-glow'; ?>" href="cases.php">
                        <i class="fa-solid fa-briefcase me-2 icon-cases"></i> Cases
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?php if($current_page == 'documents.php') echo 'active neon-glow'; ?>" href="documents.php">
                        <i class="fas fa-file me-2 icon-documents"></i> Documents
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="logout px-2">
            <a class="nav-link neon-glow" href="/frontend/pages/signin/index.php">
                <i class="fas fa-sign-out-alt me-2 icon-logout"></i> Logout
            </a>
        </div>
    </div>

    <div class="container">
        <h1>Document and Case Details</h1>
        <?php
        $list = myQuery("SELECT d.document_id, c.case_id, c.case_details, c.current_stage, d.file_path
                        FROM document AS d
                        JOIN tblcase AS c
                        ON d.case_id = c.case_id");

        if ($list && $list->num_rows > 0) {
            echo "<div class='table-container'>";
            echo "<table class='table table-dark table-striped table-hover'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Document ID</th>";
            echo "<th>Case ID</th>";
            echo "<th>Case Details</th>";
            echo "<th>Current Stage</th>";
            echo "<th>File Path</th>";
            echo "<th>Download</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($row = $list->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['document_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['case_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['case_details']) . "</td>";
                echo "<td>" . htmlspecialchars($row['current_stage']) . "</td>";
                echo "<td>" . htmlspecialchars($row['file_path']) . "</td>";
                echo "<td>";
                echo "<a class='btn-download' href='" . htmlspecialchars($row['file_path']) . "' download><i class='fas fa-download me-1'></i>Download</a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p class='no-data'>No data found.</p>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleButton = document.querySelector('.sidebar-toggle');
            if (!sidebar.contains(event.target) && !toggleButton.contains(event.target) && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>