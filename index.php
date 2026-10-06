<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Niren</title>
<meta name="description" content="Niren menjual gula aren cetak, gula semut, dan gula aren cair asli, dimasak dengan cara tradisional dari petani aren lokal Indonesia.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<!-- SVG ICON SPRITE -->
<svg style="display:none" aria-hidden="true">
  <symbol id="i-leaf" viewBox="0 0 24 24"><path d="M5 19c8 0 13-5 13-14C9 5 4 10 4 18c0 .3 0 .7.1 1z"/><path d="M5 19c2-3 4.5-6 9-9.5"/></symbol>
  <symbol id="i-drop" viewBox="0 0 24 24"><path d="M12 3c3.5 4 6 7.4 6 10.5A6 6 0 016 13.5C6 10.4 8.5 7 12 3z"/></symbol>
  <symbol id="i-tree" viewBox="0 0 24 24"><path d="M12 21V10"/><path d="M12 10C9 10 6 8 5 5c3-1 6 0 7 3"/><path d="M12 10c3 0 6-2 7-5-3-1-6 0-7 3"/><path d="M9 21h6"/></symbol>
  <symbol id="i-box" viewBox="0 0 24 24"><path d="M3.5 7.5L12 3l8.5 4.5L12 12 3.5 7.5z"/><path d="M3.5 7.5V16l8.5 5 8.5-5V7.5"/><path d="M12 12v9"/></symbol>
  <symbol id="i-search" viewBox="0 0 24 24"><circle cx="10.5" cy="10.5" r="6.5"/><path d="M20 20l-4.8-4.8"/></symbol>
  <symbol id="i-bag" viewBox="0 0 24 24"><path d="M6 8h12l-1 12H7L6 8z"/><path d="M9 8V6a3 3 0 016 0v2"/></symbol>
  <symbol id="i-chat" viewBox="0 0 24 24"><path d="M4 12a8 8 0 1114.5 4.6L20 20l-3.6-1.1A8 8 0 014 12z"/></symbol>
  <symbol id="i-camera" viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7l1.5-3h5L16 7"/><circle cx="12" cy="13.5" r="3.5"/></symbol>
  <symbol id="i-mail" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 6l9 7 9-7"/></symbol>
  <symbol id="i-pin" viewBox="0 0 24 24"><path d="M12 21s7-6.5 7-11.5a7 7 0 10-14 0C5 14.5 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.3"/></symbol>
  <symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3.2 2"/></symbol>
  <symbol id="i-plus" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></symbol>
  <symbol id="i-close" viewBox="0 0 24 24"><path d="M5 5l14 14M19 5L5 19"/></symbol>
  <symbol id="i-arrow-up" viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"/></symbol>
</svg>

<!-- ============ NAVBAR ============ -->
<header class="navbar at-top" id="navbar">
  <div class="wrap nav-inner">
    <a href="#top" class="logo"><img src="logoniren.jpg" alt="Niren" class="logo-img"></a>
    <nav class="nav-links" id="navLinks">
      <a href="#produk" class="nav-link">Produk</a>
      <a href="#keunggulan" class="nav-link">Keunggulan</a>
      <a href="#faq" class="nav-link">FAQ</a>
      <a href="#kontak" class="nav-link">Kontak</a>
    </nav>
    <div class="nav-actions">
      <button class="cart-btn" id="cartBtn" aria-label="Buka keranjang">
        <svg class="icon" viewBox="0 0 24 24"><use href="#i-bag"/></svg>
        <span class="cart-count" id="cartCount">0</span>
      </button>
      <button class="hamburger" id="hamburger" aria-label="Menu"><span></span><span></span><span></span></button>
    </div>
  </div>
</header>

<!-- ============ HERO ============ -->
<section class="hero" id="top">
  <div class="wrap">
    <div class="hero-grid">
      <div class="hero-copy">
        <span class="tag"><svg class="icon" style="width:15px;height:15px"><use href="#i-leaf"/></svg>Niren Aren Sugar Makassar</span>
        <h1>Niren adalah gula aren bubuk yang fokus rasanya adalah bold dan creamy</h1>
        <div class="hero-actions">
          <a href="#produk" class="btn btn-primary">Lihat katalog produk</a>
          <a href="#kontak" class="btn btn-outline-clay">Hubungi kami</a>
        </div>
        <div class="hero-stats">
          <div class="stat"><strong>3</strong><span>produk pilihan</span></div>
        </div>
      </div>
      <div class="hero-visual">
        <img src="logoniren.jpg" alt="Produk Niren Aren Sugar" class="hero-visual-img">
      </div>
    </div>
  </div>
</section>

