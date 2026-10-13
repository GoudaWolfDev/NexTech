<?php
require_once 'includes/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header('Location: store.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM `products` WHERE `id` = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$product = $res->fetch_assoc();
$stmt->close();

if (!$product) {
    header('Location: store.php');
    exit;
}

$name = htmlspecialchars($product['name']);
$category = htmlspecialchars($product['category']);
$brand = htmlspecialchars($product['brand'] ?? 'غير محدد');
$price = number_format($product['price']);
$raw_price = $product['price'];
$description = htmlspecialchars($product['description'] ?? $product['desc'] ?? 'لا يوجد وصف متاح.');
$stock = intval($product['stock']);
$image = htmlspecialchars($product['image'] ?? 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80');

include 'includes/header.php';
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --navy-dark: #0A0F1D;
        --blue-primary: #2563EB;
        --blue-accent: #60A5FA;
    }
    .ds-font-display { font-family: 'Cairo', sans-serif; }
    .ds-font-mono { font-family: 'JetBrains Mono', monospace; }
    
    .ds-blueprint {
        background-image: 
            linear-gradient(rgba(37, 99, 235, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(37, 99, 235, 0.03) 1px, transparent 1px);
        background-size: 30px 30px;
    }

    .btn-premium {
        background: linear-gradient(135deg, var(--navy-dark), var(--blue-primary));
        color: #fff;
        transition: all 0.3s ease;
    }
    .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px -6px rgba(37, 99, 235, 0.35);
    }
    .img-zoom-container {
        overflow: hidden;
        border-radius: 1rem;
    }
    .img-zoom-container img {
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .img-zoom-container:hover img {
        transform: scale(1.08);
    }
</style>

<div class="bg-gray-50 min-h-screen ds-font-display relative pt-24 pb-16" dir="rtl">
    <div class="absolute inset-0 ds-blueprint pointer-events-none"></div>

    <div class="container mx-auto px-4 relative z-10">
        
        <!-- Breadcrumbs -->
        <nav class="flex text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li class="inline-flex items-center">
                    <a href="index.php" class="hover:text-primary transition">الرئيسية</a>
                </li>
                <li><i class="fa-solid fa-chevron-left text-[10px]"></i></li>
                <li>
                    <a href="store.php" class="hover:text-primary transition">المتجر</a>
                </li>
                <li><i class="fa-solid fa-chevron-left text-[10px]"></i></li>
                <li aria-current="page">
                    <span class="text-primary font-bold truncate max-w-[200px] inline-block align-bottom"><?php echo $name; ?></span>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                
                <!-- Product Image Section -->
                <div class="p-8 lg:p-12 bg-gray-50 border-b lg:border-b-0 lg:border-l border-gray-100 flex items-center justify-center relative">
                    <!-- Status Badge -->
                    <div class="absolute top-6 right-6 flex flex-col gap-2 z-20">
                        <span class="bg-green-100 text-green-700 font-bold text-xs px-3 py-1.5 rounded-lg border border-green-200 flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-check-circle"></i> متوفر في المخزن (<?php echo $stock; ?>)
                        </span>
                        <span class="bg-blue-100 text-blue-700 font-bold text-xs px-3 py-1.5 rounded-lg border border-blue-200 flex items-center gap-1.5 shadow-sm w-fit">
                            <i class="fa-solid fa-shield-halved"></i> تم الفحص
                        </span>
                    </div>

                    <div class="w-full max-w-lg aspect-square img-zoom-container bg-white shadow-sm border border-gray-100 p-2 relative">
                        <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>" class="w-full h-full object-cover rounded-xl">
                    </div>
                </div>

                <!-- Product Details & Checkout Form -->
                <div class="p-8 lg:p-12">
                    
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md border border-slate-200"><?php echo $category; ?></span>
                        <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md border border-slate-200"><?php echo $brand; ?></span>
                    </div>

                    <h1 class="text-3xl lg:text-4xl font-black text-slate-900 mb-4 leading-tight"><?php echo $name; ?></h1>
                    
                    <div class="flex items-center gap-2 mb-6">
                        <div class="flex text-amber-400 text-sm">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="text-slate-500 text-sm font-medium">(4.9/5 بناءً على مراجعات الخبراء)</span>
                    </div>

                    <div class="mb-8">
                        <span class="text-4xl font-black text-primary ds-font-mono"><?php echo $price; ?></span>
                        <span class="text-lg font-bold text-slate-500 ml-1">ج.م</span>
                    </div>

                    <div class="prose prose-slate mb-10 max-w-none">
                        <h3 class="text-lg font-bold text-slate-800 mb-3 border-b border-slate-100 pb-2">نظرة عامة على المنتج</h3>
                        <p class="text-slate-600 leading-relaxed text-sm md:text-base whitespace-pre-wrap"><?php echo $description; ?></p>
                    </div>

                    <!-- Order Form -->
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
                        
                        <h3 class="text-xl font-black text-primary mb-5 flex items-center gap-2">
                            <i class="fa-solid fa-bag-shopping text-blue-500"></i> إتمام الشراء السريع
                        </h3>
                        
                        <form id="directCheckoutForm" onsubmit="submitDirectOrder(event)" class="space-y-4 relative z-10">
                            <input type="hidden" id="checkoutProductName" value="<?php echo htmlspecialchars($product['name'], ENT_QUOTES); ?>">
                            <input type="hidden" id="checkoutProductPrice" value="<?php echo $raw_price; ?>">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-2">الاسم بالكامل</label>
                                    <input type="text" id="checkoutName" required class="w-full px-4 py-3 rounded-xl bg-white border border-slate-200 text-slate-800 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition" placeholder="مثال: أحمد محمد">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-2">رقم الهاتف</label>
                                    <input type="tel" id="checkoutPhone" required pattern="01[0125][0-9]{8}" title="يجب أن يتكون رقم الهاتف من 11 رقم ويبدأ بـ 01 (مثال: 01012345678)" class="w-full px-4 py-3 rounded-xl bg-white border border-slate-200 text-slate-800 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition" placeholder="مثال: 01012345678">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-2">العنوان بالتفصيل</label>
                                <textarea id="checkoutAddress" rows="2" required class="w-full px-4 py-3 rounded-xl bg-white border border-slate-200 text-slate-800 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition" placeholder="المحافظة، المدينة، الشارع، رقم العمارة..."></textarea>
                            </div>

                            <button type="submit" class="w-full btn-premium py-4 rounded-xl font-black text-lg mt-2 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-check-circle"></i> تأكيد الطلب الآن
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
const ORDERS_ENABLED = <?php echo isset($orders_enabled) && $orders_enabled ? 'true' : 'false'; ?>;

async function submitDirectOrder(event) {
    event.preventDefault();

    if (!ORDERS_ENABLED) {
        alert('عذراً، الطلبات مغلقة حالياً ولا يمكن استقبال طلبات جديدة.');
        return;
    }
    
    const btn = event.target.querySelector('button[type="submit"]');
    const origHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> جاري الإرسال...';
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
            alert('تم تسجيل طلبك بنجاح! سيتم التواصل معك قريباً لتأكيد الشحن.');
            document.getElementById('directCheckoutForm').reset();
        } else {
            alert(data.message || 'حدث خطأ، يرجى المحاولة مرة أخرى.');
        }
    } catch (e) {
        alert('حدث خطأ في الاتصال بالخادم.');
    }

    btn.innerHTML = origHtml;
    btn.disabled = false;
}
</script>

<?php include 'includes/footer.php'; ?>
