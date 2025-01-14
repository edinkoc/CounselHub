<?php
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);

    $attorney_list = myQuery("
        SELECT 
            a.attorney_id, 
            a.attorney_firstname, 
            a.attorney_lastname,
            u.email,
            u.phone
        FROM attorney AS a
        INNER JOIN scheduling AS s ON a.attorney_id = s.attorney_id
        INNER JOIN user AS u ON u.user_id = a.attorney_id
        WHERE s.user_user_id = $user_id
    ");

    if ($attorney_list && $attorney_list->num_rows > 0) {
        $attorneys = [];
        while ($row = $attorney_list->fetch_assoc()) {
            $attorneys[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $attorneys]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Attorney not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request.']);
}
?>