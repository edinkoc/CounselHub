<?php
session_start();
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attorney_id'])) {
    $attorney_id = intval($_POST['attorney_id']);

    $client_list = myQuery("
        SELECT 
            u.user_id AS client_id, 
            u.first_name, 
            u.last_name, 
            u.email, 
            u.phone
        FROM user AS u
        INNER JOIN scheduling AS s ON u.user_id = s.user_user_id
        WHERE s.attorney_id = $attorney_id
    ");

    if ($client_list && $client_list->num_rows > 0) {
        $clients = [];
        while ($row = $client_list->fetch_assoc()) {
            $clients[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $clients]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Bu avukat için müşteri bulunamadı.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz İstek.']);
}
?>