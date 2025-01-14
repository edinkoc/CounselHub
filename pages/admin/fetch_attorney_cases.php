<?php
session_start();
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['client_id'])) {
    $client_id = intval($_POST['client_id']);

    $case_list = myQuery("
        SELECT 
            c.case_id, 
            c.case_details, 
            c.current_stage
        FROM cases AS c
        WHERE c.client_id = $client_id
    ");

    if ($case_list && $case_list->num_rows > 0) {
        $cases = [];
        while ($row = $case_list->fetch_assoc()) {
            $cases[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $cases]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Bu müşteri için dava bulunamadı.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz İstek.']);
}
?>