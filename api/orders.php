<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method tidak diizinkan"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$name = trim($data['customer_name'] ?? '');
$phone = trim($data['phone'] ?? '');
$address = trim($data['address'] ?? '');
$items = $data['items'] ?? [];

if ($name === '' || $phone === '' || empty($items)) {
    http_response_code(422);
    echo json_encode(["success" => false, "message" => "Nama, nomor WhatsApp, dan produk wajib diisi"]);
    exit;
}

try {
    $pdo->beginTransaction();

    $orderCode = 'NRN-' . date('YmdHis') . '-' . random_int(100, 999);

    $getProduct = $pdo->prepare("
        SELECT id, name, price, stock
        FROM products
        WHERE id = ?
        FOR UPDATE
    ");

    $total = 0;
    $cleanItems = [];

    foreach ($items as $item) {
        $productId = (int)($item['id'] ?? 0);
        $qty = (int)($item['qty'] ?? 0);

        if ($productId <= 0 || $qty <= 0) {
            throw new Exception("Data produk tidak valid.");
        }

        $getProduct->execute([$productId]);
        $product = $getProduct->fetch();

        if (!$product) {
            throw new Exception("Produk tidak ditemukan.");
        }

        if ($product['stock'] < $qty) {
            throw new Exception("Stok {$product['name']} tidak mencukupi.");
        }

        $subtotal = $product['price'] * $qty;
        $total += $subtotal;

        $cleanItems[] = [
            'product' => $product,
            'qty' => $qty,
            'subtotal' => $subtotal
        ];
    }

    $insertOrder = $pdo->prepare("
        INSERT INTO orders
        (order_code, customer_name, phone, address, total)
        VALUES (?, ?, ?, ?, ?)
    ");
    $insertOrder->execute([$orderCode, $name, $phone, $address, $total]);

    $orderId = $pdo->lastInsertId();

    $insertItem = $pdo->prepare("
        INSERT INTO order_items
        (order_id, product_id, product_name, price, qty, subtotal)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $updateStock = $pdo->prepare("
        UPDATE products SET stock = stock - ? WHERE id = ?
    ");

    foreach ($cleanItems as $item) {
        $p = $item['product'];

        $insertItem->execute([
            $orderId,
            $p['id'],
            $p['name'],
            $p['price'],
            $item['qty'],
            $item['subtotal']
        ]);

        $updateStock->execute([$item['qty'], $p['id']]);
    }

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "order_code" => $orderCode,
        "total" => $total
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>