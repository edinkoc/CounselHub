<?php
include("connect.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attorneys</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --background-color: #000000; 
            --sidebar-bg: #1f1f1f;
            --sidebar-hover-bg: #343a40;
            --accent-color: #00d1b2;
            --text-color: #ffffff;
            --secondary-text-color: #b0b0b0;
            --border-color: #444444;
            --card-bg: #1f1f1f;
            --table-header-bg: #343a40; 
            --table-row-bg: #2c2c2c;
            --table-hover-bg: #505050; 
            --modal-overlay-bg: rgba(0, 0, 0, 0.7);
            --button-primary-bg: #00d1b2;
            --button-primary-hover-bg: #00a898;
            --button-secondary-bg: #6c757d;
            --button-secondary-hover-bg: #5a6268;
            --alert-success-bg: #00b894;
            --alert-danger-bg: #e84118;
            --alert-warning-bg: #ff9800; 
            --input-bg: #2c2c2c;
            --input-border: #444444;
            --input-placeholder: #b0b0b0;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition-speed: 0.3s;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            height: 100vh;
            width: 220px; 
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
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
            display: flex;
            align-items: center;
            padding: 0.6rem 1rem;
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
            position: relative;
            gap: 0.5rem; /* Space between icon and text */
        }

        .sidebar a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0%;
            height: 2px;
            background: var(--accent-color);
            transition: width 0.3s;
        }

        .sidebar a:hover::after, .sidebar a.active::after {
            width: 100%;
        }

        .sidebar a.active, .sidebar a:hover {
            background-color: var(--sidebar-hover-bg);
            color: var(--text-color);
        }

        .sidebar-header {
            text-align: center;
            padding: 1.5rem 0;
            border-bottom: 1px solid var(--sidebar-hover-bg);
        }

        .nav {
            margin-top: 1.5rem;
            display: flex;
            flex-direction: column;
        }

        .nav-item {
            margin-left: 0.5rem;
            margin-bottom: 0.5rem; 
        }

        .logout {
            margin-bottom: 2rem;
        }

        .main-content {
            margin-left: 220px; 
            padding: 2.5rem 3rem 3rem 3rem; 
            transition: margin-left var(--transition-speed) ease-in-out;
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
            }
            .sidebar-header {
                display: none;
            }
            .nav {
                display: flex;
                flex-direction: row;
                padding: 0;
            }
            .nav-item {
                margin: 0 0.5rem; 
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
        }

        .custom-card {
            background-color: var(--card-bg);
            border: 2px solid var(--accent-color);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 209, 178, 0.5);
            color: var(--text-color);
            transition: transform 0.3s, box-shadow 0.3s;
            padding: 1rem;
            margin-bottom: 2rem;
            height: 100%;
            max-width: auto;
        }

        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 30px rgba(0, 209, 178, 0.7);
        }

        .custom-card-header {
            background-color: var(--sidebar-bg);
            border-bottom: 2px solid var(--accent-color);
            color: var(--accent-color);
            font-weight: 500;
            padding: 0.75rem;
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .custom-card-body {
            color: var(--text-color);
        }

        .search-container {
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .search-container input {
            width: 100%;
            max-width: 400px;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 8px;
            background-color: var(--input-bg);
            color: var(--text-color);
            font-size: 1rem;
            transition: background-color var(--transition-speed), box-shadow var(--transition-speed);
        }

        .search-container input::placeholder {
            color: var(--input-placeholder);
        }

        .search-container input:focus {
            outline: none;
            background-color: var(--table-hover-bg);
            box-shadow: 0 0 5px var(--accent-color);
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            margin-bottom: 40px;
            font-size: 1rem;
            background-color: transparent;
            color: var(--text-color);
        }

        .table thead {
            background-color: var(--table-header-bg);
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead th {
            color: var(--text-color);
            padding: 1rem;
            text-align: center;
            font-weight: 600;
            position: sticky;
            top: 0;
            background-color: var(--table-header-bg);
            z-index: 1;
        }

        .table tbody tr {
            background-color: var(--table-row-bg);
            border-radius: 10px;
            box-shadow: var(--box-shadow);
            transition: transform var(--transition-speed), box-shadow var(--transition-speed);
        }

        .table tbody tr:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            background-color: var(--table-hover-bg);
        }

        .table tbody td {
            padding: 1rem;
            text-align: center;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            background-color: var(--button-primary-bg);
            color: var(--text-color);
            cursor: pointer;
            transition: background-color var(--transition-speed), transform var(--transition-speed);
            font-size: 0.9rem;
        }

        .action-btn:hover {
            background-color: var(--button-primary-hover-bg);
            transform: scale(1.05);
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--modal-overlay-bg);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }

        .modal {
            background-color: var(--card-bg);
            border: 2px solid var(--accent-color);
            border-radius: 12px;
            width: 90%;
            max-width: 1000px;
            padding: 1.5rem;
            position: relative;
            box-shadow: var(--box-shadow);
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            color: var(--text-color);
            font-size: 1.5rem;
            cursor: pointer;
            transition: color var(--transition-speed);
        }

        .close-modal:hover {
            color: var(--accent-color);
        }

        .modal-header {
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .modal-title {
            color: var(--accent-color);
            font-size: 1.5rem;
            margin: 0;
        }

        .modal-body {
            padding: 1rem 0;
        }

        .modal-footer {
            border-top: 2px solid var(--accent-color);
            padding-top: 0.5rem;
            text-align: right;
        }

        .btn-primary,
        .btn-secondary {
            display: inline-block;
            font-size: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color var(--transition-speed);
            border: none;
        }

        .btn-primary {
            background-color: var(--button-primary-bg);
            color: var(--text-color);
            margin-right: 0.5rem;
        }

        .btn-primary:hover {
            background-color: var(--button-primary-hover-bg);
        }

        .btn-secondary {
            background-color: var(--button-secondary-bg);
            color: var(--text-color);
        }

        .btn-secondary:hover {
            background-color: var(--button-secondary-hover-bg);
        }

        .alert-success,
        .alert-danger,
        .alert-warning {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            font-size: 1rem;
            text-align: center;
        }

        .alert-success {
            background-color: var(--alert-success-bg);
            color: var(--text-color);
        }

        .alert-danger {
            background-color: var(--alert-danger-bg);
            color: var(--text-color);
        }

        .alert-warning {
            background-color: var(--alert-warning-bg);
            color: var(--text-color);
        }

        .message {
            text-align: center;
            font-size: 1.1rem;
            color: var(--secondary-text-color);
            margin-bottom: 40px;
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

        .circular-img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 2px solid var(--accent-color);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 150px;
            }
        }

        @media (max-width: 576px) {
            .chart-container {
                height: 200px;
            }
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
    <div class="sidebar">
        <div>
            <div class="sidebar-header">
                <img src="/frontend/assets/components/customer/home/about/Warner-Spencer.ico" 
                    alt="Law Firm Logo" 
                    class="circular-img" 
                    width="120">
            </div>
            <ul class="nav flex-column px-2 mt-4">
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage == 'dashboard.php') ? 'active' : '' ?>" href="dashboard.php">
                        <i class="fas fa-tachometer-alt icon-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage == 'clients.php') ? 'active' : '' ?>" href="clients.php">
                        <i class="fas fa-user-friends icon-clients"></i> Clients
                    </a>
                </li>
                                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage == 'attorneys.php') ? 'active' : '' ?>" href="attorneys.php">
                        <i class="fa-solid fa-gavel me-2 icon-attorneys"></i> Attorneys
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage == 'appointments.php') ? 'active' : '' ?>" href="appointments.php">
                        <i class="fas fa-calendar-check me-2 icon-appointments"></i> Appointments
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage == 'cases.php') ? 'active' : '' ?>" href="cases.php">
                        <i class="fa-solid fa-briefcase icon-cases"></i> Cases
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage == 'documents.php') ? 'active' : '' ?>" href="documents.php">
                        <i class="fas fa-file icon-documents"></i> Documents
                    </a>
                </li>
            </ul>
        </div>
        <div class="logout px-2">
            <a class="nav-link" href="/frontend/pages/signin/index.php">
                <i class="fas fa-sign-out-alt icon-logout"></i> Logout
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="custom-card">
            <div class="custom-card-header">Attorney List</div>
            <div class="custom-card-body">
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Search by attorney name..." aria-label="Search by attorney name" />
                </div>
                <?php
                $list = myQuery("SELECT u.user_id, u.first_name, u.last_name, u.email, u.phone
                                 FROM user AS u
                                 INNER JOIN user_roles AS ur
                                 ON u.user_id = ur.user_user_id
                                 INNER JOIN user_role AS r
                                 ON ur.roles_id = r.id
                                 WHERE r.role = 'ROLE_ATTORNEY'");

                if ($list && $list->num_rows > 0) {
                    echo "<div class='table-container'>";
                    echo "<table class='table' id='attorneysTable'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Attorney ID</th>";
                    echo "<th>First Name</th>";
                    echo "<th>Last Name</th>";
                    echo "<th>Email</th>";
                    echo "<th>Phone</th>";
                    echo "<th>Action</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row = $list->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td data-label='Attorney ID'>" . htmlspecialchars($row['user_id']) . "</td>";
                        echo "<td data-label='First Name'>" . htmlspecialchars($row['first_name']) . "</td>";
                        echo "<td data-label='Last Name'>" . htmlspecialchars($row['last_name']) . "</td>";
                        echo "<td data-label='Email'>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td data-label='Phone'>" . htmlspecialchars($row['phone']) . "</td>";
                        echo "<td data-label='Action'><button class='action-btn btn-primary client-btn' data-attorney-id='" . htmlspecialchars($row['user_id']) . "'>View Clients</button></td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<div class='alert-danger'>No attorneys found.</div>";
                }
                ?>
            </div>
        </div>

        <div class="modal-overlay" id="clientsModal">
            <div class="modal">
                <button class="close-modal" id="closeClientsModal">&times;</button>
                <div class="modal-header">
                    <h2 class="modal-title">Clients of Attorney</h2>
                </div>
                <div class="modal-body" id="clientsModalBody">
                </div>
                <div class="modal-footer">
                    <button class="btn-secondary" id="closeClientsFooter">Close</button>
                </div>
            </div>
        </div>

        <div class="modal-overlay" id="caseModal">
            <div class="modal">
                <button class="close-modal" id="closeCaseModal">&times;</button>
                <div class="modal-header">
                    <h2 class="modal-title">Case Details</h2>
                </div>
                <div class="modal-body" id="caseModalBody">
                </div>
                <div class="modal-footer">
                    <button class="btn-secondary" id="closeCaseFooter">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function debounce(func, delay) {
            let debounceTimer;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => func.apply(context, args), delay);
            };
        }

        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        document.getElementById('closeClientsModal').addEventListener('click', function() {
            closeModal('clientsModal');
        });

        document.getElementById('closeClientsFooter').addEventListener('click', function() {
            closeModal('clientsModal');
        });

        document.getElementById('closeCaseModal').addEventListener('click', function() {
            closeModal('caseModal');
        });

        document.getElementById('closeCaseFooter').addEventListener('click', function() {
            closeModal('caseModal');
        });

        document.querySelector('.main-content').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('client-btn')) {
                var attorneyId = e.target.getAttribute('data-attorney-id');
                fetchClients(attorneyId);
            }
        });

        function fetchClients(attorneyId) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_clients.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            if (response.data.length > 0) {
                                var html = "<div class='table-container'><table class='table'>";
                                html += "<thead><tr><th>Client ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Action</th></tr></thead><tbody>";
                                response.data.forEach(function(client) {
                                    html += "<tr>";
                                    html += "<td data-label='Client ID'>" + escapeHtml(client.client_id) + "</td>";
                                    html += "<td data-label='First Name'>" + escapeHtml(client.first_name) + "</td>";
                                    html += "<td data-label='Last Name'>" + escapeHtml(client.last_name) + "</td>";
                                    html += "<td data-label='Email'>" + escapeHtml(client.email) + "</td>";
                                    html += "<td data-label='Phone'>" + escapeHtml(client.phone) + "</td>";
                                    html += "<td data-label='Action'><button class='action-btn btn-primary case-btn' data-client-id='" + escapeHtml(client.client_id) + "'>View Case Details</button></td>";
                                    html += "</tr>";
                                });
                                html += "</tbody></table></div>";
                                document.getElementById('clientsModalBody').innerHTML = html;
                                openModal('clientsModal');
                            } else {
                                document.getElementById('clientsModalBody').innerHTML = "<div class='alert-warning'>No clients found for this attorney.</div>";
                                openModal('clientsModal');
                            }
                        } else {
                            if (response.message.toLowerCase().includes('no clients found')) {
                                document.getElementById('clientsModalBody').innerHTML = "<div class='alert-warning'>" + escapeHtml(response.message) + "</div>";
                            } else {
                                document.getElementById('clientsModalBody').innerHTML = "<div class='alert-danger'>" + escapeHtml(response.message) + "</div>";
                            }
                            openModal('clientsModal');
                        }
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        document.getElementById('clientsModalBody').innerHTML = "<div class='alert-danger'>An unexpected error occurred.</div>";
                        openModal('clientsModal');
                    }
                }
            };
            xhr.send('attorney_id=' + encodeURIComponent(attorneyId));
        }

        document.getElementById('clientsModalBody').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('case-btn')) {
                var clientId = e.target.getAttribute('data-client-id');
                fetchCases(clientId);
            }
        });

        function fetchCases(clientId) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_cases.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            if (response.data.length > 0) {
                                var html = "<div class='table-container'><table class='table'>";
                                html += "<thead><tr><th>Case ID</th><th>Case Details</th><th>Current Stage</th></tr></thead><tbody>";
                                response.data.forEach(function(caseDetail) {
                                    html += "<tr>";
                                    html += "<td data-label='Case ID'>" + escapeHtml(tblcase.case_id) + "</td>";
                                    html += "<td data-label='Case Details'>" + escapeHtml(tblcase.case_details) + "</td>";
                                    html += "<td data-label='Current Stage'>" + escapeHtml(tblcase.current_stage) + "</td>";
                                    html += "</tr>";
                                });
                                html += "</tbody></table></div>";
                                document.getElementById('caseModalBody').innerHTML = html;
                                openModal('caseModal');
                            } else {
                                document.getElementById('caseModalBody').innerHTML = "<div class='alert-warning'>No cases found for this client.</div>";
                                openModal('caseModal');
                            }
                        } else {
                            if (response.message.toLowerCase().includes('no cases found')) {
                                document.getElementById('caseModalBody').innerHTML = "<div class='alert-warning'>" + escapeHtml(response.message) + "</div>";
                            } else {
                                document.getElementById('caseModalBody').innerHTML = "<div class='alert-danger'>" + escapeHtml(response.message) + "</div>";
                            }
                            openModal('caseModal');
                        }
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        document.getElementById('caseModalBody').innerHTML = "<div class='alert-danger'>An unexpected error occurred.</div>";
                        openModal('caseModal');
                    }
                }
            };
            xhr.send('client_id=' + encodeURIComponent(clientId));
        }

        function escapeHtml(text) {
            if (typeof text !== 'string') {
                return text;
            }
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        document.getElementById('searchInput').addEventListener('input', debounce(function() {
            var filter = this.value.toLowerCase();
            var table = document.getElementById('attorneysTable');
            var trs = table.getElementsByTagName('tr');

            for (var i = 1; i < trs.length; i++) {
                var tds = trs[i].getElementsByTagName('td');
                var firstName = tds[1].textContent.toLowerCase();
                var lastName = tds[2].textContent.toLowerCase();
                if (firstName.indexOf(filter) > -1 || lastName.indexOf(filter) > -1) {
                    trs[i].style.display = '';
                } else {
                    trs[i].style.display = 'none';
                }
            }
        }, 300));
    </script>
</body>
</html>