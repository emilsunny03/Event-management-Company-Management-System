<?php
require('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_email = $_POST['company_email'];
    $note_date = $_POST['note_date'];
    $note_text = $_POST['note_text'];

    // Insert or update the note for the given date
    $sql = "INSERT INTO calendar_notes (company_email, note_date, note_text) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE note_text = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $company_email, $note_date, $note_text, $note_text);

    if ($stmt->execute()) {
        echo "Note saved successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
header('Location: calendar.php');
?>
