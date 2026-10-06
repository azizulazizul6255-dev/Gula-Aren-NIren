<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../config/database.php';

$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
$orders = $pdo->query("SELECT * FROM orders ORDER BY id DESC LIMIT 20")->fetchAll();
$totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalSales = $pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status <> 'dibatalkan'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard Niren</title>
<style>
body{font-family:Arial,sans-serif;background:#f6eedd;color:#2a1b10;margin:0}
header{background:#33200f;color:#fff;padding:18px 5%;display:flex;justify-content:space-between}
main{width:min(1100px,92%);margin:30px auto}
.cards{display:grid;grid-template-columns:repeat(3,1fr);gap:15px}
.card,section{background:#fff;padding:20px;border-radius:10px;margin-bottom:20px}
table{width:100%;border-collapse:collapse}
th,td{padding:10px;border-bottom:1px solid #ddd;text-align:left}
a{color:inherit}
@media(max-width:700px){.cards{grid-template-columns:1fr}}
</style>
</head>
<body>
<header>
<strong>Niren Admin</strong>
<div><a href="orders.php" style="margin-right:16px">Pesanan</a><a href="logout.php">Logout</a></div>
</header>
<main>
<div class="cards">
<div class="card"><small>Total Produk</small><h2><?= $totalProducts ?></h2></div>
<div class="card"><small>Total Pesanan</small><h2><?= $totalOrders ?></h2></div>
<div class="card"><small>Total Penjualan</small><h2>Rp<?= number_format($totalSales,0,',','.') ?></h2></div>
</div>

<section>
<h2>Produk <a href="products.php" style="font-size:14px">[Kelola Produk]</a></h2>
<table>
<tr><th>Produk</th><th>Harga</th><th>Stok</th><th>Kategori</th></tr>
<?php foreach ($products as $p): ?>
<tr>
<td><?= htmlspecialchars($p['name']) ?></td>
<td>Rp<?= number_format($p['price'],0,',','.') ?></td>
<td><?= $p['stock'] ?></td>
<td><?= htmlspecialchars($p['category']) ?></td>
</tr>
<?php endforeach; ?>
</table>
</section>

<section>
<h2>Pesanan Terbaru</h2>
<table>
<tr><th>Kode</th><th>Pelanggan</th><th>Total</th><th>Status</th><th>Tanggal</th></tr>
<?php foreach ($orders as $o): ?>
<tr>
<td><?= htmlspecialchars($o['order_code']) ?></td>
<td><?= htmlspecialchars($o['customer_name']) ?></td>
<td>Rp<?= number_format($o['total'],0,',','.') ?></td>
<td><?= htmlspecialchars($o['status']) ?></td>
<td><?= htmlspecialchars($o['created_at']) ?></td>
</tr>
<?php endforeach; ?>
</table>
</section>
</main>
</body>
</html>