<!-- ============ KEUNGGULAN ============ -->
<section class="section" id="keunggulan">
  <div class="wrap">
    <div class="section-head">
      <span class="tag"><svg class="icon" style="width:15px;height:15px"><use href="#i-leaf"/></svg>Gula Aren Bubuk Bisa Buat Apa Saja?</span>
    </div>
    <div class="perks">
      <div class="perk">
        <div class="perk-icon"><svg class="icon"><use href="#i-leaf"/></svg></div>
        <div><h3>Cookies</h3><p>Cocok digunakan sebagai salah satu bahan dalam adonan cookies.</p></div>
      </div>
      <div class="perk">
        <div class="perk-icon"><svg class="icon"><use href="#i-drop"/></svg></div>
        <div><h3>Pisang goreng</h3><p>Bikin pisang goreng makin spesial dengan gula aren bubuk.</p></div>
      </div>
      <div class="perk">
        <div class="perk-icon"><svg class="icon"><use href="#i-tree"/></svg></div>
        <div><h3>Kopi gula aren</h3><p>Kamu juga bisa bikin kopi gula aren sendiri!</p></div>
      </div>
    </div>
  </div>
</section>

<!-- ============ PRODUK ============ -->
<section class="section" id="produk">
  <div class="wrap">
    <div class="section-head">
      <span class="tag"><svg class="icon" style="width:15px;height:15px"><use href="#i-box"/></svg>Katalog</span>
      <h2>Pilih varian gula aren</h2>
      <p>Semua produk dikirim segar dari batch terbaru. Pilih jumlah, lalu tambahkan ke keranjang.</p>
    </div>
    <div class="produk-controls">
      <div class="search-box">
        <svg class="icon"><use href="#i-search"/></svg>
        <input type="text" id="searchInput" placeholder="Cari produk...">
      </div>
      <div class="filter-tabs" id="filterTabs">
        <button class="filter-tab active" data-filter="semua">Semua</button>
        <button class="filter-tab" data-filter="cetak">Gula Aren</button>
        <button class="filter-tab" data-filter="creamer">Creamer</button>
      </div>
    </div>
    <div class="produk-grid" id="produkGrid"></div>
    <p class="empty-state" id="emptyState" hidden>Produk tidak ditemukan. Coba kata kunci lain.</p>
  </div>
</section>

<!-- ============ CARA PESAN ============ -->
<section class="section" id="cara-pesan">
  <div class="wrap">
    <div class="section-head">
      <span class="tag"><svg class="icon" style="width:15px;height:15px"><use href="#i-bag"/></svg>Cara pesan</span>
      <h2>Empat langkah, tanpa ribet</h2>
    </div>
    <div class="steps">
      <div class="step"><div class="step-num">1</div><h3>Pilih produk</h3><p>Tentukan varian dan jumlah gula aren yang Anda inginkan dari katalog.</p></div>
      <div class="step"><div class="step-num">2</div><h3>Masuk keranjang</h3><p>Klik "Tambah ke keranjang" pada produk yang sudah dipilih.</p></div>
      <div class="step"><div class="step-num">3</div><h3>Checkout WhatsApp</h3><p>Klik "Checkout via WhatsApp", pesanan otomatis terangkum rapi.</p></div>
      <div class="step"><div class="step-num">4</div><h3>Konfirmasi & kirim</h3><p>Tim kami konfirmasi pembayaran, lalu pesanan segera dikirim.</p></div>
    </div>
  </div>
</section>

<!-- ============ FAQ ============ -->
<section class="section" id="faq">
  <div class="wrap" style="max-width:760px">
    <div class="section-head">
      <span class="tag"><svg class="icon" style="width:15px;height:15px"><use href="#i-mail"/></svg>Pertanyaan umum</span>
      <h2>Yang sering ditanyakan</h2>
    </div>
    <div class="faq-list" id="faqList">
      <div class="faq-item">
        <button class="faq-q"><span>Niren ini produk apa kak?</span><svg class="icon"><use href="#i-plus"/></svg></button>
        <div class="faq-a"><p>Niren adalah produk gula aren bubuk yang fokus rasanya adalah bold dan creamy.</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-q"><span>Berapa lama masa simpan produknya?</span><svg class="icon"><use href="#i-plus"/></svg></button>
        <div class="faq-a"><p>Aren bubuk itu 2 tahun, krimer 1 tahun</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-q"><span>Niren produknya apa saja?</span><svg class="icon"><use href="#i-plus"/></svg></button>
        <div class="faq-a"><p>Ada aren bubuk dan krimmer premium</p></div>
      </div>
      <div class="faq-item">
        <button class="faq-q"><span>Sistem pengirimannya gimana kak?</span><svg class="icon"><use href="#i-plus"/></svg></button>
        <div class="faq-a"><p>Pengiriman di dalam kota di antar di via kurir, dan luar kota melalui eksepedisi, jnt, jne, dan semacamnya</p></div>
      </div>
    </div>
  </div>
