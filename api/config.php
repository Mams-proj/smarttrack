<?php
// config.php - Optimized for Render.com + ezyro hosting

$host     = 'sql100.byetcluster.com';
$db_user  = 'ezyro_41552429';
$db_pass  = '068e9dc4181';
$db_name  = 'ezyro_41552429_smarttrack';

ini_set('display_errors', 0);           // Change to 1 only for debugging
error_reporting(E_ALL);

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Database connection failed. Check config."
    ]);
    exit;
}

$conn->set_charset("utf8mb4");

// Always return JSON for API files
header("Content-Type: application/json; charset=utf-8");
?>
