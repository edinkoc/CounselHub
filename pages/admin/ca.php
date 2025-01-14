<?php
session_start();
require 'connect.php';

$attorneys = [
    [
        'id' => 1,
        'name' => 'Alice Johnson',
        'email' => 'alice.johnson@lawfirm.com',
        'phone' => '555-1001',
        'region' => 'North',
        'sex' => 'Female',
        'cases' => [
            ['id' => 101, 'title' => 'Case A', 'status' => 'Open', 'created_at' => '2023-10-01'],
            ['id' => 102, 'title' => 'Case B', 'status' => 'In Progress', 'created_at' => '2023-10-05'],
        ],
    ],
    [
        'id' => 2,
        'name' => 'Bob Smith',
        'email' => 'bob.smith@lawfirm.com',
        'phone' => '555-1002',
        'region' => 'South',
        'sex' => 'Male',
        'cases' => [
            ['id' => 201, 'title' => 'Case C', 'status' => 'Closed', 'created_at' => '2023-09-15'],
        ],
    ],
];

$clients = [
    [
        'id' => 1,
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'phone' => '555-0001',
        'region' => 'North',
        'attorney' => 'Alice Johnson',
        'sex' => 'Male',
        'cases' => [
            ['id' => 101, 'title' => 'Case A', 'status' => 'Open', 'created_at' => '2023-10-01'],
            ['id' => 102, 'title' => 'Case B', 'status' => 'In Progress', 'created_at' => '2023-10-05'],
        ],
    ],
    [
        'id' => 2,
        'name' => 'Jane Smith',
        'email' => 'jane.smith@example.com',
        'phone' => '555-0002',
        'region' => 'South',
        'attorney' => 'Bob Smith',
        'sex' => 'Female',
        'cases' => [
            ['id' => 201, 'title' => 'Case C', 'status' => 'Closed', 'created_at' => '2023-09-15'],
        ],
    ],
    [
        'id' => 3,
        'name' => 'Mike Brown',
        'email' => 'mike.brown@example.com',
        'phone' => '555-0003',
        'region' => 'East',
        'attorney' => 'Unassigned',
        'sex' => 'Male',
        'cases' => [
            ['id' => 301, 'title' => 'Case D', 'status' => 'On Hold', 'created_at' => '2023-08-20'],
        ],
    ],
];

/**
 * Function to aggregate all cases with associated attorney and clients.
 */
function getAllCases($attorneys, $clients) {
    $allCases = [];

    // Map attorney names to their cases
    $attorneyCasesMap = [];
    foreach ($attorneys as $attorney) {
        foreach ($attorney['cases'] as $case) {
            $attorneyCasesMap[$case['id']] = [
                'id' => $case['id'],
                'title' => $case['title'],
                'status' => $case['status'],
                'created_at' => $case['created_at'],
                'attorney' => $attorney['name'],
                'clients' => []
            ];
        }
    }

    // Map cases from clients to associate clients with cases
    foreach ($clients as $client) {
        foreach ($client['cases'] as $case) {
            if (isset($attorneyCasesMap[$case['id']])) {
                $attorneyCasesMap[$case['id']]['clients'][] = $client;
            } else {
                // Handle cases with 'Unassigned' attorneys
                $allCases[] = [
                    'id' => $case['id'],
                    'title' => $case['title'],
                    'status' => $case['status'],
                    'created_at' => $case['created_at'],
                    'attorney' => 'Unassigned',
                    'clients' => [$client]
                ];
            }
        }
    }

    // Add cases from attorneys to allCases
    foreach ($attorneyCasesMap as $case) {
        $allCases[] = $case;
    }

    return $allCases;
}

$allCases = getAllCases($attorneys, $clients);

// Check if user is logged in
/*if (!isset($_SESSION['user_id'])) {
    header('Location: /frontend/pages/signin/index.php');
    exit();
}*/

/*$user_id = $_SESSION['user_id'];

// Fetch User Information and Roles
$stmt = $pdo->prepare("
    SELECT u.first_name, u.last_name, r.role
    FROM users u
    JOIN user_roles ur ON u.user_id = ur.user_user_id
    JOIN user_role r ON ur.roles_id = r.id
    WHERE u.user_id = ?
");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$user_name = $user ? htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) : 'Guest';
$currentPage = basename($_SERVER['PHP_SELF']);*/

