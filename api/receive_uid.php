<?php
require 'config.php';

$data = json_decode(file_get_contents("php://input"), true);
$uid = trim($data['uid'] ?? '');

if (!$uid) {
    echo json_encode(["success" => false, "error" => "UID missing"]);
    exit;
}

$stmt = $conn->prepare("REPLACE INTO latest_scan (id, rfid, name) VALUES (1, ?, 'New Card')");
$stmt->bind_param("s", $uid);
$stmt->execute();

echo json_encode(["success" => true]);
?>
