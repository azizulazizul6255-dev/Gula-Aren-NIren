<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method tidak diizinkan"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$name = trim($data['name'] ?? '');
$phone = trim($data['phone'] ?? '');
$message = trim($data['message'] ?? '');

if ($name === '' || $phone === '' || $message === '') {
    http_response_code(422);
    echo json_encode(["success" => false, "message" => "Semua data kontak wajib diisi"]);
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO contacts (name, phone, message)
    VALUES (?, ?, ?)
");
$stmt->execute([$name, $phone, $message]);

echo json_encode([
    "success" => true,
    "message" => "Pesan berhasil disimpan."
], JSON_UNESCAPED_UNICODE);
?>