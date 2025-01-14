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
    $_SESSION['error'] = "Erişim reddedildi. Sadece admin kullanıcılar bu işlemi gerçekleştirebilir.";
    header("Location: appointments.php"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);

    $check_query = "
        SELECT scheduling_id 
        FROM scheduling 
        WHERE scheduling_id = $delete_id
    ";
    $check_result = myQuery($check_query, "i", [$delete_id]);

    if ($check_result && $check_result->num_rows > 0) {
        $delete_query = "
            DELETE FROM scheduling 
            WHERE scheduling_id = $delete_id
        ";
        $delete_result = myQuery($delete_query, "i", [$delete_id]);

        if ($delete_result) {
            $_SESSION['success'] = "Randevu başarıyla silindi.";
        } else {
            $_SESSION['error'] = "Randevu silinirken bir hata oluştu.";
        }
    } else {
        $_SESSION['error'] = "Silinecek randevu bulunamadı.";
    }

    $directory = dirname($_SERVER['PHP_SELF']);
    header("Location: $directory/appointments.php");
    exit();
} else {
    $_SESSION['error'] = "Geçersiz istek.";
    $directory = dirname($_SERVER['PHP_SELF']);
    header("Location: $directory/appointments.php");
    exit();
}
?>