// Fetch All Cases
/*function getAllCases($pdo) {
    $stmt = $pdo->prepare("


    ");
    $stmt->execute();
    $cases = $stmt->fetchAll();

    // Organize cases
    $allCases = [];
    foreach ($cases as $case) {
        $caseId = $case['case_id'];
        if (!isset($allCases[$caseId])) {
            $allCases[$caseId] = [
                'id' => $caseId,
                'details' => $case['case_details'],
                'current_stage' => $case['current_stage'],
                'attorney' => $case['attorney_name'] ?? 'Unassigned',
                'clients' => []
            ];
        }
        $allCases[$caseId]['clients'][] = [
            'id' => $case['client_id'],
            'name' => $case['client_name']
        ];
    }

    return $allCases;
}

$allCases = getAllCases($pdo);*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cases</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="cases.css">
    <style> 

        .table thead th {
            color: #000000; /* Header text color */
        }

        .table tbody td {
            color: #000000; /* Body text color */
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
    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <div class="sidebar-header">
                <img src="/frontend/assets/components/customer/home/about/Warner-Spencer.ico" 
                    alt="Law Firm Logo" 
                    class="circular-img" 
                    width="120">
                <h5 class="mt-2">Welcome, Admin!</h5>
            </div>
            <ul class="nav flex-column px-2 mt-4">
                <li class="nav-item mb-2">
                    <a class="nav-link <?= ($currentPage == 'dashboard.php') ? 'active' : '' ?>" href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-2 icon-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= ($currentPage == 'clients.php') ? 'active' : '' ?>" href="clients.php">
                        <i class="fas fa-user-friends me-2 icon-clients"></i> Clients
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= ($currentPage == 'attorneys.php') ? 'active' : '' ?>" href="attorneys.php">
                        <i class="fa-solid fa-gavel me-2 icon-attorneys"></i> Attorneys
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= ($currentPage == 'appointments.php') ? 'active' : '' ?>" href="appointments.php">
                        <i class="fas fa-calendar-check me-2 icon-appointments"></i> Appointments
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= ($currentPage == 'cases.php') ? 'active' : '' ?>" href="cases.php">
                        <i class="fa-solid fa-briefcase me-2 icon-cases"></i> Cases
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= ($currentPage == 'documents.php') ? 'active' : '' ?>" href="documents.php">
                        <i class="fas fa-file me-2 icon-documents"></i> Documents
                    </a>
                </li>
            </ul>
        </div>
        <!-- Logout Link -->
        <div class="logout px-2">
            <a class="nav-link" href="/frontend/pages/signin/logout.php">
                <i class="fas fa-sign-out-alt me-2 icon-logout"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content container-fluid">
        <h2 class="mb-4">Cases</h2>

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

        <!-- Cases Table -->
        <div class="card mb-4 custom-card">
            <div class="card-header custom-card-header">
                <h5 class="mb-0">Cases List</h5>
            </div>
            <div class="card-body custom-card-body">
                <!-- Search Bar -->
                <div class="mb-3">
                    <input type="text" id="caseSearchInput" class="form-control" placeholder="Search cases by title...">
                </div>
                <!-- Cases Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="casesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Attorney</th>
                                <th>Clients</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allCases as $case): ?>
                                <tr>
                                    <td><?= htmlspecialchars($case['id']) ?></td>
                                    <td><?= htmlspecialchars($case['details']) ?></td>
                                    <td><?= htmlspecialchars($case['current_stage']) ?></td>
                                    <td><?= htmlspecialchars($case['attorney']) ?></td>
                                    <td>
                                        <?php 
                                            $clientNames = array_map(function($client) {
                                                return htmlspecialchars($client['name']);
                                            }, $case['clients']);
                                            echo implode(', ', $clientNames);
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary view-details-btn" 
                                                data-id="<?= htmlspecialchars($case['id']) ?>" 
                                                data-details="<?= htmlspecialchars($case['details']) ?>" 
                                                data-status="<?= htmlspecialchars($case['current_stage']) ?>" 
                                                data-attorney="<?= htmlspecialchars($case['attorney']) ?>" 
                                                data-clients='<?= json_encode($case['clients']) ?>'>
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($allCases)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No cases found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Case Details Modal -->
        <div class="modal fade" id="caseDetailsModal" tabindex="-1" aria-labelledby="caseDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Case Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 id="caseDetails"></h5>
                        <p><strong>ID:</strong> <span id="caseId"></span></p>
                        <p><strong>Status:</strong> <span id="caseStatus"></span></p>
                        <p><strong>Attorney:</strong> <span id="caseAttorney"></span></p>
                        <hr>
                        <h6>Clients</h6>
                        <div id="caseClients">
                            <!-- Clients will be loaded here via JavaScript -->
                            <p>Loading clients...</p>
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
            // Search functionality for Cases
            $('#caseSearchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#casesTable tbody tr').filter(function() {
                    // Toggle based on whether the case's details include the search term
                    $(this).toggle($(this).find('td:nth-child(2)').text().toLowerCase().indexOf(value) > -1)
                });
            });

            // View Details Button Click
            $('.view-details-btn').on('click', function() {
                var id = $(this).data('id');
                var details = $(this).data('details');
                var status = $(this).data('status');
                var attorney = $(this).data('attorney');
                var clients = JSON.parse($(this).attr('data-clients'));

                $('#caseId').text(id);
                $('#caseDetails').text(details);
                $('#caseStatus').text(status);
                $('#caseAttorney').text(attorney);

                if (clients.length > 0) {
                    var clientsHtml = '<table class="table table-sm table-striped">';
                    clientsHtml += '<thead><tr><th>ID</th><th>Name</th></tr></thead><tbody>';
                    clients.forEach(function(client) {
                        clientsHtml += <tr>
                                        <td>${client.id}</td>
                                        <td>${client.name}</td>
                                      </tr>;
                    });
                    clientsHtml += '</tbody></table>';
                    $('#caseClients').html(clientsHtml);
                } else {
                    $('#caseClients').html('<p>No clients associated with this case.</p>');
                }

                // Show the modal
                var caseDetailsModal = new bootstrap.Modal(document.getElementById('caseDetailsModal'), {
                    keyboard: false
                });
                caseDetailsModal.show();
            });
        });
    </script>
