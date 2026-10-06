(function(){
  "use strict";

  var products = [];
  var currentFilter = "semua";
  var currentSearch = "";
  var stepperQty = {};
  var cart = loadCart();

  function loadCart(){
    try {
      var raw = localStorage.getItem("niren_cart");
      return raw ? JSON.parse(raw) : [];
    } catch(e){ return []; }
  }
  function saveCart(){
    try { localStorage.setItem("niren_cart", JSON.stringify(cart)); } catch(e){}
  }
  function formatRupiah(n){
    return "Rp" + n.toLocaleString("id-ID");
  }

  var grid = document.getElementById("produkGrid");
  var emptyState = document.getElementById("emptyState");

  function cardTemplate(p){
    var qty = stepperQty[p.id] || 1;
    var badge = p.badge ? '<span class="produk-badge">' + p.badge + '</span>' : '';
    return (
      '<div class="produk-card">' +
        '<div class="produk-top">' +
          '<img src="' + encodeURI(p.image || "") + '" alt="' + p.name + '" class="produk-img" onerror="this.onerror=null;this.src=\'logoniren.jpg\';">' +
          badge +
        '</div>' +
        '<div class="produk-body">' +
          '<h3>' + p.name + '</h3>' +
          '<span class="produk-unit">' + p.unit + '</span>' +
          '<p class="produk-desc">' + p.desc + '</p>' +
          '<div class="produk-footer">' +
            '<span class="produk-price">' + formatRupiah(p.price) + '</span>' +
            '<div class="qty-stepper">' +
              '<button class="qty-btn" data-action="dec" data-id="' + p.id + '">−</button>' +
              '<span class="qty-value" id="qty-' + p.id + '">' + qty + '</span>' +
              '<button class="qty-btn" data-action="inc" data-id="' + p.id + '">+</button>' +
            '</div>' +
          '</div>' +
          '<button class="btn btn-primary btn-block add-cart-btn" data-id="' + p.id + '">Tambah ke keranjang</button>' +
        '</div>' +
      '</div>'
    );
  }

  function renderProducts(){
    var filtered = products.filter(function(p){
      var matchCat = currentFilter === "semua" || p.category === currentFilter;
      var matchSearch = p.name.toLowerCase().indexOf(currentSearch.toLowerCase()) !== -1;
      return matchCat && matchSearch;
    });
    grid.innerHTML = filtered.map(cardTemplate).join("");
    emptyState.hidden = filtered.length > 0;
  }

  grid.addEventListener("click", function(e){
    var qtyBtn = e.target.closest(".qty-btn");
    if (qtyBtn){
      var id = parseInt(qtyBtn.dataset.id, 10);
      var current = stepperQty[id] || 1;
      var delta = qtyBtn.dataset.action === "inc" ? 1 : -1;
      var next = Math.max(1, current + delta);
      stepperQty[id] = next;
      var el = document.getElementById("qty-" + id);
      if (el) el.textContent = next;
      return;
    }
    var addBtn = e.target.closest(".add-cart-btn");
    if (addBtn){
      addToCart(parseInt(addBtn.dataset.id, 10));
    }
  });

  document.getElementById("searchInput").addEventListener("input", function(e){
    currentSearch = e.target.value;
    renderProducts();
  });

  var filterTabs = document.getElementById("filterTabs");
  filterTabs.addEventListener("click", function(e){
    var tab = e.target.closest(".filter-tab");
    if (!tab) return;
    filterTabs.querySelectorAll(".filter-tab").forEach(function(t){ t.classList.remove("active"); });
    tab.classList.add("active");
    currentFilter = tab.dataset.filter;
    renderProducts();
  });

  /* ===== CART LOGIC ===== */
  function addToCart(id){
    var qty = stepperQty[id] || 1;
    var existing = cart.find(function(c){ return c.id === id; });
    if (existing) { existing.qty += qty; } else { cart.push({ id: id, qty: qty }); }
    saveCart();
    updateCartUI();
    stepperQty[id] = 1;
    var el = document.getElementById("qty-" + id);
    if (el) el.textContent = "1";
    showToast("Ditambahkan ke keranjang");
  }

  function changeCartQty(id, delta){
    var item = cart.find(function(c){ return c.id === id; });
    if (!item) return;
    item.qty += delta;
    if (item.qty <= 0) cart = cart.filter(function(c){ return c.id !== id; });
    saveCart();
    updateCartUI();
  }

  function removeFromCart(id){
    cart = cart.filter(function(c){ return c.id !== id; });
    saveCart();
    updateCartUI();
  }

  function cartTotal(){
    return cart.reduce(function(sum, c){
      var p = products.find(function(pp){ return pp.id === c.id; });
      return sum + (p ? p.price * c.qty : 0);
    }, 0);
  }

  var cartItemsEl = document.getElementById("cartItems");
  var cartCountEl = document.getElementById("cartCount");
  var cartTotalEl = document.getElementById("cartTotal");

  function cartLineTemplate(p, qty){
    return (
      '<div class="cart-line">' +
        '<div class="cart-line-thumb"><img src="' + p.image + '" alt="' + p.name + '"></div>' +
        '<div class="cart-line-info">' +
          '<strong>' + p.name + '</strong>' +
          '<span>' + p.unit + ' · ' + formatRupiah(p.price) + '</span>' +
          '<div class="cart-line-actions">' +
            '<div class="qty-stepper">' +
              '<button class="qty-btn cart-qty" data-action="dec" data-id="' + p.id + '">−</button>' +
              '<span class="qty-value">' + qty + '</span>' +
              '<button class="qty-btn cart-qty" data-action="inc" data-id="' + p.id + '">+</button>' +
            '</div>' +
            '<button class="cart-remove" data-id="' + p.id + '">Hapus</button>' +
          '</div>' +
        '</div>' +
      '</div>'
    );
  }

  function updateCartUI(){
    var totalQty = cart.reduce(function(s, c){ return s + c.qty; }, 0);
    cartCountEl.textContent = totalQty;
    if (cart.length === 0){
      cartItemsEl.innerHTML = '<p class="cart-empty">Keranjang masih kosong.<br>Yuk pilih gula aren favoritmu.</p>';
    } else {
      cartItemsEl.innerHTML = cart.map(function(c){
        var p = products.find(function(pp){ return pp.id === c.id; });
        return p ? cartLineTemplate(p, c.qty) : "";
      }).join("");
    }
    cartTotalEl.textContent = formatRupiah(cartTotal());
  }

  cartItemsEl.addEventListener("click", function(e){
    var qtyBtn = e.target.closest(".cart-qty");
    if (qtyBtn){
      changeCartQty(parseInt(qtyBtn.dataset.id, 10), qtyBtn.dataset.action === "inc" ? 1 : -1);
      return;
    }
    var removeBtn = e.target.closest(".cart-remove");
    if (removeBtn) removeFromCart(parseInt(removeBtn.dataset.id, 10));
  });

  var WA_NUMBER = "628134128661"; /* Nomor WhatsApp toko */

  document.getElementById("checkoutBtn").addEventListener("click", function(){
    if (cart.length === 0){ showToast("Keranjang masih kosong"); return; }
    openCheckoutModal();
  });

  function openCheckoutModal(){
    var modal = document.getElementById("checkoutModal");
    if (!modal) return;
    document.getElementById("checkoutSummary").innerHTML = cart.map(function(c){
      var p = products.find(function(pp){ return pp.id === c.id; });
      return p ? '<div><strong>' + p.name + '</strong> × ' + c.qty + ' — ' + formatRupiah(p.price * c.qty) + '</div>' : '';
    }).join('');
    document.getElementById("checkoutTotal").textContent = formatRupiah(cartTotal());
    modal.classList.add("open");
    document.getElementById("checkoutName").focus();
  }

  function closeCheckoutModal(){
    var modal = document.getElementById("checkoutModal");
    if (modal) modal.classList.remove("open");
  }

  document.getElementById("checkoutCancel").addEventListener("click", closeCheckoutModal);
  document.getElementById("checkoutModalClose").addEventListener("click", closeCheckoutModal);
  document.getElementById("checkoutModal").addEventListener("click", function(e){
    if (e.target === this) closeCheckoutModal();
  });

  document.getElementById("checkoutForm").addEventListener("submit", function(e){
    e.preventDefault();
    var name = document.getElementById("checkoutName").value.trim();
    var phone = document.getElementById("checkoutPhone").value.trim();
    var address = document.getElementById("checkoutAddress").value.trim();
    var submit = document.getElementById("checkoutSubmit");

    if (!name || !phone || !address) return;
    submit.disabled = true;
    submit.textContent = "Menyimpan pesanan...";

    fetch("api/orders.php", {
      method: "POST",
      headers: {"Content-Type": "application/json"},
      body: JSON.stringify({
        customer_name: name,
        phone: phone,
        address: address,
        items: cart.map(function(c){ return {id: c.id, qty: c.qty}; })
      })
    })
    .then(function(response){ return response.json(); })
    .then(function(data){
      if (!data.success) throw new Error(data.message || "Pesanan gagal disimpan.");

      var lines = cart.map(function(c){
        var p = products.find(function(pp){ return pp.id === c.id; });
        return p ? "- " + p.name + " (" + p.unit + ") x" + c.qty + " = " + formatRupiah(p.price * c.qty) : "";
      });
      var text = "Halo Niren, saya ingin memesan:\n\n" + lines.join("\n") +
        "\n\nTotal: " + formatRupiah(data.total) +
        "\nKode Pesanan: " + data.order_code +
        "\nNama: " + name +
        "\nNo. WhatsApp: " + phone +
        "\nAlamat: " + address;

      window.open("https://wa.me/" + WA_NUMBER + "?text=" + encodeURIComponent(text), "_blank");
      cart = [];
      saveCart();
      updateCartUI();
      closeCheckoutModal();
      closeCart();
      document.getElementById("checkoutForm").reset();
      showToast("Pesanan " + data.order_code + " berhasil disimpan");
      loadProductsFromDatabase();
    })
    .catch(function(error){
      showToast(error.message || "Gagal menyimpan pesanan");
    })
    .finally(function(){
      submit.disabled = false;
      submit.textContent = "Simpan & lanjut ke WhatsApp";
    });
  });

  /* ===== CART DRAWER OPEN/CLOSE ===== */
  var overlay = document.getElementById("overlay");
  var cartDrawer = document.getElementById("cartDrawer");
  function openCart(){ cartDrawer.classList.add("open"); overlay.classList.add("open"); }
  function closeCart(){ cartDrawer.classList.remove("open"); overlay.classList.remove("open"); }
  document.getElementById("cartBtn").addEventListener("click", openCart);
  document.getElementById("cartClose").addEventListener("click", closeCart);
  overlay.addEventListener("click", closeCart);

  /* ===== CONTACT FORM -> WHATSAPP ===== */
  document.getElementById("contactForm").addEventListener("submit", function(e){
    e.preventDefault();
    var form = this;
    var name = document.getElementById("cfName").value.trim();
    var phone = document.getElementById("cfPhone").value.trim();
    var msg = document.getElementById("cfMsg").value.trim();

    fetch("api/contact.php", {
      method: "POST",
      headers: {"Content-Type": "application/json"},
      body: JSON.stringify({name: name, phone: phone, message: msg})
    })
    .then(function(response){ return response.json(); })
    .then(function(data){
      if (!data.success) throw new Error(data.message || "Pesan gagal disimpan.");
      var text = "Halo Niren, saya " + name + " (" + phone + ").\n\n" + msg;
      window.open("https://wa.me/" + WA_NUMBER + "?text=" + encodeURIComponent(text), "_blank");
      form.reset();
      showToast("Pesan berhasil dikirim");
    })
    .catch(function(error){ showToast(error.message || "Gagal mengirim pesan"); });
  });

  /* ===== MOBILE NAV ===== */
  var hamburger = document.getElementById("hamburger");
  var navLinks = document.getElementById("navLinks");
  hamburger.addEventListener("click", function(){
    hamburger.classList.toggle("open");
    navLinks.classList.toggle("open");
  });
  navLinks.querySelectorAll(".nav-link").forEach(function(link){
    link.addEventListener("click", function(){
      hamburger.classList.remove("open");
      navLinks.classList.remove("open");
    });
  });

  /* ===== NAVBAR SCROLL STATE + BACK TO TOP ===== */
  var navbar = document.getElementById("navbar");
  var backTop = document.getElementById("backTop");
  window.addEventListener("scroll", function(){
    if (window.scrollY > 40){
      navbar.classList.remove("at-top"); navbar.classList.add("scrolled");
    } else {
      navbar.classList.add("at-top"); navbar.classList.remove("scrolled");
    }
    if (window.scrollY > 500) backTop.classList.add("show"); else backTop.classList.remove("show");
  });
  backTop.addEventListener("click", function(){ window.scrollTo({ top: 0, behavior: "smooth" }); });

  /* ===== FAQ ACCORDION ===== */
  document.querySelectorAll(".faq-item").forEach(function(item){
    var q = item.querySelector(".faq-q");
    var a = item.querySelector(".faq-a");
    q.addEventListener("click", function(){
      var isOpen = item.classList.contains("open");
      document.querySelectorAll(".faq-item").forEach(function(other){
        other.classList.remove("open");
        other.querySelector(".faq-a").style.maxHeight = null;
      });
      if (!isOpen){
        item.classList.add("open");
        a.style.maxHeight = a.scrollHeight + "px";
      }
    });
  });

  /* ===== TOAST ===== */
  var toastEl = document.getElementById("toast");
  var toastTimer;
  function showToast(msg){
    toastEl.textContent = msg;
    toastEl.classList.add("show");
    clearTimeout(toastTimer);
    toastTimer = setTimeout(function(){ toastEl.classList.remove("show"); }, 2200);
  }

  /* ===== INIT ===== */
  document.getElementById("footerYear").textContent = "© " + new Date().getFullYear() + " Niren Aren Sugar.";
  updateCartUI();

  /* Ambil produk dari MySQL melalui PHP. Jika API belum aktif,
     tampilkan data cadangan supaya katalog tidak kosong. */
  async function loadProductsFromDatabase(){
    try {
      var response = await fetch("api/products.php", { cache: "no-store" });
      if (!response.ok) throw new Error("HTTP " + response.status);

      var data = await response.json();
      if (!data.success || !Array.isArray(data.products)) {
        throw new Error("Format data produk tidak valid.");
      }

      products = data.products.map(function(p){
        return {
          id: Number(p.id),
          name: p.name,
          category: p.category,
          price: Number(p.price),
          unit: p.unit || "1kg",
          desc: p.description || "",
          image: p.image || "",
          badge: p.badge || "",
          stock: Number(p.stock || 0)
        };
      });

      renderProducts();
    } catch (error) {
      console.error("Gagal mengambil produk dari database:", error);

      /* Fallback hanya untuk menjaga tampilan katalog jika PHP/MySQL
         belum aktif. Saat API normal, data tetap berasal dari MySQL. */
      products = [
        {
          id: 1,
          name: "Niren Hijau",
          category: "cetak",
          price: 50000,
          unit: "1kg",
          desc: "Untuk kamu yang suka rasa manis dan creamy.",
          image: "nirenhijau.jpg",
          badge: "Terlaris",
          stock: 100
        },
        {
          id: 2,
          name: "Niren Orange",
          category: "cetak",
          price: 50000,
          unit: "1kg",
          desc: "Untuk kamu yang suka Aren dengan rasa yang bold.",
          image: "nirenorange.jpg",
          badge: "Favorit",
          stock: 100
        },
        {
          id: 3,
          name: "Crimer",
          category: "creamer",
          price: 45000,
          unit: "1kg",
          desc: "Creamer powder yang pas dipadukan dengan gula aren Niren, larut cepat dan bikin minuman lebih creamy.",
          image: "crimer.jpg",
          badge: "Favorit",
          stock: 100
        }
      ];
      renderProducts();
    }
  }

  loadProductsFromDatabase();
})();