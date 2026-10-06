<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $category = $_POST['category'] ?? 'cetak';
    $price = (float)($_POST['price'] ?? 0);
    $unit = trim($_POST['unit'] ?? '1kg');
    $description = trim($_POST['description'] ?? '');
    $badge = trim($_POST['badge'] ?? '');
    $stock = (int)($_POST['stock'] ?? 0);

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE products SET name=?, category=?, price=?, unit=?, description=?, badge=?, stock=? WHERE id=?");
        $stmt->execute([$name,$category,$price,$unit,$description,$badge,$stock,$id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (name,category,price,unit,description,badge,stock) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([$name,$category,$price,$unit,$description,$badge,$stock]);
    }

    header("Location: products.php");
    exit;
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
    $stmt->execute([$id]);
    header("Location: products.php");
    exit;
}

$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Kelola Produk - Niren</title>
<style>
body{font-family:Arial;background:#f6eedd;margin:0;color:#2a1b10}
main{width:min(1000px,94%);margin:30px auto}
form,.product{background:#fff;padding:18px;border-radius:10px;margin-bottom:18px}
input,select,textarea,button{width:100%;padding:10px;margin:6px 0 12px;box-sizing:border-box}
button{background:#72b81c;border:0;padding:12px;font-weight:bold;cursor:pointer}
table{width:100%;border-collapse:collapse;background:#fff}
th,td{padding:10px;border-bottom:1px solid #ddd;text-align:left}
</style>
</head>
<body>
<main>
<h1>Kelola Produk Niren</h1>
<p><a href="dashboard.php">← Dashboard</a> | <a href="logout.php">Logout</a></p>

<form method="post">
<h2>Tambah Produk</h2>
<input name="name" placeholder="Nama produk" required>
<select name="category"><option value="cetak">Gula Aren</option><option value="creamer">Creamer</option></select>
<input type="number" name="price" placeholder="Harga" required>
<input name="unit" value="1kg">
<input name="badge" placeholder="Badge, contoh: Favorit">
<input type="number" name="stock" value="0" min="0">
<textarea name="description" placeholder="Deskripsi produk"></textarea>
<button type="submit">Simpan Produk</button>
</form>

<table>
<tr><th>Produk</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr>
<?php foreach($products as $p): ?>
<tr>
<td><?= htmlspecialchars($p['name']) ?></td>
<td>Rp<?= number_format($p['price'],0,',','.') ?></td>
<td><?= $p['stock'] ?></td>
<td><a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Hapus produk ini?')">Hapus</a></td>
</tr>
<?php endforeach; ?>
</table>
</main>
</body>
</html>