</body>
</html>

---------------

<?php
session_start();

// Mevcut sayfanın adını al
$currentPage = basename($_SERVER['PHP_SELF']);

// Kullanıcı adını al
$_SESSION['user_name'] = 'Admin';
$user_name = $_SESSION['user_name'] ?? 'Guest';

$attorneys = [
    [
        'id' => 1,
        'name' => 'Alice Johnson',
        'email' => 'alice.johnson@lawfirm.com',
        'phone' => '555-1001',
        'region' => 'North',
        'sex' => 'Female',
        'cases' => [
            ['id' => 101, 'title' => 'Case A', 'status' => 'Open', 'created_at' => '2023-10-01'],
            ['id' => 102, 'title' => 'Case B', 'status' => 'In Progress', 'created_at' => '2023-10-05'],
        ],
    ],
    [
        'id' => 2,
        'name' => 'Bob Smith',
        'email' => 'bob.smith@lawfirm.com',
        'phone' => '555-1002',
        'region' => 'South',
        'sex' => 'Male',
        'cases' => [
            ['id' => 201, 'title' => 'Case C', 'status' => 'Closed', 'created_at' => '2023-09-15'],
        ],
    ],
];

$clients = [
    [
        'id' => 1,
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'phone' => '555-0001',
        'region' => 'North',
        'attorney' => 'Alice Johnson',
        'sex' => 'Male',
        'cases' => [
            ['id' => 101, 'title' => 'Case A', 'status' => 'Open', 'created_at' => '2023-10-01'],
            ['id' => 102, 'title' => 'Case B', 'status' => 'In Progress', 'created_at' => '2023-10-05'],
        ],
    ],
    [
        'id' => 2,
        'name' => 'Jane Smith',
        'email' => 'jane.smith@example.com',
        'phone' => '555-0002',
        'region' => 'South',
        'attorney' => 'Bob Smith',
        'sex' => 'Female',
        'cases' => [
            ['id' => 201, 'title' => 'Case C', 'status' => 'Closed', 'created_at' => '2023-09-15'],
        ],
    ],
    [
        'id' => 3,
        'name' => 'Mike Brown',
        'email' => 'mike.brown@example.com',
        'phone' => '555-0003',
        'region' => 'East',
        'attorney' => 'Unassigned',
        'sex' => 'Male',
        'cases' => [
            ['id' => 301, 'title' => 'Case D', 'status' => 'On Hold', 'created_at' => '2023-08-20'],
        ],
    ],
];

