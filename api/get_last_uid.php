<?php
require 'config.php';

$res = $conn->query("SELECT rfid FROM latest_scan WHERE id=1");
$row = $res->fetch_assoc();

$uid = $row['rfid'] ?? '';

echo json_encode(["uid" => $uid]);
?>
