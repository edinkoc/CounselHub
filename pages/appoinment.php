<?php
require_once("connect.php");

session_start();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $attorney_id = $_POST['attorney_id'] ?? null;
        $booking_date = $_POST['booking_date'] ?? null;
        $case_details = $_POST['case_details'] ?? null;
        $user_id = $_SESSION['customer']['user_id'] ?? null;

        if (!$attorney_id || !$booking_date || !$case_details || !$user_id) {
            http_response_code(400);
            die('Missing required fields.');
        }

        // Tarihi doğru formata dönüştür
        $formatted_date = date('Y-m-d H:i:s', strtotime($booking_date));

        // Sunucu tarafında bu slotun dolu olup olmadığını kontrol et
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM scheduling WHERE attorney_id = :attorney_id AND booking_date = :booking_date");
        $stmt->execute([
            ':attorney_id' => $attorney_id,
            ':booking_date' => $formatted_date
        ]);
        $isBooked = $stmt->fetchColumn() > 0;

        if ($isBooked) {
            http_response_code(409); // HTTP 409 Conflict
            die('This time slot is already booked.');
        }

        $pdo->beginTransaction();

        // Scheduling tablosuna veri ekleme
        $stmt1 = $pdo->prepare("
            INSERT INTO scheduling (user_user_id, attorney_id, booking_date, status) 
            VALUES (:user_id, :attorney_id, :booking_date, 1)
        ");
        $stmt1->execute([
            ':user_id' => $user_id,
            ':attorney_id' => $attorney_id,
            ':booking_date' => $formatted_date
        ]);

        // Tblcase tablosuna veri ekleme
        $stmt2 = $pdo->prepare("
            INSERT INTO tblcase (user_user_id, attorney_id, case_details, current_stage) 
            VALUES (:user_id, :attorney_id, :case_details, 'Initial Consultation')
        ");
        $stmt2->execute([
            ':user_id' => $user_id,
            ':attorney_id' => $attorney_id,
            ':case_details' => $case_details
        ]);

        $pdo->commit();
        echo 'Booking successful!';
    }
} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    die('Database error: ' . $e->getMessage());
}
?>