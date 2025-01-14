<?php
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);

    $case_list = myQuery("SELECT 
                            c.case_id, 
                            c.case_details, 
                            c.current_stage
                         FROM tblcase AS c
                         WHERE c.user_user_id = $user_id");

    if ($case_list && $case_list->num_rows > 0) {
        $cases = [];
        while ($row = $case_list->fetch_assoc()) {
            $cases[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $cases]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Attorney not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request.']);
}
?>