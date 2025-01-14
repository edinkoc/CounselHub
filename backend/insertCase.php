<?php
$DEBUG_MODE = false;

require("connect.php");

if (isset($_POST['submit_case'])) {
    $userId = $_POST['user_id'];
    $attorneyId = $_POST['attorney_id'];
    $caseDetails = $_POST['case_details'];
    $currentStage = $_POST['current_stage'];

    $q = "INSERT INTO `tblcase` (user_user_id, attorney_id, case_details, current_stage) VALUES (
        '$userId',
        '$attorneyId',
        '$caseDetails',
        '$currentStage'
    )";

    if ($DEBUG_MODE) {
        echo $q;
    }

    if (myQuery($q)) {
        echo "<p style='color: green;'>Case successfully added!</p>";
    } else {
        echo "<p style='color: red;'>Error inserting case.</p>";
    }
} else {
    echo "<form action='insertCase.php' method='post'>";
    echo "<h3>Insert New Case</h3>";
    echo "<p>User ID: <input type='text' name='user_id'></p>";
    echo "<p>Attorney ID: <input type='text' name='attorney_id'></p>";
    echo "<p>Case Details: <input type='text' name='case_details'></p>";
    echo "<p>Current Stage: <input type='text' name='current_stage'></p>";
    echo "<p><input type='submit' name='submit_case' value='Insert New Case'></p>";
    echo "</form>";
}
?>
