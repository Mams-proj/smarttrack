<?php
require 'config.php';

$data = json_decode(file_get_contents("php://input"), true);

$school   = trim($data['school_name'] ?? '');
$admin    = trim($data['admin_name'] ?? '');
$email    = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if (!$school || !$admin || !$email || !$password) {
    echo json_encode(["success"=>false, "message"=>"All fields are required"]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success"=>false, "message"=>"Invalid email"]);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (school_name, admin_name, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $school, $admin, $email, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode(["success"=>true, "message"=>"School registered successfully"]);
} else {
    echo json_encode(["success"=>false, "message"=>$stmt->error ?: "Registration failed (email may already exist)"]);
}
$stmt->close();
?>
