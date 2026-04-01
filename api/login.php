<?php
require 'config.php';

$data = json_decode(file_get_contents("php://input"), true);

$username = trim($data['username'] ?? '');
$password = $data['password'] ?? '';

if (!$username || !$password) {
    echo json_encode(["success"=>false, "message"=>"Email and password required"]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo json_encode(["success"=>false, "message"=>"Invalid email or password"]);
    exit;
}

$user = $res->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    echo json_encode(["success"=>false, "message"=>"Invalid email or password"]);
    exit;
}

echo json_encode([
    "success" => true,
    "schoolName" => $user['school_name'],
    "adminName" => $user['admin_name']
]);
?>
