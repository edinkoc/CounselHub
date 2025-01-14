<?php
include("connect.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clients</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #000000;
            color: #ffffff;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            padding: 0.5rem;
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

        .sidebar .nav {
            padding-top: 1.5rem;
            list-style: none;    
            padding-left: 0;      
        }

        .nav-item {
            margin-bottom: 0.5rem; 
        }

        .nav-link {
            display: flex;
            align-items: center;
            color: #b0b0b0;
            padding: 0.6rem 1rem;
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
            position: relative;
            border-radius: 4px; 
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: #343a40;
            color: #ffffff;
        }

        .nav-link i {
            margin-right: 0.5rem;
        }

        .sidebar a {
            color: #b0b0b0;
            display: block;
            padding: 0.6rem 1rem;
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
            position: relative;
            border-radius: 4px; 
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
            padding: 1rem 0; 
            border-bottom: 1px solid #343a40;
        }

        .sidebar-header img {
            margin-bottom: 0.5rem; 
        }

        .sidebar-header h3 {
            margin: 0; 
            font-size: 1.1rem; 
            color: #ffffff; 
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

        .custom-card {
            background-color: #1f1f1f;
            border: 2px solid #00d1b2;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 209, 178, 0.5);
            color: #ffffff;
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
            background-color: #1f1f1f;
            border-bottom: 2px solid #00d1b2;
            color: #00d1b2;
            font-weight: 500;
            padding: 0.75rem;
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .custom-card-body {
            color: #ffffff;
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
            background-color: #2c2c2c;
            color: #ffffff;
            font-size: 1rem;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .search-container input::placeholder {
            color: #b0b0b0;
        }

        .search-container input:focus {
            outline: none;
            background-color: #505050;
            box-shadow: 0 0 5px #00d1b2;
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
            color: #ffffff;
        }

        .table thead {
            background-color: #343a40;
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead th {
            color: #ffffff;
            padding: 1rem;
            text-align: center;
            font-weight: 600;
            position: sticky;
            top: 0;
            background-color: #343a40;
            z-index: 1;
        }

        .table tbody tr {
            background-color: #2c2c2c;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .table tbody tr:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            background-color: #505050;
        }

        .table tbody td {
            padding: 1rem;
            text-align: center;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            background-color: #00d1b2;
            color: #ffffff;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            font-size: 0.9rem;
        }

        .action-btn:hover {
            background-color: #00a898;
            transform: scale(1.05);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }

        .modal {
            background-color: #1f1f1f;
            border: 2px solid #00d1b2;
            border-radius: 12px;
            width: 90%;
            max-width: 1000px;
            padding: 1.5rem;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            color: #ffffff;
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close-modal:hover {
            color: #00d1b2;
        }

        .modal-header {
            border-bottom: 2px solid #00d1b2;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .modal-title {
            color: #00d1b2;
            font-size: 1.5rem;
            margin: 0;
        }

        .modal-body {
            padding: 1rem 0;
        }

        .modal-footer {
            border-top: 2px solid #00d1b2;
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
            transition: background-color 0.3s;
            border: none;
        }

        .btn-primary {
            background-color: #00d1b2;
            color: #ffffff;
            margin-right: 0.5rem;
        }

        .btn-primary:hover {
            background-color: #00a898;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #ffffff;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
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
            background-color: #00b894;
            color: #ffffff;
        }

        .alert-danger {
            background-color: #e84118;
            color: #ffffff;
        }

        .alert-warning {
            background-color: #ff9800;
            color: #ffffff;
        }

        .message {
            text-align: center;
            font-size: 1.1rem;
            color: #b0b0b0;
            margin-bottom: 40px;
        }

        /* Icon Colors */
        .icon-dashboard {
            color: #a67c52;
            margin-right: 0.5rem;
        }

        .icon-clients {
            color: #6d9886;
            margin-right: 0.5rem;
        }

        .icon-attorneys {
            color: #b4654a;
            margin-right: 0.5rem;
        }

        .icon-appointments {
            color: #d3a588;
            margin-right: 0.5rem;
        }

        .icon-cases {
            color: #c5b358;
            margin-right: 0.5rem;
        }

        .icon-documents {
            color: #748cab;
            margin-right: 0.5rem;
        }

        .icon-logout {
            color: #8b5e3c;
            margin-right: 0.5rem;
        }

        .circular-img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 2px solid #00d1b2;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 150px;
            }
            .sidebar {
                width: 180px;
            }
            .main-content {
                margin-left: 180px;
            }
        }

        @media (max-width: 576px) {
            .chart-container {
                height: 200px;
            }
            .sidebar {
                width: 160px;
            }
            .main-content {
                margin-left: 160px;
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
                        <i class="fa-solid fa-gavel icon-attorneys"></i> Attorneys
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage == 'appointments.php') ? 'active' : '' ?>" href="appointments.php">
                        <i class="fas fa-calendar-check icon-appointments"></i> Appointments
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
            <div class="custom-card-header">Client List</div>
            <div class="custom-card-body">
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Search by client name..." aria-label="Search by client name" />
                </div>
                <?php
                $list = myQuery("SELECT u.user_id, u.first_name, u.last_name, u.email, u.phone
                                 FROM user AS u
                                 INNER JOIN user_roles AS ur
                                 ON u.user_id = ur.user_user_id
                                 INNER JOIN user_role AS r
                                 ON ur.roles_id = r.id
                                 WHERE r.role = 'ROLE_CUSTOMER'");

                if ($list && $list->num_rows > 0) {
                    echo "<div class='table-container'>";
                    echo "<table class='table' id='clientsTable'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>User ID</th>";
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
                        echo "<td data-label='User ID'>" . htmlspecialchars($row['user_id']) . "</td>";
                        echo "<td data-label='First Name'>" . htmlspecialchars($row['first_name']) . "</td>";
                        echo "<td data-label='Last Name'>" . htmlspecialchars($row['last_name']) . "</td>";
                        echo "<td data-label='Email'>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td data-label='Phone'>" . htmlspecialchars($row['phone']) . "</td>";
                        echo "<td data-label='Action'><button class='action-btn' data-user-id='" . htmlspecialchars($row['user_id']) . "'>View Attorney Details</button></td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<div class='alert-danger'>No clients found.</div>";
                }
                ?>
            </div>
        </div>

        <div class="modal-overlay" id="attorneyModal">
            <div class="modal">
                <button class="close-modal" id="closeAttorneyModal">&times;</button>
                <div class="modal-header">
                    <h2 class="modal-title">Attorney Details</h2>
                </div>
                <div class="modal-body" id="attorneyModalBody">
                    <!-- Attorney details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button class="btn-secondary" id="closeAttorneyFooter">Close</button>
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

        document.getElementById('closeAttorneyModal').addEventListener('click', function() {
            closeModal('attorneyModal');
        });

        document.getElementById('closeAttorneyFooter').addEventListener('click', function() {
            closeModal('attorneyModal');
        });

        document.getElementById('closeCaseModal').addEventListener('click', function() {
            closeModal('caseModal');
        });

        document.getElementById('closeCaseFooter').addEventListener('click', function() {
            closeModal('caseModal');
        });

        document.querySelector('.main-content').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('action-btn')) {
                var userId = e.target.getAttribute('data-user-id');
                fetchAttorneys(userId);
            }
        });

        function fetchAttorneys(userId) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_attorneys.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            if (response.data.length > 0) {
                                var html = "<div class='table-container'><table class='table'>";
                                html += "<thead><tr><th>Attorney ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Action</th></tr></thead><tbody>";
                                response.data.forEach(function(attorney) {
                                    html += "<tr>";
                                    html += "<td data-label='Attorney ID'>" + escapeHtml(attorney.attorney_id) + "</td>";
                                    html += "<td data-label='First Name'>" + escapeHtml(attorney.attorney_firstname) + "</td>";
                                    html += "<td data-label='Last Name'>" + escapeHtml(attorney.attorney_lastname) + "</td>";
                                    html += "<td data-label='Email'>" + escapeHtml(attorney.email) + "</td>";
                                    html += "<td data-label='Phone'>" + escapeHtml(attorney.phone) + "</td>";
                                    html += "<td data-label='Action'><button class='action-btn btn-primary case-btn' data-user-id='" + escapeHtml(userId) + "'>View Case Details</button></td>";
                                    html += "</tr>";
                                });
                                html += "</tbody></table></div>";
                                document.getElementById('attorneyModalBody').innerHTML = html;
                                openModal('attorneyModal');
                            } else {
                                document.getElementById('attorneyModalBody').innerHTML = "<div class='alert-warning'>Attorney not found.</div>";
                                openModal('attorneyModal');
                            }
                        } else {
                            if (response.message.toLowerCase().includes('attorney not found')) {
                                document.getElementById('attorneyModalBody').innerHTML = "<div class='alert-warning'>" + escapeHtml(response.message) + "</div>";
                            } else {
                                document.getElementById('attorneyModalBody').innerHTML = "<div class='alert-danger'>" + escapeHtml(response.message) + "</div>";
                            }
                            openModal('attorneyModal');
                        }
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        document.getElementById('attorneyModalBody').innerHTML = "<div class='alert-danger'>An unexpected error occurred.</div>";
                        openModal('attorneyModal');
                    }
                }
            };
            xhr.send('user_id=' + encodeURIComponent(userId));
        }

        document.getElementById('attorneyModalBody').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('case-btn')) {
                var userId = e.target.getAttribute('data-user-id');
                fetchCases(userId);
            }
        });

        function fetchCases(userId) {
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
                                    html += "<td data-label='Case ID'>" + escapeHtml(caseDetail.case_id) + "</td>";
                                    html += "<td data-label='Case Details'>" + escapeHtml(caseDetail.case_details) + "</td>";
                                    html += "<td data-label='Current Stage'>" + escapeHtml(caseDetail.current_stage) + "</td>";
                                    html += "</tr>";
                                });
                                html += "</tbody></table></div>";
                                document.getElementById('caseModalBody').innerHTML = html;
                                openModal('caseModal');
                            } else {
                                document.getElementById('caseModalBody').innerHTML = "<div class='alert-warning'>Case not found.</div>";
                                openModal('caseModal');
                            }
                        } else {
                            if (response.message.toLowerCase().includes('case not found')) {
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
            xhr.send('user_id=' + encodeURIComponent(userId));
        }

        function escapeHtml(text) {
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
            var table = document.getElementById('clientsTable');
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