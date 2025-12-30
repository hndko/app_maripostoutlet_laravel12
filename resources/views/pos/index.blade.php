<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS - {{ $outlet->name }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            height: 100vh;
            overflow: hidden;
        }

        .pos-container {
            display: flex;
            height: 100vh;
        }

        /* Products Section */
        .products-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .pos-header {
            background: #fff;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pos-header h1 {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
        }

        .categories-bar {
            background: #fff;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            gap: 0.5rem;
            overflow-x: auto;
        }

        .category-btn {
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            border: 1px solid #e2e8f0;
            background: #fff;
            white-space: nowrap;
            cursor: pointer;
            transition: all 0.2s;
        }

        .category-btn:hover,
        .category-btn.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .search-bar {
            padding: 1rem;
        }

        .products-grid {
            flex: 1;
            overflow-y: auto;
            padding: 0 1rem 1rem;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
            align-content: start;
        }

        .product-card {
            background: #fff;
            border-radius: 1rem;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .product-card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }

        .product-card .info {
            padding: 0.75rem;
        }

        .product-card .name {
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-card .price {
            color: var(--primary);
            font-weight: 700;
        }

        .product-card.out-of-stock {
            opacity: 0.5;
            pointer-events: none;
        }

        /* Cart Section */
        .cart-section {
            width: 400px;
            background: #fff;
            display: flex;
            flex-direction: column;
            border-left: 1px solid #e2e8f0;
        }

        .cart-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-header h2 {
            font-size: 1rem;
            font-weight: 600;
            margin: 0;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
        }

        .cart-item {
            display: flex;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            background: #f8fafc;
            margin-bottom: 0.5rem;
        }

        .cart-item img {
            width: 50px;
            height: 50px;
            border-radius: 0.5rem;
            object-fit: cover;
        }

        .cart-item .details {
            flex: 1;
        }

        .cart-item .name {
            font-weight: 500;
            font-size: 0.875rem;
        }

        .cart-item .price {
            font-size: 0.75rem;
            color: #64748b;
        }

        .cart-item .qty-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cart-item .qty-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
            background: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-item .qty-btn:hover {
            background: var(--primary);
            color: #fff;
        }

        .cart-item .qty {
            font-weight: 600;
            min-width: 24px;
            text-align: center;
        }

        .cart-item .remove-btn {
            color: #ef4444;
            cursor: pointer;
        }

        .cart-summary {
            border-top: 1px solid #e2e8f0;
            padding: 1rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .summary-row.total {
            font-size: 1.25rem;
            font-weight: 700;
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .discount-input {
            margin-bottom: 1rem;
        }

        .checkout-btn {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 0.75rem;
        }

        .empty-cart {
            text-align: center;
            padding: 3rem 1rem;
            color: #94a3b8;
        }

        .empty-cart i {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        /* Payment Modal */
        .modal-content {
            border-radius: 1rem;
        }

        .payment-method-btn {
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            background: #fff;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
        }

        .payment-method-btn:hover,
        .payment-method-btn.active {
            border-color: var(--primary);
            background: rgba(99, 102, 241, 0.05);
        }

        .payment-method-btn i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        @media (max-width: 768px) {
            .cart-section {
                width: 100%;
                position: fixed;
                bottom: 0;
                height: 50vh;
            }
        }
    </style>
</head>

<body>
    <div class="pos-container">
        <!-- Products Section -->
        <div class="products-section">
            <div class="pos-header">
                <h1><i class="bi bi-shop me-2"></i>{{ $outlet->name }}</h1>
                <div class="d-flex gap-2">
                    <a href="{{ route('owner.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="categories-bar">
                <button class="category-btn active" onclick="filterCategory('')">Semua</button>
                @foreach($categories as $category)
                <button class="category-btn" onclick="filterCategory({{ $category->id }})">{{ $category->name
                    }}</button>
                @endforeach
            </div>

            <div class="search-bar">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari produk...">
                </div>
            </div>

            <div class="products-grid" id="productsGrid">
                <!-- Products loaded via JS -->
            </div>
        </div>

        <!-- Cart Section -->
        <div class="cart-section">
            <div class="cart-header">
                <h2><i class="bi bi-cart3 me-2"></i>Keranjang</h2>
                <button class="btn btn-outline-danger btn-sm" onclick="clearCart()">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <div class="cart-items" id="cartItems">
                <div class="empty-cart">
                    <i class="bi bi-cart-x"></i>
                    <p>Keranjang kosong</p>
                </div>
            </div>

            <div class="cart-summary">
                <div class="discount-input">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="discountCode" placeholder="Kode diskon">
                        <button class="btn btn-outline-primary" onclick="applyDiscount()">Terapkan</button>
                    </div>
                    <div id="discountInfo" class="mt-2 small text-success" style="display: none;"></div>
                </div>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="subtotal">Rp 0</span>
                </div>
                <div class="summary-row" id="discountRow" style="display: none;">
                    <span>Diskon</span>
                    <span id="discountAmount" class="text-success">- Rp 0</span>
                </div>
                <div class="summary-row">
                    <span>Pajak ({{ setting('tax_percentage', 0) }}%)</span>
                    <span id="taxAmount">Rp 0</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span id="totalAmount">Rp 0</span>
                </div>

                <button class="btn btn-primary checkout-btn" onclick="showCheckoutModal()" id="checkoutBtn" disabled>
                    <i class="bi bi-credit-card me-2"></i>Bayar
                </button>
            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-credit-card me-2"></i>Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6 class="mb-3">Pilih Metode Pembayaran</h6>
                    <div class="row g-2 mb-4" id="paymentMethods">
                        @foreach($paymentMethods as $method)
                        <div class="col-4">
                            <div class="payment-method-btn" data-id="{{ $method->id }}">
                                <i
                                    class="bi bi-{{ $method->type == 'cash' ? 'cash-coin' : ($method->type == 'qris_static' ? 'qr-code' : 'credit-card') }}"></i>
                                <div class="small">{{ $method->name }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Pelanggan (Opsional)</label>
                        <input type="text" class="form-control" id="customerName" placeholder="Masukkan nama">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Bayar</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="paidAmount" placeholder="0">
                        </div>
                    </div>

                    <div class="alert alert-info" id="changeInfo" style="display: none;">
                        Kembalian: <strong id="changeAmount">Rp 0</strong>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary flex-fill" onclick="fillExact()">Uang Pas</button>
                        <button class="btn btn-outline-secondary" onclick="fillAmount(50000)">50K</button>
                        <button class="btn btn-outline-secondary" onclick="fillAmount(100000)">100K</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="processCheckout()" id="processBtn">
                        <i class="bi bi-check-lg me-1"></i>Proses Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        const outletId = {{ $outlet->id }};
        const taxPercentage = {{ setting('tax_percentage', 0) }};
        let cart = [];
        let products = [];
        let appliedDiscount = null;
        let selectedPaymentMethod = null;

        toastr.options = { closeButton: true, progressBar: true, positionClass: 'toast-top-right' };

        // Load products
        function loadProducts(categoryId = '', search = '') {
            $.get('{{ route("pos.products", $outlet->id) }}', { category_id: categoryId, search: search }, function(data) {
                products = data;
                renderProducts();
            });
        }

        function renderProducts() {
            let html = '';
            products.forEach(p => {
                const outOfStock = p.use_stock && p.stock <= 0;
                html += `
                    <div class="product-card ${outOfStock ? 'out-of-stock' : ''}" onclick="addToCart(${p.id})">
                        <img src="${p.image || '/assets/backend/img/default-product.png'}" alt="${p.name}">
                        <div class="info">
                            <div class="name">${p.name}</div>
                            <div class="price">Rp ${numberFormat(p.price)}</div>
                            ${p.use_stock ? `<small class="text-muted">Stok: ${p.stock}</small>` : ''}
                        </div>
                    </div>
                `;
            });
            $('#productsGrid').html(html);
        }

        function filterCategory(categoryId) {
            $('.category-btn').removeClass('active');
            event.target.classList.add('active');
            loadProducts(categoryId, $('#searchInput').val());
        }

        function addToCart(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;

            const existing = cart.find(i => i.product_id === productId);
            if (existing) {
                if (product.use_stock && existing.quantity >= product.stock) {
                    toastr.warning('Stok tidak mencukupi');
                    return;
                }
                existing.quantity++;
            } else {
                cart.push({
                    product_id: productId,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    quantity: 1
                });
            }

            renderCart();
            toastr.success(`${product.name} ditambahkan`);
        }

        function updateQuantity(productId, delta) {
            const item = cart.find(i => i.product_id === productId);
            if (!item) return;

            item.quantity += delta;
            if (item.quantity <= 0) {
                cart = cart.filter(i => i.product_id !== productId);
            }

            renderCart();
        }

        function removeFromCart(productId) {
            cart = cart.filter(i => i.product_id !== productId);
            renderCart();
        }

        function clearCart() {
            cart = [];
            appliedDiscount = null;
            renderCart();
        }

        function renderCart() {
            if (cart.length === 0) {
                $('#cartItems').html('<div class="empty-cart"><i class="bi bi-cart-x"></i><p>Keranjang kosong</p></div>');
                $('#checkoutBtn').prop('disabled', true);
            } else {
                let html = '';
                cart.forEach(item => {
                    html += `
                        <div class="cart-item">
                            <img src="${item.image || '/assets/backend/img/default-product.png'}" alt="${item.name}">
                            <div class="details">
                                <div class="name">${item.name}</div>
                                <div class="price">Rp ${numberFormat(item.price)}</div>
                            </div>
                            <div class="qty-controls">
                                <button class="qty-btn" onclick="updateQuantity(${item.product_id}, -1)">-</button>
                                <span class="qty">${item.quantity}</span>
                                <button class="qty-btn" onclick="updateQuantity(${item.product_id}, 1)">+</button>
                            </div>
                            <i class="bi bi-trash remove-btn" onclick="removeFromCart(${item.product_id})"></i>
                        </div>
                    `;
                });
                $('#cartItems').html(html);
                $('#checkoutBtn').prop('disabled', false);
            }

            calculateTotals();
        }

        function calculateTotals() {
            let subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            let discount = 0;

            if (appliedDiscount) {
                discount = appliedDiscount.amount;
                $('#discountRow').show();
                $('#discountAmount').text('- Rp ' + numberFormat(discount));
            } else {
                $('#discountRow').hide();
            }

            let taxable = subtotal - discount;
            let tax = taxable * (taxPercentage / 100);
            let total = taxable + tax;

            $('#subtotal').text('Rp ' + numberFormat(subtotal));
            $('#taxAmount').text('Rp ' + numberFormat(tax));
            $('#totalAmount').text('Rp ' + numberFormat(total));

            window.currentTotal = total;
        }

        function applyDiscount() {
            const code = $('#discountCode').val().trim();
            if (!code) return;

            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

            $.post('{{ route("pos.check-discount") }}', {
                _token: '{{ csrf_token() }}',
                outlet_id: outletId,
                code: code,
                subtotal: subtotal
            }, function(res) {
                if (res.valid) {
                    appliedDiscount = res.discount;
                    $('#discountInfo').text('Diskon ' + res.discount.name + ' diterapkan!').show();
                    toastr.success('Diskon berhasil diterapkan');
                } else {
                    toastr.error(res.message);
                }
                calculateTotals();
            }).fail(function() {
                toastr.error('Gagal memeriksa diskon');
            });
        }

        function showCheckoutModal() {
            if (cart.length === 0) return;
            $('#paidAmount').val('');
            $('#changeInfo').hide();
            selectedPaymentMethod = null;
            $('.payment-method-btn').removeClass('active');
            new bootstrap.Modal('#checkoutModal').show();
        }

        $('.payment-method-btn').on('click', function() {
            $('.payment-method-btn').removeClass('active');
            $(this).addClass('active');
            selectedPaymentMethod = $(this).data('id');
        });

        $('#paidAmount').on('input', function() {
            const paid = parseFloat(this.value) || 0;
            const change = paid - window.currentTotal;
            if (change >= 0) {
                $('#changeInfo').show();
                $('#changeAmount').text('Rp ' + numberFormat(change));
            } else {
                $('#changeInfo').hide();
            }
        });

        function fillExact() {
            $('#paidAmount').val(Math.ceil(window.currentTotal)).trigger('input');
        }

        function fillAmount(amount) {
            $('#paidAmount').val(amount).trigger('input');
        }

        function processCheckout() {
            if (!selectedPaymentMethod) {
                toastr.warning('Pilih metode pembayaran');
                return;
            }

            const paid = parseFloat($('#paidAmount').val()) || 0;
            if (paid < window.currentTotal) {
                toastr.warning('Jumlah bayar kurang');
                return;
            }

            $('#processBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Memproses...');

            $.post('{{ route("pos.checkout") }}', {
                _token: '{{ csrf_token() }}',
                outlet_id: outletId,
                payment_method_id: selectedPaymentMethod,
                items: cart,
                discount_id: appliedDiscount?.id,
                paid_amount: paid,
                customer_name: $('#customerName').val()
            }, function(res) {
                if (res.success) {
                    toastr.success('Transaksi berhasil!');
                    window.location.href = res.redirect;
                } else {
                    toastr.error(res.message);
                }
            }).fail(function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Terjadi kesalahan');
            }).always(function() {
                $('#processBtn').prop('disabled', false).html('<i class="bi bi-check-lg me-1"></i>Proses Pembayaran');
            });
        }

        function numberFormat(num) {
            return new Intl.NumberFormat('id-ID').format(Math.round(num));
        }

        // Init
        $(document).ready(function() {
            loadProducts();

            let searchTimeout;
            $('#searchInput').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => loadProducts('', this.value), 300);
            });
        });
    </script>
</body>

</html>