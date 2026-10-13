<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 
?>
    <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">

<!-- Page Header -->
<div class="bg-primary py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">المتجر</h1>
        <div class="flex items-center gap-2 text-gray-400 text-sm">
            <a href="index.php" class="hover:text-white transition">الرئيسية</a>
            <i class="fa-solid fa-chevron-left text-xs"></i>
            <span class="text-white">المتجر</span>
        </div>
    </div>
</div>

<!-- Main Content -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-1/4" data-aos="fade-left">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 sticky top-24">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-lg text-primary">تصفية المنتجات</h3>
                        <button onclick="clearFilters()" class="text-sm text-red-500 hover:underline">مسح الكل</button>
                    </div>

                    <!-- Categories -->
                    <div class="mb-8">
                        <h4 class="font-bold text-gray-700 mb-3">الأقسام</h4>
                        <ul class="space-y-2">
                            <li>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" value="لابتوب" class="filter-category w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary" onchange="fetchProducts()">
                                    <span class="text-gray-600 group-hover:text-secondary transition">لابتوب</span>
                                </label>
                            </li>
                            <li>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" value="كاميرات" class="filter-category w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary" onchange="fetchProducts()">
                                    <span class="text-gray-600 group-hover:text-secondary transition">كاميرات</span>
                                </label>
                            </li>
                            <li>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" value="اكسسوارات" class="filter-category w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary" onchange="fetchProducts()">
                                    <span class="text-gray-600 group-hover:text-secondary transition">اكسسوارات</span>
                                </label>
                            </li>
                            <li>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" value="شاشات" class="filter-category w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary" onchange="fetchProducts()">
                                    <span class="text-gray-600 group-hover:text-secondary transition">شاشات</span>
                                </label>
                            </li>
                            <li>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" value="أنظمة أمنية" class="filter-category w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary" onchange="fetchProducts()">
                                    <span class="text-gray-600 group-hover:text-secondary transition">أنظمة أمنية</span>
                                </label>
                            </li>
                        </ul>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-8">
                        <h4 class="font-bold text-gray-700 mb-3">السعر</h4>
                        <div class="flex items-center gap-2 mb-4">
                            <input type="number" id="filter-min-price" oninput="fetchProducts()" placeholder="من" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:border-secondary outline-none">
                            <span class="text-gray-400">-</span>
                            <input type="number" id="filter-max-price" oninput="fetchProducts()" placeholder="إلى" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:border-secondary outline-none">
                        </div>
                    </div>

                    <!-- Brands -->
                    <div>
                        <h4 class="font-bold text-gray-700 mb-3">الماركة</h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" value="Dell" class="filter-brand w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary" onchange="fetchProducts()">
                                <span class="text-gray-600">Dell</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" value="HP" class="filter-brand w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary" onchange="fetchProducts()">
                                <span class="text-gray-600">HP</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" value="Apple" class="filter-brand w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary" onchange="fetchProducts()">
                                <span class="text-gray-600">Apple</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" value="Lenovo" class="filter-brand w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary" onchange="fetchProducts()">
                                <span class="text-gray-600">Lenovo</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" value="Asus" class="filter-brand w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary" onchange="fetchProducts()">
                                <span class="text-gray-600">Asus</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" value="Sony" class="filter-brand w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary" onchange="fetchProducts()">
                                <span class="text-gray-600">Sony</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" value="Samsung" class="filter-brand w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary" onchange="fetchProducts()">
                                <span class="text-gray-600">Samsung</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" value="Canon" class="filter-brand w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary" onchange="fetchProducts()">
                                <span class="text-gray-600">Canon</span>
                            </label>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Product Grid -->
            <main class="w-full lg:w-3/4">
                <!-- Toolbar -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p class="text-gray-500 text-sm">عرض <span id="display-info" class="font-bold text-primary">...</span> منتج</p>
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-600">ترتيب حسب:</label>
                        <select id="filter-sort" onchange="fetchProducts()" class="border border-gray-200 bg-gray-50 rounded-lg text-sm px-3 py-2 focus:ring-secondary focus:border-secondary outline-none cursor-pointer hover:bg-gray-100 transition">
                            <option value="newest">الأحدث</option>
                            <option value="most_sold">الأكثر مبيعاً</option>
                            <option value="price_asc">السعر: من الأقل للأعلى</option>
                            <option value="price_desc">السعر: من الأعلى للأقل</option>
                        </select>
                    </div>
                </div>

                <!-- Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 relative" id="products-grid">
                    <!-- Loading Indicator -->
                    <div id="loading-indicator" class="hidden absolute inset-0 bg-white/80 z-10 flex flex-col items-center justify-center rounded-xl min-h-[300px]">
                        <i class="fa-solid fa-circle-notch fa-spin text-4xl text-secondary mb-4"></i>
                        <p class="text-gray-600 font-bold">جاري تحميل المنتجات...</p>
                    </div>
                    <!-- Products will be injected here -->
                </div>

                <!-- No Products Message -->
                <div id="no-products-msg" class="hidden bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <i class="fa-regular fa-face-frown text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-primary mb-2">لا توجد منتجات مطابقة</h3>
                    <p class="text-gray-500">حاول تغيير خيارات التصفية للبحث عن منتجات أخرى.</p>
                    <button onclick="clearFilters()" class="mt-6 bg-secondary text-white px-6 py-2 rounded-lg font-bold hover:bg-primary transition">مسح الفلاتر</button>
                </div>

                <!-- Pagination -->
                <div id="pagination-container" class="mt-12 flex justify-center gap-2">
                    <!-- Pagination will be injected here -->
                </div>
            </main>
        </div>
    </div>
