<?php
require_once("connect.php");

session_start();
if (!isset($_SESSION['customer']['user_id'])) {
    die("Unauthorized access.");
}

$customerId = $_SESSION['customer']['user_id'];
$message = '';

$stmt = $pdo->prepare("
    SELECT c.case_id, c.case_details, c.current_stage,
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
        $stmt = $pdo->prepare("INSERT INTO document (case_id, file_path) VALUES (:caseId, :filePath)");
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
    <title>My Cases</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-YY0C2+Efa66y8BWPbEnMnSRJWRSy7KzEcltfIxa4StGwAR7c+VWdSAt8UYB0zG1Qp/p3KZfwLChzZezf0mzQfQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Tahoma, sans-serif;
            background-color: #f8f4ee;
            color: #333;
            line-height: 1.4;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 2.2rem;
            color: #6d4c41;
            margin-bottom: 20px;
        }

        .message {
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #bfa07d;
            background-color: #fdfaf7;
            color: #6d4c41;
            border-radius: 6px;
            text-align: center;
        }

        .case-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .case-widget {
            background-color: #fdfaf7;
            border: 1px solid #e0d6cc;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 20px;
        }

        .case-widget:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .case-widget h2 {
            font-size: 1.4rem;
            color: #6d4c41;
            margin-bottom: 10px;
        }

        .case-details {
            margin-bottom: 15px;
        }

        .case-details p {
            margin: 6px 0;
            color: #555;
        }

        .case-details strong {
            color: #bfa07d; 
            margin-right: 5px;
        }

        .toggle-documents {
            display: flex;
            align-items: center;
            cursor: pointer;
            color: #6d4c41;
            font-weight: bold;
            margin-bottom: 10px;
            transition: color 0.3s;
        }

        .toggle-documents i {
            margin-right: 8px;
            transition: transform 0.3s;
        }

        .toggle-documents.open i {
            transform: rotate(180deg);
        }

        .toggle-documents:hover {
            color: #a08065;
        }

        .documents-container {
            display: none;
            animation: slideDown 0.3s ease forwards;
        }

        .documents-container.active {
            display: block; 
        }

        @keyframes slideDown {
            0% {
                opacity: 0;
                transform: translateY(-5px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #e0d6cc;
        }

        table th {
            background-color: #f3ece7;
            color: #333;
            text-align: left;
        }

        table a {
            color: #6d4c41;
            text-decoration: none;
        }

        table a:hover {
            text-decoration: underline;
        }

        form {
            margin-top: 10px;
        }

        form input[type="file"] {
            margin-right: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 6px 8px;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        form button {
            background-color: #bfa07d;
            color: #fff;
            border: none;
            padding: 8px 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 0.9rem;
        }

        form button:hover {
            background-color: #a08065;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px auto;
                padding: 15px;
            }

            h1 {
                font-size: 1.8rem;
            }

            .case-widget {
                padding: 15px;
            }

            .case-widget h2 {
                font-size: 1.2rem;
            }

            table th, table td {
                font-size: 0.85rem;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleLinks = document.querySelectorAll('.toggle-documents');

            toggleLinks.forEach(link => {
                link.addEventListener('click', () => {

                    const caseWidget = link.closest('.case-widget');

                    const docContainer = caseWidget.querySelector('.documents-container');

                    docContainer.classList.toggle('active');
                    link.classList.toggle('open');
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>My Cases</h1>
        
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <div class="case-list">
            <?php foreach ($cases as $case): ?>
                <div class="case-widget">

                    <h2>Case ID: <?php echo htmlspecialchars($case['case_id']); ?></h2>

                    <div class="case-details">
                        <p><strong>Details:</strong><?php echo htmlspecialchars($case['case_details']); ?></p>
                        <p><strong>Attorney:</strong><?php echo htmlspecialchars($case['attorney_firstname'] . ' ' . $case['attorney_lastname']); ?></p>
                        <p><strong>Current Stage:</strong><?php echo htmlspecialchars($case['current_stage']); ?></p>
                    </div>

                    <div class="toggle-documents">
                        <i class="fas fa-chevron-down"></i>
                        <span>Show Documents</span>
                    </div>

                    <div class="documents-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Document Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $docStmt = $pdo->prepare("SELECT file_path FROM document WHERE case_id = :caseId");
                                $docStmt->execute(['caseId' => $case['case_id']]);
                                $documents = $docStmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($documents) {
                                    foreach ($documents as $document) {
                                        $filePath = htmlspecialchars($document['file_path']);
                                        $fileName = basename($filePath);
                                        echo '<tr><td><a href="'.$filePath.'" target="_blank">'.$fileName.'</a></td></tr>';
                                    }
                                } else {
                                    echo '<tr><td>No documents available for this case.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>

                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="case_id" value="<?php echo htmlspecialchars($case['case_id']); ?>">
                            <input type="file" name="document" required>
                            <button type="submit">Upload Document</button>
                        </form>
                    </div> 
                </div> 
            <?php endforeach; ?>
        </div>
    </div>
    <?php include_once "../../frontend/components/customer/footer/footer.php"; ?>
</body>
</html>