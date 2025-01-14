<?php
session_start();
header('Content-Type: application/json');

require_once 'connect.php'; // Ensure the path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id']) && isset($_SESSION['user_id'])) {
        $client_id = intval($_POST['user_id']);
        $attorney_id = intval($_SESSION['user_id']);

        // Verify that the logged-in attorney is assigned to the client
        $qry = "
            SELECT 
                c.case_id, 
                c.case_details, 
                c.current_stage 
            FROM 
                tblcase c
            WHERE 
                c.user_user_id = :client_id 
                AND c.attorney_id = :attorney_id
        ";
        $stmt = $pdo->prepare($qry);
        $stmt->execute(['client_id' => $client_id, 'attorney_id' => $attorney_id]);
        $cases = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'data' => $cases]);
        exit();
    }
}

echo json_encode(['success' => false, 'message' => 'Invalid request.']);
exit();
?>