</section>

<!-- Checkout Modal -->
<div id="checkoutModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/75 backdrop-blur-sm opacity-0 pointer-events-none transition duration-300">
    <div class="bg-white border border-gray-100 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl transform scale-95 transition duration-300">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-black text-lg text-primary">إتمام الشراء</h3>
            <button onclick="closeCheckoutModal()" class="text-gray-400 hover:text-red-500 text-lg focus:outline-none transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        
        <!-- Modal Form -->
        <form id="checkoutForm" onsubmit="submitOrder(event)" class="p-6 space-y-4">
            <input type="hidden" id="checkoutProductName">
            <input type="hidden" id="checkoutProductPrice">

            <div class="bg-gray-50 p-4 rounded-xl mb-4 border border-gray-100">
                <p class="text-sm text-gray-500 mb-1">المنتج المختار:</p>
                <h4 id="displayProductName" class="font-bold text-primary mb-1"></h4>
                <p class="text-secondary font-black" id="displayProductPrice"></p>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2">الاسم بالكامل</label>
                <input type="text" id="checkoutName" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-primary text-sm focus:border-secondary outline-none transition" placeholder="مثال: أحمد محمد">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2">رقم الهاتف</label>
                <input type="tel" id="checkoutPhone" required pattern="01[0125][0-9]{8}" title="يجب أن يتكون رقم الهاتف من 11 رقم ويبدأ بـ 01 (مثال: 01012345678)" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-primary text-sm focus:border-secondary outline-none transition" placeholder="مثال: 01012345678">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2">العنوان بالتفصيل</label>
                <textarea id="checkoutAddress" rows="2" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-primary text-sm focus:border-secondary outline-none transition" placeholder="المحافظة، المدينة، الشارع، رقم العمارة..."></textarea>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-black py-3 rounded-xl transition duration-300 shadow-lg mt-4">
                تأكيد الطلب
            </button>
        </form>
    </div>
</div>

