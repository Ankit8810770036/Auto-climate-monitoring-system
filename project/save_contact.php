<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "climasense_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => "Connection failed: " . $conn->connect_error]));
}

// Get form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';
$submission_date = date('Y-m-d H:i:s');

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message, submission_date) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $subject, $message, $submission_date);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Thank you for your message. We will get back to you soon!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>