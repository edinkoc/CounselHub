<?php
session_start();

// Veritabanı bağlantısını dahil et
require_once 'connect.php'; // Doğru yolu kullandığınızdan emin olun

// Kullanıcı doğrulaması ve rol kontrolü (Admin mi?)
if (!isset($_SESSION['user_id'])) {
    header("Location: /frontend/pages/signin/login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);

// Kullanıcının admin olup olmadığını kontrol et
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

// Eğer admin değilse, erişimi engelle
if (!$is_admin) {
    $_SESSION['error'] = "Erişim reddedildi. Sadece admin kullanıcılar bu işlemi gerçekleştirebilir.";
    header("Location: appointments.php");
    exit();
}

// Belge ID'sini GET veya POST parametresinden al
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST isteği için
    if (isset($_POST['scheduling_id']) && is_numeric($_POST['scheduling_id'])) {
        $scheduling_id = intval($_POST['scheduling_id']);
    } else {
        $_SESSION['error'] = "Geçersiz randevu ID.";
        header("Location: appointments.php");
        exit();
    }

    // Formdan gelen verileri al
    if (isset($_POST['user_id'], $_POST['attorney_id'], $_POST['date'], $_POST['time'], $_POST['status'])) {
        $new_user_id = intval($_POST['user_id']);
        $new_attorney_id = intval($_POST['attorney_id']);
        $new_date = $_POST['date'];
        $new_time = $_POST['time'];
        $new_status = intval($_POST['status']); // 1: Scheduled, 0: Cancelled
    } else {
        $_SESSION['error'] = "Tüm alanları doldurmanız gerekmektedir.";
        header("Location: update_appointment.php?scheduling_id=$scheduling_id");
        exit();
    }

    // Booking_date oluştur
    $new_booking_date = $new_date . ' ' . $new_time . ':00';

    // Güncelleme sorgusu (Hazırlıklı ifade kullanılarak)
    $update_query = "
        UPDATE scheduling
        SET user_user_id = $new_user_id, attorney_id = $new_attorney_id, booking_date = $new_time, status = $new_status
        WHERE scheduling_id = $scheduling_id
    ";
    $update_result = myQuery($update_query, "iissi", [$new_user_id, $new_attorney_id, $new_booking_date, $new_status, $scheduling_id]);

    if ($update_result) {
        $_SESSION['success'] = "Randevu başarıyla güncellendi.";
        header("Location: appointments.php");
        exit();
    } else {
        $_SESSION['error'] = "Randevu güncellenirken bir hata oluştu.";
        header("Location: update_appointment.php?scheduling_id=$scheduling_id");
        exit();
    }
} else {
    // GET isteği için
    if (isset($_GET['scheduling_id']) && is_numeric($_GET['scheduling_id'])) {
        $scheduling_id = intval($_GET['scheduling_id']);

        // Randevuyu veritabanından al
        $appointment_query = "
            SELECT scheduling_id, user_user_id, attorney_id, DATE(booking_date) AS date, TIME(booking_date) AS time, status
            FROM scheduling
            WHERE scheduling_id = $scheduling_id
        ";
        $appointment_result = myQuery($appointment_query, "i", [$scheduling_id]);

        if ($appointment_result && $appointment_result->num_rows > 0) {
            $appointment = $appointment_result->fetch_assoc();
        } else {
            $_SESSION['error'] = "Randevu bulunamadı.";
            header("Location: appointments.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Geçersiz randevu ID.";
        header("Location: appointments.php");
        exit();
    }
}

// Kullanıcıları ve Avukatları çekmek için sorgular
$users_query = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS full_name FROM user ORDER BY first_name ASC";
$users_list = myQuery($users_query);

$attorneys_query = "SELECT attorney_id, CONCAT(attorney_firstname, ' ', attorney_lastname) AS full_name FROM attorney ORDER BY attorney_firstname ASC";
$attorneys_list = myQuery($attorneys_query);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Randevu Güncelle</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Sidebar ve Genel Stil */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            min-height: 100vh;
            padding: 20px 0;
        }

        .sidebar a {
            color: #ffffff;
            padding: 15px 20px;
            display: block;
            transition: background 0.3s;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #00d1b2;
            color: #000000;
            text-decoration: none;
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar-header img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 3px solid #00d1b2;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        /* Form Stil */
        .form-control {
            background-color: #ffffff;
            color: #000000;
        }

        .btn-submit {
            background-color: #00d1b2;
            color: #ffffff;
            border: none;
        }

        .btn-submit:hover {
            background-color: #00a898;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: #ffffff;
            border: none;
        }

        .btn-cancel:hover {
            background-color: #5a6268;
        }

        /* Alert Stil */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="/frontend/assets/components/customer/home/about/Warner-Spencer.ico" alt="Admin Logo">
            <h5 class="mt-2">Admin Paneli</h5>
        </div>
        <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a href="appointments.php" class="<?= basename($_SERVER['PHP_SELF']) == 'appointments.php' ? 'active' : '' ?>">
            <i class="fas fa-calendar-check me-2"></i> Randevular
        </a>
        <a href="admin_users.php" class="<?= basename($_SERVER['PHP_SELF']) == 'admin_users.php' ? 'active' : '' ?>">
            <i class="fas fa-users me-2"></i> Kullanıcılar
        </a>
        <!-- Diğer navigasyon linkleri -->
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Randevu Güncelle</h2>

        <!-- Başarı veya Hata Mesajları -->
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

        <!-- Randevu Güncelleme Formu -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Randevu Bilgilerini Güncelle</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="update_appointment.php">
                    <!-- Gizli scheduling_id alanı eklendi -->
                    <input type="hidden" name="scheduling_id" value="<?= htmlspecialchars($scheduling_id) ?>">

                    <div class="mb-3">
                        <label for="user_id" class="form-label">Client</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option value="">-- Select Client --</option>
                            <?php if ($users_list && $users_list->num_rows > 0): ?>
                                <?php while($user = $users_list->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($user['user_id']) ?>" <?= ($user['user_id'] == $appointment['user_user_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($user['full_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="attorney_id" class="form-label">Attorney</label>
                        <select class="form-select" id="attorney_id" name="attorney_id" required>
                            <option value="">-- Select Attorney --</option>
                            <?php if ($attorneys_list && $attorneys_list->num_rows > 0): ?>
                                <?php while($attorney = $attorneys_list->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($attorney['attorney_id']) ?>" <?= ($attorney['attorney_id'] == $appointment['attorney_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($attorney['full_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?= htmlspecialchars($appointment['date']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" class="form-control" id="time" name="time" value="<?= htmlspecialchars($appointment['time']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="1" <?= ($appointment['status'] == 1) ? 'selected' : '' ?>>Scheduled</option>
                            <option value="0" <?= ($appointment['status'] == 0) ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-submit">Güncelle</button>
                    <a href="appointments.php" class="btn btn-cancel">İptal</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (Includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
