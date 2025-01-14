<?php
session_start();
include("connect.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ROLE_ATTORNEY') {
    header("Location: /frontend/pages/signin/index.php");
    exit;
}

$attorney_id = $_SESSION['user_id'];


$list = myQuery("SELECT d.document_id, c.case_id, c.case_details, c.current_stage, d.file_path
                 FROM document AS d
                 JOIN tblcase AS c ON d.case_id = c.case_id
                 WHERE c.attorney_id = ?", [$attorney_id]);

?>

<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>

    <div class="container">
        <h1>Document and Case Details</h1>
        <?php
        if ($list && $list->num_rows > 0) {
            echo "<div class='table-container'>";
            echo "<table class='table table-dark table-striped table-hover'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Document ID</th>";
            echo "<th>Case ID</th>";
            echo "<th>Case Details</th>";
            echo "<th>Current Stage</th>";
            echo "<th>File Path</th>";
            echo "<th>Download</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($row = $list->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['document_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['case_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['case_details']) . "</td>";
                echo "<td>" . htmlspecialchars($row['current_stage']) . "</td>";
                echo "<td>" . htmlspecialchars($row['file_path']) . "</td>";
                echo "<td>";
                echo "<a class='btn-download' href='" . htmlspecialchars($row['file_path']) . "' download><i class='fas fa-download me-1'></i>Download</a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p class='no-data'>No documents found for you.</p>";
        }
        ?>
    </div>
</body>
</html>