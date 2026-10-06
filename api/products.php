<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config/database.php';

$stmt = $pdo->query("
    SELECT id, name, category, price, unit, description, image, badge, stock
    FROM products
    WHERE stock > 0
    ORDER BY id ASC
");

echo json_encode([
    "success" => true,
    "products" => $stmt->fetchAll()
], JSON_UNESCAPED_UNICODE);
?>