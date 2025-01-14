<?php
session_start();
include("connect.php");

function myQuery($query, $params = [], $types = "") {
    global $conn;
    if ($stmt = $conn->prepare($query)) {
        if (!empty($params)) {
            if (empty($types)) {
                $types = str_repeat('i', count($params)); 
            }
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            return ['success' => false, 'message' => 'Database query failed'];
        }
        return ['success' => true, 'data' => $result->fetch_all(MYSQLI_ASSOC)];
    } else {
        return ['success' => false, 'message' => 'Database preparation failed'];
    }
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    if ($user_id > 0) {
        $casesQuery = "
            SELECT 
                c.case_id, 
                c.case_details, 
                c.current_stage
            FROM tblcase AS c
            WHERE c.user_user_id = ?
        ";
        $casesResult = myQuery($casesQuery, [$user_id], 'i');
        if ($casesResult['success']) {
            echo json_encode(['success' => true, 'data' => $casesResult['data']]);
        } else {
            echo json_encode(['success' => false, 'message' => $casesResult['message']]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid user ID.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>