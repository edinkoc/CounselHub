<?php

$DEBUG_MODE = false;
include("connect.php");

// Fetch case list and create a dropdown menu
$list = myQuery("SELECT case_id, case_details FROM tblcase ORDER BY case_id");
echo "<form action='' method='post'>";
echo "<select name='case_id'>";
foreach ($list as $record) {
    echo "<option value='" . $record['case_id'] . "'>Case #" . $record['case_id'] . ": " . $record['case_details'] . "</option>";
}
echo "</select><br>";
echo "<input type='submit' name='submit' value='Select Case to Edit'/>";
echo "</form>";

// Check if a case has been selected for editing
if (isset($_POST['case_id'])) {
    $caseID = $_POST['case_id'];

    // Fetch selected case's details
    $result = myQuery("SELECT current_stage FROM tblcase WHERE case_id = $caseID");

    // Populate the form with the case's current status
    foreach ($result as $record) {
        $currentStage = $record['current_stage'];
    }

    // Form for editing case status
    echo "<form action='caseUpdate.php' method='post'>";
    echo "<input type='hidden' name='case_id' value='" . $caseID . "'>";
    echo "<p>Current Status:</p>";
    echo "<select name='current_stage'>";
    echo "<option value='Opened' " . ($currentStage == 'Opened' ? 'selected' : '') . ">Opened</option>";
    echo "<option value='Investigation' " . ($currentStage == 'Investigation' ? 'selected' : '') . ">Investigation</option>";
    echo "<option value='Mediation' " . ($currentStage == 'Mediation' ? 'selected' : '') . ">Mediation</option>";
    echo "<option value='Document Submission' " . ($currentStage == 'Document Submission' ? 'selected' : '') . ">Document Submission</option>";
    echo "<option value='Court Proceedings' " . ($currentStage == 'Court Proceedings' ? 'selected' : '') . ">Court Proceedings</option>";
    echo "<option value='Final Review' " . ($currentStage == 'Final Review' ? 'selected' : '') . ">Final Review</option>";
    echo "</select>";
    echo "<p><input type='submit' name='submit' value='Update Case'></p>";
    echo "</form>";
}
?>
