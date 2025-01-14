<?php
session_start();

// Include your existing database connection
require_once 'connect.php'; // Ensure the path is correct

// Set the user name in the session
$_SESSION['user_name'] = 'Admin';
$user_name = $_SESSION['user_name'] ?? 'Guest';

// Set the user name in session (assuming user is logged in)
/*if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']); // Sanitize input
    $qry = "SELECT first_name, last_name FROM user WHERE user_id = $user_id";
    $result = myQuery($qry);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $user_name = htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
    } else {
        $user_name = 'Guest';
    }
} else {
    $user_name = 'Guest';
}*/

// Fetch Clients with ROLE_CUSTOMER
$sql = "
    SELECT 
        u.user_id, 
        CONCAT(u.first_name, ' ', u.last_name) AS name, 
        u.email, 
        u.phone, 
        a.attorney_id,
        CONCAT(a.attorney_firstname, ' ', a.attorney_lastname) AS attorney_name
    FROM 
        user u
    INNER JOIN 
        user_roles ur ON u.user_id = ur.user_user_id
    INNER JOIN 
        user_role r ON ur.roles_id = r.id
    LEFT JOIN 
        tblcase c ON u.user_id = c.user_user_id
    LEFT JOIN 
        attorney a ON c.attorney_id = a.attorney_id
    WHERE 
        r.role = 'ROLE_CUSTOMER'
    GROUP BY 
        u.user_id
    ORDER BY 
        u.user_id ASC
";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$clients = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Chart.js Library (Removed if not used elsewhere) -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <!-- Custom CSS -->
    <link rel="stylesheet" href="clients.css">
    <style>
        .table thead th {
            color: #000000; /* Header text color changed for better visibility */
        }

        .table tbody td {
            color: #000000; /* Body text color changed for better visibility */
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <div class="sidebar-header text-center p-4">
                <img src="/frontend/assets/components/customer/home/about/Warner-Spencer.ico" 
                    alt="Law Firm Logo" 
                    class="circular-img mb-2" 
                    width="120">
                <h5 class="mt-2">Welcome, Admin!</h5>
            </div>
            <ul class="nav flex-column px-2 mt-4">
                <li class="nav-item mb-2">
                    <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="clients.php">
                        <i class="fas fa-user-friends me-2"></i> Clients
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="attorneys.php">
                        <i class="fa-solid fa-gavel me-2"></i> Attorneys
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="appointments.php">
                        <i class="fas fa-calendar-check me-2"></i> Appointments
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="cases.php">
                        <i class="fa-solid fa-briefcase me-2"></i> Cases
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="documents.php">
                        <i class="fas fa-file me-2"></i> Documents
                    </a>
                </li>
            </ul>
        </div>
        <!-- Logout Link -->
        <div class="logout px-2">
            <a class="nav-link" href="/frontend/pages/signin/index.php">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content container-fluid">
        <h2 class="mb-4">Clients</h2>

        <!-- Display Success or Error Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Clients Table -->
        <div class="card mb-4 custom-card">
            <div class="card-header custom-card-header">
                <h5 class="mb-0">Clients List</h5>
            </div>
            <div class="card-body custom-card-body">
                <!-- Search Bar -->
                <div class="mb-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search clients by name...">
                </div>
                <!-- Clients Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="clientsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Attorney</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td><?= htmlspecialchars($client['user_id']) ?></td>
                                    <td><?= htmlspecialchars($client['name']) ?></td>
                                    <td><?= htmlspecialchars($client['email']) ?></td>
                                    <td><?= htmlspecialchars($client['phone']) ?></td>
                                    <td><?= htmlspecialchars($client['attorney_name'] ?? 'Unassigned') ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary view-details-btn" 
                                                data-id="<?= htmlspecialchars($client['user_id']) ?>" 
                                                data-name="<?= htmlspecialchars($client['name']) ?>" 
                                                data-email="<?= htmlspecialchars($client['email']) ?>" 
                                                data-phone="<?= htmlspecialchars($client['phone']) ?>" 
                                                data-attorney="<?= htmlspecialchars($client['attorney_name'] ?? 'Unassigned') ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($clients)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">No clients found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Client Details Modal -->
        <div class="modal fade" id="clientDetailsModal" tabindex="-1" aria-labelledby="clientDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Client Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 id="clientName"></h5>
                        <p><strong>Email:</strong> <span id="clientEmail"></span></p>
                        <p><strong>Phone:</strong> <span id="clientPhone"></span></p>
                        <p><strong>Attorney:</strong> <span id="clientAttorney"></span></p>
                        <hr>
                        <h6>Cases</h6>
                        <div id="clientCases">
                            <!-- Cases will be loaded here via JavaScript -->
                            <p>Loading cases...</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (Includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (Optional, for Interactions) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom JS -->
    <script>
        $(document).ready(function() {
            // Search functionality: filter clients based on their names
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#clientsTable tbody tr').filter(function() {
                    // Toggle based on whether the client's name includes the search term
                    $(this).toggle($(this).find('td:nth-child(2)').text().toLowerCase().indexOf(value) > -1)
                });
            });

            // View Details Button Click
            $('.view-details-btn').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var email = $(this).data('email');
                var phone = $(this).data('phone');
                var attorney = $(this).data('attorney');

                $('#clientName').text(name);
                $('#clientEmail').text(email);
                $('#clientPhone').text(phone);
                $('#clientAttorney').text(attorney);

                // Fetch cases via AJAX
                /*$.ajax({
                    url: 'fetch_cases.php', // Ensure this path is correct
                    method: 'POST',
                    data: { user_id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            var cases = response.data;
                            if (cases.length > 0) {
                                var casesHtml = '<table class="table table-sm table-striped">';
                                casesHtml += '<thead><tr><th>ID</th><th>Details</th><th>Status</th></tr></thead><tbody>';
                                cases.forEach(function(caseItem) {
                                    casesHtml += `<tr>
                                                    <td>${caseItem.case_id}</td>
                                                    <td>${caseItem.case_details}</td>
                                                    <td>${caseItem.current_stage}</td>
                                                  </tr>`;
                                });
                                casesHtml += '</tbody></table>';
                                $('#clientCases').html(casesHtml);
                            } else {
                                $('#clientCases').html('<p>No cases found for this client.</p>');
                            }
                        } else {
                            $('#clientCases').html('<p>Error fetching cases.</p>');
                        }
                    },
                    error: function() {
                        $('#clientCases').html('<p>Error fetching cases.</p>');
                    }
                });

                // Show the modal
                var clientDetailsModal = new bootstrap.Modal(document.getElementById('clientDetailsModal'), {
                    keyboard: false
                });
                clientDetailsModal.show();*/
            });
        });
    </script>
</body>
</html>
