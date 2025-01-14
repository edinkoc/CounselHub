<?php

$DEBUG_MODE = false;
include("connect.php");

// Fetch document list and create a dropdown menu
$list = myQuery("SELECT document_id, file_path FROM document ORDER BY document_id");
echo "<form action='' method='post'>";
echo "<select name='document_id'>";
foreach ($list as $record) {
    echo "<option value='" . $record['document_id'] . "'>Document ID " . $record['document_id'] . " - " . $record['file_path'] . "</option>";
}
echo "</select><br>";
echo "<input type='submit' name='submit' value='Select Document to Edit'/>";
echo "</form>";

// Check if a document has been selected for editing
if (isset($_POST['document_id'])) {
    $documentID = $_POST['document_id'];

    // Fetch the selected document's details
    $result = myQuery("SELECT file_path FROM document WHERE document_id = $documentID");

    // Populate the form for editing
    foreach ($result as $record) {
        $filePath = $record['file_path'];
    }

    // Form for selecting a local file to upload
    echo "<form action='documentUpdate.php' method='post' enctype='multipart/form-data'>";
    echo "<input type='hidden' name='document_id' value='" . $documentID . "'>";
    echo "<p>Current File Path: $filePath</p>";
    echo "<p>Select New File: <input type='file' name='file' required></p>";
    echo "<p><input type='submit' name='submit' value='Update File Path'></p>";
    echo "</form>";
}
?>