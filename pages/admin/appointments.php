<?php
session_start();

require_once 'connect.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: /frontend/pages/signin/login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);

$role_query = "
    SELECT r.role 
    FROM user_roles ur
    JOIN user_role r ON ur.roles_id = r.id
    WHERE ur.user_user_id = $user_id
";
$role_result = myQuery($role_query, "i", [$user_id]);

$is_admin = false;
if ($role_result && $role_result->num_rows > 0) {
    while ($role = $role_result->fetch_assoc()) {
        if ($role['role'] === 'ROLE_ADMIN') {
            $is_admin = true;
            break;
        }
    }
}
$role_result->free();

if (!$is_admin) {
    $_SESSION['error'] = "Erişim reddedildi. Sadece admin kullanıcılar bu sayfayı görüntüleyebilir.";
    header("Location: dashboard.php"); // İstediğiniz başka bir sayfaya yönlendirebilirsiniz
    exit();
}

$qry = "
    SELECT 
        s.scheduling_id AS id,
        CONCAT(u.first_name, ' ', u.last_name) AS client_name, 
        CONCAT(a.attorney_firstname, ' ', a.attorney_lastname) AS attorney_name, 
        DATE(s.booking_date) AS date, 
        TIME(s.booking_date) AS time,
        s.status AS status
    FROM scheduling AS s
    LEFT JOIN user AS u ON s.user_user_id = u.user_id
    LEFT JOIN attorney AS a ON s.attorney_id = a.attorney_id
    ORDER BY s.booking_date ASC
";

$list = myQuery($qry);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
    <link href="module_appointments.css" rel="stylesheet"/>
</head>
<body>
    <div class="sidebar">
        <div>
            <div class="sidebar-header">
                <img 
                    src="/frontend/assets/components/customer/home/about/Warner-Spencer.ico"
                    alt="Law Firm Logo"
                    class="circular-img"
                    width="120"
                />
            </div>
            <ul class="nav flex-column px-2 mt-4">
                <li class="nav-item mb-2">
                    <a class="nav-link" href="dashboard.php">
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
                    <a class="nav-link active" href="appointments.php">
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
            <a class="nav-link" href="/frontend/pages/signin/logout.php">
                <i class="fas fa-sign-out-alt me-2 icon-logout"></i> Logout
            </a>
        </div>
    </div>


    <div class="main-content container-fluid">

        <h2 class="mb-4">Appointments</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <button 
                    type="button" 
                    class="btn-close" 
                    data-bs-dismiss="alert" 
                    aria-label="Close"
                ></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <button 
                    type="button" 
                    class="btn-close" 
                    data-bs-dismiss="alert" 
                    aria-label="Close"
                ></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client Name</th>
                        <th>Attorney Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($list && $list->num_rows > 0): ?>
                        <?php while($row = $list->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['client_name']) ?></td>
                                <td><?= htmlspecialchars($row['attorney_name']) ?></td>
                                <td><?= htmlspecialchars($row['date']) ?></td>
                                <td><?= htmlspecialchars($row['time']) ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                                <td>
                                    <a href="update_appointment.php?scheduling_id=<?= urlencode($row['id']) ?>" class="btn btn-update btn-sm">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <form method="POST" action="cancel_appointment.php" onsubmit="return confirm('Bu randevuyu silmek istediğinize emin misiniz?');">
                                        <input type="hidden" name="delete_id" value="<?= htmlspecialchars($row['id']) ?>">
                                        <button type="submit" class="btn btn-delete btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Hiç randevu bulunamadı.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
