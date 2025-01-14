<?php
require_once("connect.php");

session_start();
if (!isset($_SESSION['customer']['user_id'])) {
    die("Unauthorized access.");
}

$customerId = $_SESSION['customer']['user_id'];
$message = '';

$stmt = $pdo->prepare("
    SELECT c.case_id, c.scheduling_id, c.case_details, c.current_stage,
           a.attorney_firstname, a.attorney_lastname
    FROM tblcase c
    JOIN attorney a ON c.attorney_id = a.attorney_id
    WHERE c.user_user_id = :customerId
");
$stmt->execute(['customerId' => $customerId]);
$cases = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['case_id'], $_FILES['document'])) {
    $caseId = intval($_POST['case_id']);
    $uploadDir = "uploads/case_$caseId/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $uploadFile = $uploadDir . basename($_FILES['document']['name']);
    if (move_uploaded_file($_FILES['document']['tmp_name'], $uploadFile)) {
        $stmt = $pdo->prepare("
            INSERT INTO document (case_id, file_path) 
            VALUES (:caseId, :filePath)
        ");
        $stmt->execute(['caseId' => $caseId, 'filePath' => $uploadFile]);
        $message = "File uploaded successfully for Case ID: $caseId!";
    } else {
        $message = "File upload failed for Case ID: $caseId.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test My Cases</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .case-card {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
        }

        .case-card h3 {
            margin: 0 0 10px;
        }

        .documents {
            margin-top: 10px;
            padding: 10px;
            background: #f4f4f4;
            border-radius: 5px;
        }

        .upload-form {
            margin-top: 10px;
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        button {
            padding: 8px 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .message {
            margin-bottom: 20px;
            padding: 10px;
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Cases</h1>
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php foreach ($cases as $case): ?>
            <div class="case-card">
                <h3>Case ID: <?php echo htmlspecialchars($case['case_id']); ?></h3>
                <p><strong>Details:</strong> <?php echo htmlspecialchars($case['case_details']); ?></p>
                <p><strong>Attorney:</strong> <?php echo htmlspecialchars($case['attorney_firstname'] . " " . $case['attorney_lastname']); ?></p>
                <p><strong>Scheduling ID:</strong> <?php echo htmlspecialchars($case['scheduling_id']); ?></p>
                <p><strong>Current Stage:</strong> <?php echo htmlspecialchars($case['current_stage']); ?></p>

                <div class="documents">
                    <h4>Documents</h4>
                    <?php
                    $docStmt = $pdo->prepare("SELECT file_path FROM document WHERE case_id = :caseId");
                    $docStmt->execute(['caseId' => $case['case_id']]);
                    $documents = $docStmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php if ($documents): ?>
                        <ul>
                            <?php foreach ($documents as $document): ?>
                                <li><a href="<?php echo htmlspecialchars($document['file_path']); ?>" target="_blank"><?php echo basename(htmlspecialchars($document['file_path'])); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No documents available for this case.</p>
                    <?php endif; ?>
                </div>

                <form class="upload-form" action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="case_id" value="<?php echo htmlspecialchars($case['case_id']); ?>">
                    <input type="file" name="document" required>
                    <button type="submit">Upload Document</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
