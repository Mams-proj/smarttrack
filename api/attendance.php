<?php
require 'config.php';

$data = json_decode(file_get_contents("php://input"), true);
$rfid = trim($data['rfid'] ?? '');

if (!$rfid) {
    echo json_encode(["success"=>false, "error"=>"RFID missing"]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM students WHERE rfid = ?");
$stmt->bind_param("s", $rfid);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows == 0) {
    echo json_encode(["success"=>false, "error"=>"Student not found"]);
    exit;
}

$student = $res->fetch_assoc();

// Record attendance
$stmt2 = $conn->prepare("INSERT INTO attendance (rfid, name) VALUES (?, ?)");
$stmt2->bind_param("ss", $student['rfid'], $student['name']);
$stmt2->execute();

// Update latest scan
$stmt3 = $conn->prepare("REPLACE INTO latest_scan (id, rfid, name) VALUES (1, ?, ?)");
$stmt3->bind_param("ss", $student['rfid'], $student['name']);
$stmt3->execute();

echo json_encode([
    "success" => true,
    "name" => $student['name'],
    "suspended" => (int)$student['suspended']
]);
?>