<script>
    const ORDERS_ENABLED = <?php echo $orders_enabled ? 'true' : 'false'; ?>;

    function openCheckoutModal(productName, price) {
        if (!ORDERS_ENABLED) {
            alert('عذراً، الطلبات مغلقة حالياً ولا يمكن استقبال طلبات جديدة.');
            return;
        }
        document.getElementById('checkoutProductName').value = productName;
        document.getElementById('checkoutProductPrice').value = price;
        document.getElementById('displayProductName').innerText = productName;
        document.getElementById('displayProductPrice').innerText = Number(price).toLocaleString() + ' ج.م';
        
        const modal = document.getElementById('checkoutModal');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.querySelector('.transform').classList.remove('scale-95');
        modal.querySelector('.transform').classList.add('scale-100');
    }

    function closeCheckoutModal() {
        const modal = document.getElementById('checkoutModal');
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.querySelector('.transform').classList.remove('scale-100');
        modal.querySelector('.transform').classList.add('scale-95');
    }

    async function submitOrder(event) {
        event.preventDefault();

        if (!ORDERS_ENABLED) {
            alert('عذراً، الطلبات مغلقة حالياً ولا يمكن استقبال طلبات جديدة.');
            return;
        }
        
        const btn = event.target.querySelector('button[type="submit"]');
        const origText = btn.innerText;
        btn.innerText = 'جاري الإرسال...';
        btn.disabled = true;

        const payload = {
            action: 'create_order',
            product: document.getElementById('checkoutProductName').value,
            total: document.getElementById('checkoutProductPrice').value,
            customer: document.getElementById('checkoutName').value,
            phone: document.getElementById('checkoutPhone').value,
            address: document.getElementById('checkoutAddress').value
        };

        try {
            const res = await fetch('api.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const data = await res.json();
            
            if(data.success) {
                alert(data.message); // سيتم التواصل معك قريبا
                closeCheckoutModal();
                document.getElementById('checkoutForm').reset();
            } else {
                alert(data.message || 'حدث خطأ، يرجى المحاولة مرة أخرى.');
            }
        } catch (e) {
            alert('حدث خطأ في الاتصال بالخادم.');
        }

        btn.disabled = false;
    }

    // --- Store Filter & AJAX Logic ---
    let currentPage = 1;

    function clearFilters() {
        document.querySelectorAll('.filter-category, .filter-brand').forEach(el => el.checked = false);
        document.getElementById('filter-min-price').value = '';
        document.getElementById('filter-max-price').value = '';
        document.getElementById('filter-sort').value = 'newest';
        fetchProducts(1);
    }

    async function fetchProducts(page = 1) {
        currentPage = page;
        const categories = Array.from(document.querySelectorAll('.filter-category:checked')).map(el => el.value);
        const brands = Array.from(document.querySelectorAll('.filter-brand:checked')).map(el => el.value);
        const minPrice = document.getElementById('filter-min-price').value;
        const maxPrice = document.getElementById('filter-max-price').value;
        const sort = document.getElementById('filter-sort').value;

        const payload = {
            action: 'get_store_products',
            categories: categories,
            brands: brands,
            min_price: minPrice,
            max_price: maxPrice,
            sort: sort,
            page: page,
            limit: 9
        };

        const grid = document.getElementById('products-grid');
        const loader = document.getElementById('loading-indicator');
        const noProductsMsg = document.getElementById('no-products-msg');
        
        loader.classList.remove('hidden');
        noProductsMsg.classList.add('hidden');
        // Clear old products but keep loader
        Array.from(grid.children).forEach(child => {
            if (child.id !== 'loading-indicator') child.remove();
        });

        try {
            const res = await fetch('api.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const data = await res.json();
            
            if (data.success) {
                renderStoreProducts(data.products);
                updatePagination(data.page, data.total_pages);
                updateDisplayInfo(data.total, data.page, data.limit);
            }
        } catch (e) {
            console.error('Error fetching products:', e);
        } finally {
            loader.classList.add('hidden');
        }
    }

    function renderStoreProducts(products) {
        const grid = document.getElementById('products-grid');
        const noProductsMsg = document.getElementById('no-products-msg');

        if (products.length === 0) {
            noProductsMsg.classList.remove('hidden');
            return;
        }

        products.forEach(p => {
            const image = p.image || 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60';
            const priceStr = Number(p.price).toLocaleString();
            
            // Generate product HTML safely
            const div = document.createElement('div');
            div.className = "bg-white rounded-xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden group";
            div.innerHTML = `
                <div class="relative h-56 bg-gray-100 overflow-hidden">
                    <img src="${image}" alt="${p.name.replace(/"/g, '&quot;')}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center gap-2">
                        <a href="product.php?id=${p.id}" class="w-10 h-10 bg-white rounded-full text-primary hover:bg-secondary hover:text-white transition flex items-center justify-center shadow-lg transform translate-y-4 group-hover:translate-y-0 duration-300 delay-75">
                            <i class="fa-regular fa-eye"></i>
                        </a>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded">${p.category}</span>
                        ${p.brand ? `<span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded border border-gray-100">${p.brand}</span>` : ''}
                    </div>
                    <h3 class="font-bold text-primary mb-2 hover:text-secondary transition cursor-pointer truncate" title="${p.name.replace(/"/g, '&quot;')}">${p.name}</h3>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-secondary font-bold text-xl">${priceStr} ج.م</span>
                        <button onclick="openCheckoutModal('${p.name.replace(/"/g, '\\$&')}', ${p.price})" class="w-10 h-10 rounded-lg bg-primary text-white hover:bg-secondary transition flex items-center justify-center">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            `;
            grid.appendChild(div);
        });
    }

    function updatePagination(page, totalPages) {
        const container = document.getElementById('pagination-container');
        container.innerHTML = '';
        if (totalPages <= 1) return;

        // Prev
        if (page > 1) {
            container.innerHTML += `<button onclick="fetchProducts(${page - 1})" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center hover:bg-secondary hover:text-white hover:border-secondary transition"><i class="fa-solid fa-chevron-right"></i></button>`;
        }

        // Pages
        for (let i = 1; i <= totalPages; i++) {
            if (i === page) {
                container.innerHTML += `<button class="w-10 h-10 rounded-lg bg-secondary text-white flex items-center justify-center">${i}</button>`;
            } else {
                container.innerHTML += `<button onclick="fetchProducts(${i})" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center hover:bg-secondary hover:text-white hover:border-secondary transition">${i}</button>`;
            }
        }

        // Next
        if (page < totalPages) {
            container.innerHTML += `<button onclick="fetchProducts(${page + 1})" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center hover:bg-secondary hover:text-white hover:border-secondary transition"><i class="fa-solid fa-chevron-left"></i></button>`;
        }
    }

    function updateDisplayInfo(total, page, limit) {
        if (total === 0) {
            document.getElementById('display-info').innerText = "0";
            return;
        }
        const start = (page - 1) * limit + 1;
        const end = Math.min(page * limit, total);
        document.getElementById('display-info').innerHTML = `${start}-${end} <span class="font-normal text-gray-500 text-sm">من أصل</span> ${total}`;
    }

    // Fetch on page load
    document.addEventListener('DOMContentLoaded', () => {
        fetchProducts(1);
    });

</script>

<?php include 'includes/footer.php'; ?>
