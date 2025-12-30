<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS - {{ $outlet->name }} - Mari POS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="posApp()" class="bg-slate-100">

    <div class="flex h-screen overflow-hidden">
        {{-- Products Area --}}
        <div class="flex-1 flex flex-col">
            {{-- Header --}}
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 shrink-0">
                <div class="flex items-center gap-4">
                    <a href="{{ route('pos.index') }}" class="p-2 hover:bg-slate-100 rounded-lg">
                        <i class="fas fa-arrow-left text-slate-600"></i>
                    </a>
                    <div>
                        <h1 class="font-bold text-slate-800">{{ $outlet->name }}</h1>
                        <p class="text-xs text-slate-500">Point of Sales</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-slate-500">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </header>

            {{-- Search & Categories --}}
            <div class="p-4 bg-white border-b border-slate-200 shrink-0">
                <div class="flex gap-4">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" x-model="search" placeholder="Cari produk..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-300 focus:border-primary-500 focus:outline-none">
                    </div>
                </div>
                <div class="flex gap-2 mt-3 overflow-x-auto pb-2">
                    <button @click="category = null"
                        :class="category === null ? 'bg-primary-600 text-white' : 'bg-slate-100 text-slate-600'"
                        class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-colors">
                        <i class="fas fa-th-large mr-1"></i> Semua
                    </button>
                    @foreach($categories as $cat)
                    <button @click="category = {{ $cat->id }}"
                        :class="category === {{ $cat->id }} ? 'bg-primary-600 text-white' : 'bg-slate-100 text-slate-600'"
                        class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-colors">
                        {{ $cat->name }}
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- Products Grid --}}
            <div class="flex-1 overflow-y-auto p-4">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($products as $product)
                    <div x-show="matchesFilter({{ json_encode($product) }})"
                        @click="addToCart({{ json_encode($product) }})"
                        class="bg-white rounded-xl border border-slate-200 overflow-hidden cursor-pointer hover:shadow-md hover:-translate-y-1 transition-all">
                        <div
                            class="h-24 bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                            @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="" class="h-full w-full object-cover">
                            @else
                            <i class="fas fa-box text-3xl text-slate-400"></i>
                            @endif
                        </div>
                        <div class="p-3">
                            <h3 class="font-medium text-slate-800 text-sm truncate">{{ $product->name }}</h3>
                            <p class="text-primary-600 font-bold mt-1">{{ formatRupiah($product->price) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Cart Sidebar --}}
        <div class="w-96 bg-white border-l border-slate-200 flex flex-col shrink-0">
            <div class="p-4 border-b border-slate-200 shrink-0">
                <h2 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-shopping-cart text-primary-500"></i>
                    Keranjang
                    <span class="ml-auto bg-primary-100 text-primary-700 px-2 py-0.5 rounded-full text-xs"
                        x-text="cartItems.length + ' item'"></span>
                </h2>
            </div>

            {{-- Cart Items --}}
            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                <template x-for="(item, index) in cartItems" :key="item.id">
                    <div class="bg-slate-50 rounded-lg p-3">
                        <div class="flex items-start justify-between mb-2">
                            <h4 class="font-medium text-slate-800 text-sm" x-text="item.name"></h4>
                            <button @click="removeFromCart(index)" class="text-red-500 hover:text-red-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <button @click="updateQty(index, -1)"
                                    class="w-7 h-7 rounded bg-white border border-slate-300 text-slate-600 hover:bg-slate-100">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span class="w-8 text-center font-medium" x-text="item.qty"></span>
                                <button @click="updateQty(index, 1)"
                                    class="w-7 h-7 rounded bg-white border border-slate-300 text-slate-600 hover:bg-slate-100">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                            <span class="font-bold text-primary-600"
                                x-text="formatRupiah(item.price * item.qty)"></span>
                        </div>
                    </div>
                </template>

                <div x-show="cartItems.length === 0" class="text-center py-8 text-slate-400">
                    <i class="fas fa-shopping-cart text-4xl mb-2"></i>
                    <p>Keranjang kosong</p>
                </div>
            </div>

            {{-- Cart Footer --}}
            <div class="p-4 border-t border-slate-200 bg-slate-50 shrink-0">
                <div class="flex justify-between mb-2">
                    <span class="text-slate-600">Subtotal</span>
                    <span class="font-bold text-slate-800" x-text="formatRupiah(subtotal)"></span>
                </div>
                <div class="flex justify-between mb-4">
                    <span class="text-slate-600">Total</span>
                    <span class="font-bold text-xl text-primary-600" x-text="formatRupiah(subtotal)"></span>
                </div>
                <button @click="processPayment()" :disabled="cartItems.length === 0"
                    class="w-full py-3 rounded-lg font-bold bg-primary-600 text-white hover:bg-primary-700 disabled:bg-slate-300 disabled:cursor-not-allowed transition-colors">
                    <i class="fas fa-credit-card mr-2"></i>
                    Proses Pembayaran
                </button>
            </div>
        </div>
    </div>

    <script>
        function posApp() {
            return {
                search: '',
                category: null,
                cartItems: [],

                get subtotal() {
                    return this.cartItems.reduce((sum, item) => sum + (item.price * item.qty), 0);
                },

                matchesFilter(product) {
                    const matchSearch = product.name.toLowerCase().includes(this.search.toLowerCase());
                    const matchCategory = this.category === null || product.category_id === this.category;
                    return matchSearch && matchCategory;
                },

                addToCart(product) {
                    const existing = this.cartItems.find(item => item.id === product.id);
                    if (existing) {
                        existing.qty++;
                    } else {
                        this.cartItems.push({ ...product, qty: 1 });
                    }
                },

                removeFromCart(index) {
                    this.cartItems.splice(index, 1);
                },

                updateQty(index, delta) {
                    this.cartItems[index].qty += delta;
                    if (this.cartItems[index].qty < 1) {
                        this.removeFromCart(index);
                    }
                },

                formatRupiah(num) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
                },

                processPayment() {
                    if (this.cartItems.length === 0) return;
                    alert('Fitur pembayaran akan diimplementasikan');
                }
            }
        }
    </script>
</body>

</html>