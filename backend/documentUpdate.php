<?php
$DEBUG_MODE = false; // Set to true for debugging
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $documentID = $_POST['document_id'];
    $uploadDir = "/uploads/documents/"; // Change this to your desired upload directory
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;

    // Debugging: Check directory
    if ($DEBUG_MODE) {
        echo "Target Directory: $targetDir<br>";
    }

    // Check if the directory exists; if not, create it
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Check if a file is uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $fileName = basename($_FILES['file']['name']);
        $targetFilePath = $targetDir . $fileName;
        $relativeFilePath = $uploadDir . $fileName;

        // Debugging: Check file details
        if ($DEBUG_MODE) {
            echo "File Name: $fileName<br>";
            echo "Target File Path: $targetFilePath<br>";
            echo "Relative File Path: $relativeFilePath<br>";
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
            // Update the file path in the database
            $sql = "UPDATE documents SET file_path = ? WHERE document_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $relativeFilePath, $documentID);

            if ($stmt->execute()) {
                echo "File uploaded and path updated successfully!";
            } else {
                echo "Error updating file path in database: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error moving the uploaded file. Check server permissions.";
        }
    } else {
        // Handle file upload errors
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive in php.ini.",
            UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
            UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded.",
            UPLOAD_ERR_NO_FILE => "No file was uploaded.",
            UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
            UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
            UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload.",
        ];
        $errorCode = $_FILES['file']['error'];
        $errorMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : "Unknown error occurred.";
        echo "Error: $errorMessage";
    }
}
?>