/**
 * Function to aggregate all cases with associated attorney and clients.
 */
function getAllCases($attorneys, $clients) {
    $allCases = [];

    // Map attorney names to their cases
    $attorneyCasesMap = [];
    foreach ($attorneys as $attorney) {
        foreach ($attorney['cases'] as $case) {
            $attorneyCasesMap[$case['id']] = [
                'id' => $case['id'],
                'title' => $case['title'],
                'status' => $case['status'],
                'created_at' => $case['created_at'],
                'attorney' => $attorney['name'],
                'clients' => []
            ];
        }
    }

    // Map cases from clients to associate clients with cases
    foreach ($clients as $client) {
        foreach ($client['cases'] as $case) {
            if (isset($attorneyCasesMap[$case['id']])) {
                $attorneyCasesMap[$case['id']]['clients'][] = $client;
            } else {
                // Handle cases with 'Unassigned' attorneys
                $allCases[] = [
                    'id' => $case['id'],
                    'title' => $case['title'],
                    'status' => $case['status'],
                    'created_at' => $case['created_at'],
                    'attorney' => 'Unassigned',
                    'clients' => [$client]
                ];
            }
        }
    }

    // Add cases from attorneys to allCases
    foreach ($attorneyCasesMap as $case) {
        $allCases[] = $case;
    }

    return $allCases;
}

