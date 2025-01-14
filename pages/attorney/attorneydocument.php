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

// Kullanıcı bilgilerini çek
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
    SELECT d.document_id, d.case_id, d.file_path, u.first_name, u.last_name
    FROM document AS d
    JOIN tblcase c ON d.case_id = c.case_id
    JOIN user AS u
    ON c.user_user_id = u.user_id
    JOIN attorney AS a
    ON a.attorney_id = c.attorney_id
    WHERE a.user_user_id = $user_id
    ORDER BY d.document_id DESC
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        <?php require_once "attorney_document.css" ?>
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
                <h5 class="mt-2">Welcome, <?php echo $user_name; ?>!</h5>
            </div>
            <ul class="nav flex-column px-2">
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-2 icon-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $current_page == 'attorneyclients.php' ? 'active' : '' ?>" href="attorneyclients.php">
                        <i class="fas fa-user-friends me-2 icon-clients"></i> Clients
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $current_page == 'attorneybooking.php' ? 'active' : '' ?>" href="attorneybooking.php">
                        <i class="fas fa-calendar-check me-2 icon-appointments"></i> Appointments
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $current_page == 'attorneycase.php' ? 'active' : '' ?>" href="attorneycase.php">
                        <i class="fa-solid fa-briefcase me-2 icon-cases"></i> Cases
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= $current_page == 'attorneydocument.php' ? 'active' : '' ?>" href="attorneydocument.php">
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
        <h2 class="mb-4">Document</h2>

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

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Document List</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search Document...">
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="documentsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Document Name</th>
                                <th>Case ID</th>
                                <th>Uploaded By</th>
                                <th>Operations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_activities)): ?>
                                <?php foreach ($recent_activities as $document): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($document['document_id']) ?></td>
                                        <td><?= htmlspecialchars(basename($document['file_path'])) ?></td>
                                        <td><?= htmlspecialchars($document['case_id']) ?></td>
                                        <td><?= htmlspecialchars($document['first_name'] . ' ' . $document['last_name']) ?></td>
                                        <td>
                                            <a href="download.php?document_id=<?= htmlspecialchars($document['document_id']) ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Can not find a document.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#documentsTable tbody tr').filter(function() {
                    $(this).toggle($(this).find('td:nth-child(2)').text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>
</html>
