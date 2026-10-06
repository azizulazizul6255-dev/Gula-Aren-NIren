<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $status = $_POST['status'] ?? 'baru';
    $allowed = ['baru','diproses','dikirim','selesai','dibatalkan'];
    if ($id > 0 && in_array($status, $allowed, true)) {
        $stmt = $pdo->prepare('UPDATE orders SET status=? WHERE id=?');
        $stmt->execute([$status, $id]);
    }
    header('Location: orders.php');
    exit;
}

$orders = $pdo->query('SELECT * FROM orders ORDER BY id DESC')->fetchAll();
$itemsStmt = $pdo->prepare('SELECT product_name, price, qty, subtotal FROM order_items WHERE order_id=? ORDER BY id ASC');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Pesanan - Niren Admin</title>
<style>
body{font-family:Arial,sans-serif;background:#f6eedd;color:#2a1b10;margin:0}main{width:min(1150px,94%);margin:30px auto}header{background:#33200f;color:#fff;padding:18px 5%;display:flex;justify-content:space-between}.top a{color:#fff;margin-left:15px}.order{background:#fff;border-radius:12px;padding:18px;margin:15px 0;box-shadow:0 4px 18px #0000000c}.meta{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:12px}.meta div{background:#f8f3e9;padding:10px;border-radius:8px}.items{width:100%;border-collapse:collapse}.items th,.items td{padding:8px;border-bottom:1px solid #eee;text-align:left}.status{display:flex;gap:8px;align-items:center}.status select{padding:8px}.status button{padding:8px 12px;background:#72b81c;border:0;border-radius:6px;cursor:pointer}@media(max-width:700px){.meta{grid-template-columns:1fr 1fr}}
</style>
</head>
<body>
<header><strong>Niren Admin</strong><div class="top"><a href="dashboard.php">Dashboard</a><a href="logout.php">Logout</a></div></header>
<main><h1>Pesanan</h1>
<?php if (!$orders): ?><div class="order">Belum ada pesanan.</div><?php endif; ?>
<?php foreach($orders as $o): ?>
<?php $itemsStmt->execute([$o['id']]); $items=$itemsStmt->fetchAll(); ?>
<div class="order">
  <h2><?= htmlspecialchars($o['order_code']) ?></h2>
  <div class="meta">
    <div><small>Pelanggan</small><br><strong><?= htmlspecialchars($o['customer_name']) ?></strong></div>
    <div><small>WhatsApp</small><br><?= htmlspecialchars($o['phone']) ?></div>
    <div><small>Total</small><br><strong>Rp<?= number_format($o['total'],0,',','.') ?></strong></div>
    <div><small>Tanggal</small><br><?= htmlspecialchars($o['created_at']) ?></div>
  </div>
  <p><strong>Alamat:</strong> <?= nl2br(htmlspecialchars($o['address'])) ?></p>
  <table class="items"><tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr>
  <?php foreach($items as $i): ?><tr><td><?= htmlspecialchars($i['product_name']) ?></td><td>Rp<?= number_format($i['price'],0,',','.') ?></td><td><?= $i['qty'] ?></td><td>Rp<?= number_format($i['subtotal'],0,',','.') ?></td></tr><?php endforeach; ?></table>
  <form method="post" class="status" style="margin-top:14px"><input type="hidden" name="id" value="<?= $o['id'] ?>"><label>Status:</label><select name="status"><option value="baru" <?= $o['status']==='baru'?'selected':'' ?>>Baru</option><option value="diproses" <?= $o['status']==='diproses'?'selected':'' ?>>Diproses</option><option value="dikirim" <?= $o['status']==='dikirim'?'selected':'' ?>>Dikirim</option><option value="selesai" <?= $o['status']==='selesai'?'selected':'' ?>>Selesai</option><option value="dibatalkan" <?= $o['status']==='dibatalkan'?'selected':'' ?>>Dibatalkan</option></select><button>Simpan Status</button></form>
</div>
<?php endforeach; ?>
</main>
</body></html>