$allCases = getAllCases($attorneys, $clients);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cases</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="cases.css">
    <style> 

        .table thead th {
            color: #000000; /* Header text color */
        }

        .table tbody td {
            color: #000000; /* Body text color */
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
    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <div class="sidebar-header">
                <img src="/frontend/assets/components/customer/home/about/Warner-Spencer.ico" 
                    alt="Law Firm Logo" 
                    class="circular-img" 
                    width="120">
                <h5 class="mt-2">Welcome, <?= htmlspecialchars($user_name) ?>!</h5>
            </div>
            <ul class="nav flex-column px-2 mt-4">
                <li class="nav-item mb-2">
                    <a class="nav-link <?= ($currentPage == 'dashboard.php') ? 'active' : '' ?>" href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-2 icon-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= ($currentPage == 'clients.php') ? 'active' : '' ?>" href="clients.php">
                        <i class="fas fa-user-friends me-2 icon-clients"></i> Clients
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= ($currentPage == 'attorneys.php') ? 'active' : '' ?>" href="attorneys.php">
                        <i class="fa-solid fa-gavel me-2 icon-attorneys"></i> Attorneys
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= ($currentPage == 'appointments.php') ? 'active' : '' ?>" href="appointments.php">
                        <i class="fas fa-calendar-check me-2 icon-appointments"></i> Appointments
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= ($currentPage == 'cases.php') ? 'active' : '' ?>" href="cases.php">
                        <i class="fa-solid fa-briefcase me-2 icon-cases"></i> Cases
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= ($currentPage == 'documents.php') ? 'active' : '' ?>" href="documents.php">
                        <i class="fas fa-file me-2 icon-documents"></i> Documents
                    </a>
                </li>
            </ul>
        </div>
        <!-- Logout Link -->
        <div class="logout px-2">
            <a class="nav-link" href="/frontend/pages/signin/index.php">
                <i class="fas fa-sign-out-alt me-2 icon-logout"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content container-fluid">
        <h2 class="mb-4">Cases</h2>

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

        <!-- Cases Table -->
        <div class="card mb-4 custom-card">
            <div class="card-header custom-card-header">
                <h5 class="mb-0">Cases List</h5>
            </div>
            <div class="card-body custom-card-body">
                <!-- Search Bar -->
                <div class="mb-3">
                    <input type="text" id="caseSearchInput" class="form-control" placeholder="Search cases by title...">
                </div>
                <!-- Cases Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="casesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Attorney</th>
                                <th>Clients</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allCases as $case): ?>
                                <tr>
                                    <td><?= htmlspecialchars($case['id']) ?></td>
                                    <td><?= htmlspecialchars($case['title']) ?></td>
                                    <td><?= htmlspecialchars($case['status']) ?></td>
                                    <td><?= htmlspecialchars($case['created_at']) ?></td>
                                    <td><?= htmlspecialchars($case['attorney']) ?></td>
                                    <td>
                                        <?php 
                                            $clientNames = array_map(function($client) {
                                                return htmlspecialchars($client['name']);
                                            }, $case['clients']);
                                            echo implode(', ', $clientNames);
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary view-details-btn" 
                                                data-id="<?= htmlspecialchars($case['id']) ?>" 
                                                data-title="<?= htmlspecialchars($case['title']) ?>" 
                                                data-status="<?= htmlspecialchars($case['status']) ?>" 
                                                data-created_at="<?= htmlspecialchars($case['created_at']) ?>" 
                                                data-attorney="<?= htmlspecialchars($case['attorney']) ?>" 
                                                data-clients='<?= json_encode($case['clients']) ?>'>
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($allCases)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No cases found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Case Details Modal -->
        <div class="modal fade" id="caseDetailsModal" tabindex="-1" aria-labelledby="caseDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Case Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 id="caseTitle"></h5>
                        <p><strong>ID:</strong> <span id="caseId"></span></p>
                        <p><strong>Status:</strong> <span id="caseStatus"></span></p>
                        <p><strong>Created At:</strong> <span id="caseCreatedAt"></span></p>
                        <p><strong>Attorney:</strong> <span id="caseAttorney"></span></p>
                        <hr>
                        <h6>Clients</h6>
                        <div id="caseClients">
                            <!-- Clients will be loaded here via JavaScript -->
                            <p>Loading clients...</p>
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
            // Search functionality for Cases
            $('#caseSearchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#casesTable tbody tr').filter(function() {
                    // Toggle based on whether the case's title includes the search term
                    $(this).toggle($(this).find('td:nth-child(2)').text().toLowerCase().indexOf(value) > -1)
                });
            });

            // View Details Button Click
            $('.view-details-btn').on('click', function() {
                var id = $(this).data('id');
                var title = $(this).data('title');
                var status = $(this).data('status');
                var created_at = $(this).data('created_at');
                var attorney = $(this).data('attorney');
                var clients = JSON.parse($(this).attr('data-clients'));

                $('#caseId').text(id);
                $('#caseTitle').text(title);
                $('#caseStatus').text(status);
                $('#caseCreatedAt').text(new Date(created_at).toLocaleDateString());
                $('#caseAttorney').text(attorney);

                if (clients.length > 0) {
                    var clientsHtml = '<table class="table table-sm table-striped">';
                    clientsHtml += '<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Region</th></tr></thead><tbody>';
                    clients.forEach(function(client) {
                        clientsHtml += `<tr>
                                        <td>${client.id}</td>
                                        <td>${client.name}</td>
                                        <td>${client.email}</td>
                                        <td>${client.phone}</td>
                                        <td>${client.region}</td>
                                      </tr>`;
                    });
                    clientsHtml += '</tbody></table>';
                    $('#caseClients').html(clientsHtml);
                } else {
                    $('#caseClients').html('<p>No clients associated with this case.</p>');
                }

                // Show the modal
                var caseDetailsModal = new bootstrap.Modal(document.getElementById('caseDetailsModal'), {
                    keyboard: false
                });
                caseDetailsModal.show();
            });
        });
    </script>
</body>
</html>
