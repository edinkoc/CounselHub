<?php

include("connect.php");

if (isset($_POST['submit'])) {
    $caseID = $_POST['case_id'];
    $currentStage = $_POST['current_stage'];

    $q = "UPDATE tblcase SET 
        current_stage = '$currentStage'
        WHERE case_id = $caseID";

    $result = myQuery($q);

    if ($result) {
        echo "<p style='color: green;'>Case ID $caseID status updated to '$currentStage' successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error updating case: " . $conn->error . "</p>";
    }
}

?>