</section>

<!-- ============ KONTAK ============ -->
<section class="section clay-zone" id="kontak">
  <div class="wrap">
    <div class="kontak-grid">
      <div class="kontak-info">
        <div class="section-head">
          <span class="tag"><svg class="icon" style="width:15px;height:15px"><use href="#i-chat"/></svg>Hubungi kami</span>
          <h2 style="color:var(--on-clay)">Ada pertanyaan sebelum pesan?</h2>
          <p>Tim Niren siap bantu, dari pertanyaan produk sampai pesanan dalam jumlah besar.</p>
        </div>
        <div class="info-row"><svg class="icon"><use href="#i-pin"/></svg><div><strong>Alamat</strong><span>Jl. Waduk Tunggu Pampang No.D/23, Antang, Kec. Manggala, Kota Makassa, Sulawesi Selatan</span></div></div>
        <div class="info-row"><svg class="icon"><use href="#i-chat"/></svg><div><strong>WhatsApp</strong><span>+62 8134128661 </span></div></div>
        <div class="info-row"><svg class="icon"><use href="#i-mail"/></svg><div><strong>Email</strong><span>-*</span></div></div>
        <div class="info-row"><svg class="icon"><use href="#i-clock"/></svg><div><strong>Jam operasional</strong><span>Senin–Sabtu, 08.00–17.00 WIB</span></div></div>
        <div class="social-row">
          <a href="#" class="social-btn" aria-label="WhatsApp"><svg class="icon" style="width:18px;height:18px"><use href="#i-chat"/></svg></a>
          <a href="#" class="social-btn" aria-label="Instagram"><svg class="icon" style="width:18px;height:18px"><use href="#i-camera"/></svg></a>
          <a href="#" class="social-btn" aria-label="Email"><svg class="icon" style="width:18px;height:18px"><use href="#i-mail"/></svg></a>
        </div>
      </div>
      <div class="form-card">
        <form id="contactForm">
          <div class="field"><label for="cfName">Nama</label><input type="text" id="cfName" required></div>
          <div class="field"><label for="cfPhone">No. WhatsApp</label><input type="tel" id="cfPhone" required></div>
          <div class="field"><label for="cfMsg">Pesan</label><textarea id="cfMsg" placeholder="Tulis pertanyaan atau pesanan Anda..." required></textarea></div>
          <button type="submit" class="btn btn-primary btn-block">Kirim pesan via WhatsApp</button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="footer clay-zone">
  <div class="wrap footer-inner">
    <span class="logo" style="font-size:1.2rem">Niren</span>
    <p id="footerYear">2026 Niren Aren Sugar</p>
  </div>
</footer>

<!-- ============ CART DRAWER ============ -->
<div class="overlay" id="overlay"></div>
<aside class="cart-drawer" id="cartDrawer">
  <div class="cart-head">
    <h3>Keranjang Anda</h3>
    <button id="cartClose" aria-label="Tutup"><svg class="icon"><use href="#i-close"/></svg></button>
  </div>
  <div class="cart-items" id="cartItems"></div>
  <div class="cart-foot">
    <div class="cart-total-row"><span>Total</span><span id="cartTotal">Rp0</span></div>
    <button class="btn btn-primary btn-block" id="checkoutBtn">Checkout via WhatsApp</button>
  </div>
</aside>

<div class="checkout-modal" id="checkoutModal" aria-hidden="true">
  <div class="checkout-card">
    <button class="checkout-close" id="checkoutModalClose" type="button" aria-label="Tutup">×</button>
    <h3>Data pengiriman</h3>
    <p class="checkout-note">Pesanan disimpan ke database, lalu detailnya dibuka di WhatsApp Niren.</p>
    <div class="checkout-summary" id="checkoutSummary"></div>
    <div class="checkout-total"><span>Total</span><strong id="checkoutTotal">Rp0</strong></div>
    <form id="checkoutForm">
      <div class="field"><label for="checkoutName">Nama</label><input id="checkoutName" required></div>
      <div class="field"><label for="checkoutPhone">No. WhatsApp</label><input id="checkoutPhone" type="tel" required></div>
      <div class="field"><label for="checkoutAddress">Alamat pengiriman</label><textarea id="checkoutAddress" required></textarea></div>
      <div class="checkout-actions">
        <button class="btn btn-outline-clay" id="checkoutCancel" type="button">Batal</button>
        <button class="btn btn-primary" id="checkoutSubmit" type="submit">Simpan & lanjut ke WhatsApp</button>
      </div>
    </form>
  </div>
</div>

<div class="toast" id="toast"></div>
<button class="back-top" id="backTop" aria-label="Kembali ke atas">
  <svg class="icon"><use href="#i-arrow-up"/></svg>
</button>

<script src="script.js"></script>
</body>
</html>
