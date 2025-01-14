<?php
session_start();

require_once 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /frontend/pages/signin/login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);

if (isset($_GET['document_id'])) {
    $document_id = intval($_GET['document_id']);

    $stmt = $GLOBALS['db_connection']->prepare("
        SELECT d.file_path, a.user_user_id
        FROM document AS d
        JOIN tblcase c ON d.case_id = c.case_id
        JOIN attorney AS a ON a.attorney_id = c.attorney_id
        WHERE d.document_id = $document_id
    ");
    $stmt->bind_param("i", $document_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $document = $result->fetch_assoc();

        if ($document['user_user_id'] === $user_id) {
            $file_path = $document['file_path'];

            if (file_exists($file_path)) {

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $file_path);
                finfo_close($finfo);

                header('Content-Description: File Transfer');
                header('Content-Type: ' . $mime_type);
                header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file_path));
                flush(); 

                readfile($file_path);
                exit;
            } else {
                echo "Dosya bulunamadı.";
            }
        } else {
            echo "Bu belgeye erişim yetkiniz yok.";
        }
    } else {
        echo "Belge bulunamadı.";
    }

    $stmt->close();
} else {
    echo "Geçersiz istek.";
}
?>
