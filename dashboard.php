<?php
/**
 * ============================================================
 * لوحة تحكم متجر NexTech الإدارية
 * المطور: جودة نصر الله (GoudaWolfDev)
 * الوصف: لوحة تحكم متكاملة لإدارة المنتجات والطلبات
 *          مع إحصائيات ورسوم بيانية تفاعلية.
 * ============================================================
 */

// ------------------------------------------------------------
// (1) بدء الجلسة و التحقق من صلاحية الدخول
// ------------------------------------------------------------
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // إذا لم يكن مسجل الدخول كمسؤول يتم توجيهه إلى صفحة الدخول
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <!-- ============ البيانات الوصفية الأساسية ============ -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم | NexTech Admin Dashboard</title>
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">

    <!-- ============ خطوط Google (Cairo) ============ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- ============ إطار Tailwind CSS ============ -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ============ أيقونات FontAwesome ============ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- ============ مكتبة Chart.js للرسوم البيانية ============ -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- ============ إعدادات Tailwind المخصصة ============ -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkBg: '#090D16',        // لون الخلفية الداكن الرئيسي
                        darkCard: '#111827',      // خلفية البطاقات
                        darkBorder: '#1F2937',    // لون الحدود
                        accent: '#06B6D4',        // اللون التمييزي (سماوي)
                        secondary: '#4F46E5',     // لون ثانوي (نيلي)
                    },
                    fontFamily: {
                        sans: ['Cairo', 'sans-serif'],  // تعيين خط Cairo كافتراضي
                    }
                }
            }
        }
    </script>

    <!-- ============ تنسيقات CSS مخصصة (شريط التمرير والتأثيرات الضوئية) ============ -->
    <style>
        /* تخصيص شكل شريط التمرير */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #090D16; }
        ::-webkit-scrollbar-thumb { background: #1F2937; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #06B6D4; }
        /* تأثيرات النيون (توهج خفيف) للبطاقات */
        .neon-glow { box-shadow: 0 0 15px rgba(6, 182, 212, 0.15); }
        .neon-glow-indigo { box-shadow: 0 0 15px rgba(79, 70, 229, 0.15); }
    </style>
</head>
<body class="bg-darkBg text-slate-100 font-sans min-h-screen flex flex-col md:flex-row overflow-x-hidden">

    <!-- ============================================================ -->
    <!-- (2) القائمة الجانبية (Sidebar)                                -->
    <!-- ============================================================ -->
    <aside class="w-full md:w-64 bg-darkCard border-b md:border-b-0 md:border-l border-darkBorder flex-shrink-0 flex flex-col transition duration-300">
        
        <!-- ------ شعار المتجر واسمه ------ -->
        <div class="p-6 border-b border-darkBorder flex justify-between items-center">
            <a href="index.php" class="text-xl font-bold flex items-center gap-2 tracking-wide group">
                <i class="fa-solid fa-laptop-code text-accent group-hover:rotate-12 transition duration-300"></i>
                <span class="text-white">lap-<span class="text-accent">store</span></span>
            </a>
            <span class="text-xs bg-accent/10 border border-accent/30 text-accent font-semibold px-2 py-0.5 rounded">Admin</span>
        </div>

        <!-- ------ بطاقة تعريف المسؤول ------ -->
        <div class="p-6 border-b border-darkBorder bg-darkBg/50 flex items-center gap-3">
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-accent to-secondary flex items-center justify-center font-bold text-white shadow-md text-lg">
                    GN  <!-- اختصار لاسم المطور (جودة نصر الله) -->
                </div>
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-darkCard rounded-full animate-pulse"></span> <!-- إشارة متصل -->
            </div>
            <div>
                <h4 class="font-bold text-sm text-white">جودة نصر الله</h4>
                <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                    <i class="fa-solid fa-crown text-amber-500 text-[10px]"></i>
                    المالك والمطور
                </p>
            </div>
        </div>

        <!-- ------ روابط التنقل الرئيسية ------ -->
        <nav class="flex-1 p-4 space-y-1" id="sidebar-nav">
            <!-- رابط الإحصائيات (نشط افتراضياً) -->
            <a href="#" onclick="showSection('overview-section', this); return false;" class="sidebar-link active flex items-center gap-3 px-4 py-3 rounded-xl bg-secondary/20 border-r-4 border-secondary text-white font-bold transition">
                <i class="fa-solid fa-chart-pie text-accent"></i>
                <span>الإحصائيات والتحليلات</span>
            </a>
            <!-- رابط إدارة المنتجات -->
            <a href="#" onclick="showSection('products-section', this); return false;" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-300 hover:text-white font-semibold transition border-r-4 border-transparent">
                <i class="fa-solid fa-box-open text-slate-400"></i>
                <span>إدارة المنتجات</span>
            </a>
            <!-- رابط إدارة الطلبات -->
            <a href="#" onclick="showSection('orders-section', this); return false;" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-300 hover:text-white font-semibold transition border-r-4 border-transparent">
                <i class="fa-solid fa-receipt text-slate-400"></i>
                <span>إدارة الطلبات</span>
            </a>
            <!-- رابط الموقع الرئيسي (المتجر) -->
            <a href="index.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-300 hover:text-white font-semibold transition">
                <i class="fa-solid fa-house text-slate-400"></i>
                <span>تصفح الموقع الرئيسي</span>
            </a>
            <!-- رابط صفحة المتجر -->
            <a href="store.php" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-300 hover:text-white font-semibold transition">
                <i class="fa-solid fa-shop text-slate-400"></i>
                <span>تصفح المتجر</span>
            </a>
        </nav>

        <!-- ------ تذييل الشريط الجانبي (حقوق المطور) ------ -->
        <div class="p-6 border-t border-darkBorder bg-darkBg/30 text-center">
            <p class="text-[10px] text-slate-500">تم التطوير بكل حب بواسطة</p>
            <a href="https://github.com/GoudaWolfDev" target="_blank" class="text-xs text-accent font-bold hover:underline mt-1 block">
                <i class="fa-brands fa-github text-xs"></i> GoudaWolfDev
            </a>
        </div>
    </aside>

    <!-- ============================================================ -->
    <!-- (3) المحتوى الرئيسي (Main Content)                           -->
    <!-- ============================================================ -->
    <main class="flex-1 flex flex-col min-w-0">

        <!-- ------ شريط العنوان العلوي (Header) ------ -->
        <header class="bg-darkCard border-b border-darkBorder h-20 px-8 flex justify-between items-center flex-shrink-0">
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-black text-white" id="section-title">لوحة الإدارة والتحليلات</h1>
                <span class="text-xs bg-slate-800 border border-slate-700 text-slate-400 px-3 py-1 rounded-full hidden sm:inline-block">التحديث التلقائي نشط</span>
            </div>

            <div class="flex items-center gap-4">
                <!-- أيقونة التنبيهات -->
                <button class="w-10 h-10 rounded-xl bg-darkBg hover:bg-slate-800 border border-darkBorder flex items-center justify-center text-slate-300 hover:text-accent transition relative" title="التنبيهات">
                    <i class="fa-regular fa-bell"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full"></span> <!-- نقطة إشعار -->
                </button>

                <!-- زر الرجوع للموقع الرئيسي -->
                <a href="index.php" class="bg-accent/10 border border-accent/30 text-accent hover:bg-accent hover:text-primary font-bold py-2 px-4 rounded-xl text-sm transition duration-300 flex items-center gap-2">
                    <i class="fa-solid fa-up-right-from-square text-xs"></i>
                    الموقع الرئيسي
                </a>
                
                <!-- زر تسجيل الخروج -->
                <a href="portal_x9.php?action=logout" class="bg-rose-500/10 border border-rose-500/30 text-rose-500 hover:bg-rose-500 hover:text-white font-bold py-2 px-4 rounded-xl text-sm transition duration-300 flex items-center gap-2" title="تسجيل الخروج">
                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                    تسجيل الخروج
                </a>
            </div>
        </header>

        <!-- ------ حاوية الأقسام المتغيرة (Sections Container) ------ -->
        <div class="flex-grow p-8 space-y-8 overflow-y-auto">

            <!-- ========== القسم الأول: لوحة الإحصائيات والتحليلات ========== -->
            <div id="overview-section" class="section-view space-y-8">
                
                <!-- صف بطاقات مؤشرات الأداء الرئيسية (KPIs) -->
                <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- البطاقة: إجمالي المبيعات -->
                <div class="bg-darkCard p-6 rounded-2xl border border-darkBorder neon-glow-indigo relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-secondary/5 rounded-full filter blur-xl group-hover:scale-150 transition duration-500"></div>
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">إجمالي المبيعات</p>
                            <h3 id="kpi-total-sales" class="text-2xl font-black text-white mt-2">-- ج.م</h3>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-md mt-3">
                                <i class="fa-solid fa-circle-arrow-up"></i>
                                مبيعات الطلبات المكتملة
                            </span>
                        </div>
                        <div class="w-12 h-12 bg-secondary/20 border border-secondary/30 text-secondary rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-money-bill-trend-up text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- البطاقة: الطلبات النشطة -->
                <div class="bg-darkCard p-6 rounded-2xl border border-darkBorder relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/5 rounded-full filter blur-xl group-hover:scale-150 transition duration-500"></div>
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">الطلبات النشطة</p>
                            <h3 id="kpi-active-orders" class="text-2xl font-black text-white mt-2">--</h3>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-400 bg-amber-500/10 px-2 py-0.5 rounded-md mt-3">
                                <i class="fa-solid fa-rotate animate-spin text-[10px]"></i>
                                قيد التجهيز أو الانتظار
                            </span>
                        </div>
                        <div class="w-12 h-12 bg-amber-500/10 border border-amber-500/20 text-amber-500 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-receipt text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- البطاقة: عدد المنتجات -->
                <div class="bg-darkCard p-6 rounded-2xl border border-darkBorder neon-glow relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-accent/5 rounded-full filter blur-xl group-hover:scale-150 transition duration-500"></div>
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">المنتجات بالمتجر</p>
                            <h3 id="kpi-products-count" class="text-2xl font-black text-white mt-2">--</h3>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-accent bg-accent/10 px-2 py-0.5 rounded-md mt-3">
                                <i class="fa-solid fa-box"></i>
                                نشطة بالكامل
                            </span>
                        </div>
                        <div class="w-12 h-12 bg-accent/10 border border-accent/20 text-accent rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-laptop text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- البطاقة: إجمالي الطلبات المسجلة -->
                <div class="bg-darkCard p-6 rounded-2xl border border-darkBorder relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-rose-500/5 rounded-full filter blur-xl group-hover:scale-150 transition duration-500"></div>
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">إجمالي الطلبات</p>
                            <h3 id="kpi-total-orders" class="text-2xl font-black text-white mt-2">--</h3>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-md mt-3">
                                <i class="fa-solid fa-arrow-trend-up"></i>
                                كل الطلبات المسجلة
                            </span>
                        </div>
                        <div class="w-12 h-12 bg-rose-500/10 border border-rose-500/20 text-rose-500 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-users text-xl"></i>
                        </div>
                    </div>
                </div>

                </section>

                <!-- الرسوم البيانية (مخطط خطي للمبيعات + دائري للفئات) -->
                <section id="analytics" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- مخطط المبيعات الشهري -->
                    <div class="bg-darkCard p-6 rounded-2xl border border-darkBorder lg:col-span-2">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="font-extrabold text-lg text-white">إحصائيات المبيعات والأرباح لعام <?php echo date('Y'); ?></h3>
                                <p class="text-xs text-slate-400 mt-1">رصد لحجم المبيعات الشهري بالجنيه المصري (للطلبات المكتملة فقط)</p>
                            </div>
                            <span class="text-xs bg-slate-800 text-slate-300 py-1 px-3 rounded-lg border border-slate-700">تحديث شهري</span>
                        </div>
                        <div class="h-80 relative">
                            <canvas id="salesLineChart"></canvas> <!-- وسيط الرسم البياني الخطي -->
                        </div>
                    </div>

                    <!-- مخطط توزيع الفئات -->
                    <div class="bg-darkCard p-6 rounded-2xl border border-darkBorder">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="font-extrabold text-lg text-white">توزيع المنتجات</h3>
                                <p class="text-xs text-slate-400 mt-1">نسبة الفئات المختلفة المتوفرة في المخزن</p>
                            </div>
                        </div>
                        <div class="h-80 relative flex items-center justify-center">
                            <canvas id="categoriesDoughnutChart"></canvas> <!-- وسيط الرسم الدائري -->
                        </div>
                    </div>
                </section>
            </div> <!-- نهاية قسم overview-section -->

            <!-- ========== القسم الثاني: إدارة المنتجات (CRUD) ========== -->
            <section id="products-section" class="section-view hidden bg-darkCard rounded-2xl border border-darkBorder overflow-hidden">
                <!-- رأس القسم (بحث + زر إضافة) -->
                <div class="p-6 border-b border-darkBorder flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-900/30">
                    <div>
                        <h3 class="font-extrabold text-lg text-white flex items-center gap-2">
                            <i class="fa-solid fa-laptop text-accent"></i>
                            جدول إدارة منتجات المتجر
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">إضافة وتعديل وحذف المنتجات مباشرة في قاعدة البيانات</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                        <!-- حقل البحث عن منتج -->
                        <div class="relative w-full sm:w-64">
                            <input type="text" id="productSearch" oninput="filterProducts()" placeholder="البحث عن منتج..." class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-darkBg border border-darkBorder text-slate-200 text-sm focus:border-accent outline-none transition">
                            <i class="fa-solid fa-magnifying-glass absolute top-3.5 right-3.5 text-slate-400 text-xs"></i>
                        </div>

                        <!-- زر إضافة منتج جديد -->
                        <button onclick="openProductModal('add')" class="bg-accent hover:bg-cyan-400 text-primary font-extrabold py-2.5 px-5 rounded-xl text-sm transition duration-300 flex items-center justify-center gap-2 w-full sm:w-auto shadow-lg shadow-accent/15">
                            <i class="fa-solid fa-circle-plus"></i>
                            إضافة منتج جديد
                        </button>
                    </div>
                </div>

                <!-- جدول المنتجات -->
                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        <thead>
                            <tr class="bg-darkBg/60 text-slate-300 border-b border-darkBorder text-xs uppercase tracking-wider font-bold">
                                <th class="p-4">اسم المنتج</th>
                                <th class="p-4">الفئة</th>
                                <th class="p-4">الماركة</th>
                                <th class="p-4">المخزون</th>
                                <th class="p-4">السعر</th>
                                <th class="p-4">الوصف</th>
                                <th class="p-4 text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody id="products-table-body" class="divide-y divide-darkBorder text-sm text-slate-300">
                            <!-- سيتم ملؤه عبر JavaScript -->
                        </tbody>
                    </table>
                    <p id="products-empty-state" class="hidden text-center text-slate-500 text-sm py-10">لا توجد منتجات مطابقة</p>
                </div>
            </section>

            <!-- ========== القسم الثالث: إدارة الطلبات ========== -->
            <section id="orders-section" class="section-view hidden bg-darkCard rounded-2xl border border-darkBorder overflow-hidden">
                <div class="p-6 border-b border-darkBorder bg-slate-900/30">
                    <h3 class="font-extrabold text-lg text-white flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-accent"></i>
                        إدارة الطلبات الأخيرة
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">متابعة حالة الطلبات وتحديثها مباشرة لتغيير التدفق البرمجي</p>
                </div>

                <!-- جدول الطلبات -->
                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        <thead>
                            <tr class="bg-darkBg/60 text-slate-300 border-b border-darkBorder text-xs font-bold">
                                <th class="p-4">رقم الطلب</th>
                                <th class="p-4">العميل</th>
                                <th class="p-4">رقم الهاتف</th>
                                <th class="p-4">المنتج</th>
                                <th class="p-4">المجموع</th>
                                <th class="p-4">حالة الطلب</th>
                                <th class="p-4 text-center">الإجراء</th>
                            </tr>
                        </thead>
                        <tbody id="orders-table-body" class="divide-y divide-darkBorder text-sm text-slate-300">
                            <!-- سيتم ملؤه عبر JavaScript -->
                        </tbody>
                    </table>
                </div>
            </section>

        </div> <!-- نهاية حاوية الأقسام -->
    </main>

    <!-- ============================================================ -->
    <!-- (4) نافذة منبثقة (مودال) لإضافة / تعديل المنتجات            -->
    <!-- ============================================================ -->
    <div id="productModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/75 backdrop-blur-sm opacity-0 pointer-events-none transition duration-300">
        <div class="bg-darkCard border border-darkBorder rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl transform scale-95 transition duration-300">
            <!-- رأس المودال -->
            <div class="p-6 border-b border-darkBorder bg-slate-900/40 flex justify-between items-center shrink-0">
                <h3 id="modalTitle" class="font-black text-lg text-white">إضافة منتج جديد</h3>
                <button type="button" onclick="closeProductModal()" class="text-slate-400 hover:text-white text-lg focus:outline-none">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- جسم المودال (نموذج الإدخال) -->
            <form id="productForm" onsubmit="saveProduct(event)" class="p-6 space-y-5 max-h-[75vh] overflow-y-auto">
                <!-- حقل مخفي لحفظ معرف المنتج في حالة التعديل -->
                <input type="hidden" id="modalProductId">

                <!-- اسم المنتج -->
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">اسم المنتج</label>
                    <input type="text" id="modalProductName" required class="w-full px-4 py-3 rounded-xl bg-darkBg border border-darkBorder text-slate-200 text-sm focus:border-accent outline-none transition" placeholder="مثال: MacBook Pro M2">
                </div>

                <!-- الفئة والسعر في صف واحد -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">الفئة</label>
                        <select id="modalProductCategory" required class="w-full px-4 py-3 rounded-xl bg-darkBg border border-darkBorder text-slate-300 text-sm focus:border-accent outline-none transition cursor-pointer">
                            <option value="لابتوب">لابتوب</option>
                            <option value="كاميرات">كاميرات</option>
                            <option value="شاشات">شاشات</option>
                            <option value="اكسسوارات">اكسسوارات</option>
                            <option value="أنظمة أمنية">أنظمة أمنية</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">السعر (ج.م)</label>
                        <input type="number" id="modalProductPrice" required min="0" step="0.01" class="w-full px-4 py-3 rounded-xl bg-darkBg border border-darkBorder text-slate-200 text-sm focus:border-accent outline-none transition" placeholder="مثال: 45000">
                    </div>
                </div>

                <!-- الماركة والمخزون في صف واحد -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">الماركة</label>
                        <select id="modalProductBrand" required class="w-full px-4 py-3 rounded-xl bg-darkBg border border-darkBorder text-slate-300 text-sm focus:border-accent outline-none transition cursor-pointer">
                            <option value="غير محدد">غير محدد</option>
                            <option value="Apple">Apple</option>
                            <option value="Dell">Dell</option>
                            <option value="HP">HP</option>
                            <option value="Lenovo">Lenovo</option>
                            <option value="Asus">Asus</option>
                            <option value="Samsung">Samsung</option>
                            <option value="Sony">Sony</option>
                            <option value="Logitech">Logitech</option>
                            <option value="Razer">Razer</option>
                            <option value="Eufy">Eufy</option>
                            <option value="Ring">Ring</option>
                            <option value="Canon">Canon</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">المخزون</label>
                        <input type="number" id="modalProductStock" required min="0" step="1" class="w-full px-4 py-3 rounded-xl bg-darkBg border border-darkBorder text-slate-200 text-sm focus:border-accent outline-none transition" placeholder="مثال: 10">
                    </div>
                </div>

                <!-- وصف المنتج -->
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">وصف المنتج</label>
                    <textarea id="modalProductDesc" rows="3" required class="w-full px-4 py-3 rounded-xl bg-darkBg border border-darkBorder text-slate-200 text-sm focus:border-accent outline-none transition" placeholder="اكتب تفاصيل ومواصفات المنتج بدقة..."></textarea>
                </div>

                <!-- رفع صورة المنتج -->
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">صورة المنتج</label>
                    <input type="file" id="modalProductImage" accept="image/jpeg,image/png,image/webp" class="w-full px-4 py-3 rounded-xl bg-darkBg border border-darkBorder text-slate-400 text-sm focus:border-accent outline-none transition file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-accent file:text-primary hover:file:bg-cyan-400 cursor-pointer">
                    <p class="text-xs text-slate-500 mt-1">يُفضل رفع صور بصيغة JPG أو PNG. سيتم ضغطها تلقائياً وتصغيرها. اتركه فارغاً عند التعديل للإبقاء على الصورة الحالية.</p>
                </div>

                <!-- أزرار الإجراءات (حفظ / إلغاء) -->
                <div class="flex gap-4 pt-4 border-t border-darkBorder">
                    <button type="submit" class="flex-1 bg-accent hover:bg-cyan-400 text-primary font-black py-3 rounded-xl transition duration-300 shadow-lg shadow-accent/15">
                        حفظ التغييرات
                    </button>
                    <button type="button" onclick="closeProductModal()" class="flex-1 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold py-3 rounded-xl border border-slate-700 transition">
                        إلغاء
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- (5) إشعار النجاح (Toast) الظهور أسفل اليسار                -->
    <!-- ============================================================ -->
    <div id="toast" class="fixed bottom-8 left-8 z-50 bg-emerald-500 text-white font-bold py-4 px-6 rounded-xl shadow-2xl flex items-center gap-3 transform translate-y-24 opacity-0 transition duration-500 pointer-events-none">
        <i class="fa-solid fa-circle-check text-xl"></i>
        <span id="toastMessage">تم حفظ التعديلات بنجاح!</span>
    </div>

    <!-- ============================================================ -->
    <!-- (6) منطق العمليات (JavaScript)                               -->
    <!-- ============================================================ -->
    <script>
        // ----------------------------------------------
        // المتغيرات العامة لتخزين المنتجات والطلبات
        // ----------------------------------------------
        let products = [];   // مصفوفة المنتجات القادمة من الخادم
        let orders = [];     // مصفوفة الطلبات

        // عند تحميل المستند بالكامل يتم جلب البيانات
        document.addEventListener('DOMContentLoaded', () => {
            fetchDashboardData();
        });

        // ----------------------------------------------
        // دالة مساعدة: تنظيف النصوص لتجنب هجمات XSS
        // ----------------------------------------------
        function escapeHtml(str) {
            if (str === null || str === undefined) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        // ----------------------------------------------
        // التبديل بين الأقسام (إظهار/إخفاء) وتحديث الـ Sidebar
        // ----------------------------------------------
        function showSection(sectionId, element) {
            // إخفاء جميع الأقسام
            document.querySelectorAll('.section-view').forEach(el => {
                el.classList.add('hidden');
            });
            // إظهار القسم المطلوب
            document.getElementById(sectionId).classList.remove('hidden');

            // إزالة التنسيق النشط من جميع روابط القائمة
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.classList.remove('bg-secondary/20', 'border-secondary', 'text-white', 'font-bold', 'active');
                link.classList.add('hover:bg-slate-800/50', 'text-slate-300', 'font-semibold', 'border-transparent');
                const icon = link.querySelector('i');
                if (icon) {
                    icon.classList.remove('text-accent');
                    icon.classList.add('text-slate-400');
                }
            });

            // تطبيق التنسيق النشط على الرابط المحدد
            if (element) {
                element.classList.remove('hover:bg-slate-800/50', 'text-slate-300', 'font-semibold', 'border-transparent');
                element.classList.add('bg-secondary/20', 'border-secondary', 'text-white', 'font-bold', 'active');
                const icon = element.querySelector('i');
                if (icon) {
                    icon.classList.remove('text-slate-400');
                    icon.classList.add('text-accent');
                }
            }

            // تحديث عنوان القسم في الشريط العلوي
            const titles = {
                'overview-section': 'لوحة الإدارة والتحليلات',
                'products-section': 'إدارة منتجات المتجر',
                'orders-section': 'إدارة طلبات العملاء'
            };
            document.getElementById('section-title').innerText = titles[sectionId] || 'لوحة الإدارة';
        }

        // ----------------------------------------------
        // جلب جميع بيانات لوحة التحكم من الخادم (API)
        // ----------------------------------------------
        async function fetchDashboardData() {
            try {
                const res = await fetch('api.php?action=get_dashboard_data');
                if (!res.ok) throw new Error('HTTP ' + res.status);
                const data = await res.json();
                if (data.success) {
                    products = data.products || [];
                    orders = data.orders || [];

                    // تحديث الواجهة بناءً على البيانات الجديدة
                    renderProducts();
                    renderOrders();
                    renderCharts(data.stats ? data.stats.monthly_sales : null);
                    updateKpis(data.stats);
                } else {
                    triggerToast(data.message || 'حدث خطأ في جلب البيانات', 'error');
                }
            } catch (err) {
                console.error(err);
                triggerToast('حدث خطأ في الاتصال بالخادم', 'error');
            }
        }

        // ----------------------------------------------
        // تحديث بطاقات المؤشرات (KPIs) بالأرقام
        // ----------------------------------------------
        function updateKpis(stats) {
            document.getElementById('kpi-products-count').innerText = `${products.length} منتجات`;
            document.getElementById('kpi-total-orders').innerText = `${orders.length} طلب`;
            if (stats) {
                const totalSales = Number(stats.total_sales || 0);
                document.getElementById('kpi-total-sales').innerText = `${totalSales.toLocaleString()} ج.م`;
                document.getElementById('kpi-active-orders').innerText = `${stats.active_orders || 0} طلب`;
            }
        }

        // ----------------------------------------------
        // عرض رسالة Toast (نجاح أو خطأ)
        // ----------------------------------------------
        function triggerToast(message, type = "success") {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toastMessage');

            toastMsg.innerText = message;
            // تغيير لون الخلفية حسب نوع الرسالة
            if (type === "error") {
                toast.classList.remove('bg-emerald-500');
                toast.classList.add('bg-rose-500');
            } else {
                toast.classList.remove('bg-rose-500');
                toast.classList.add('bg-emerald-500');
            }

            // إظهار الإشعار
            toast.classList.remove('translate-y-24', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            // إخفاؤه بعد 3 ثوان
            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-24', 'opacity-0');
            }, 3000);
        }

        // ----------------------------------------------
        // عرض المنتجات في جدول المنتجات
        // (يقبل مصفوفة اختيارية للفلترة)
        // ----------------------------------------------
        function renderProducts(filtered = products) {
            const body = document.getElementById('products-table-body');
            const emptyState = document.getElementById('products-empty-state');
            body.innerHTML = '';

            if (filtered.length === 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }

            filtered.forEach((product) => {
                const tr = document.createElement('tr');
                tr.className = "hover:bg-slate-800/20 transition";
                tr.innerHTML = `
                    <td class="p-4 font-bold text-white">${escapeHtml(product.name)}</td>
                    <td class="p-4">
                        <span class="text-xs bg-slate-800 border border-slate-700 text-accent font-semibold px-2.5 py-1 rounded-lg">
                            ${escapeHtml(product.category)}
                        </span>
                    </td>
                    <td class="p-4 text-slate-300">${escapeHtml(product.brand || 'غير محدد')}</td>
                    <td class="p-4 text-slate-300">${Number(product.stock || 0)}</td>
                    <td class="p-4 font-extrabold text-accent">${Number(product.price).toLocaleString()} ج.م</td>
                    <td class="p-4 text-xs text-slate-400 max-w-xs truncate" title="${escapeHtml(product.desc)}">${escapeHtml(product.desc)}</td>
                    <td class="p-4 text-center">
                        <div class="flex gap-2 justify-center">
                            <button onclick="openProductModal('edit', ${product.id})" class="w-8 h-8 rounded-lg bg-indigo-600/20 text-indigo-400 border border-indigo-500/20 hover:bg-indigo-600 hover:text-white transition flex items-center justify-center" title="تعديل">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <button onclick="deleteProduct(${product.id})" class="w-8 h-8 rounded-lg bg-rose-600/20 text-rose-400 border border-rose-500/20 hover:bg-rose-600 hover:text-white transition flex items-center justify-center" title="حذف">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </td>
                `;
                body.appendChild(tr);
            });

            // تحديث عدد المنتجات في KPI
            document.getElementById('kpi-products-count').innerText = `${products.length} منتجات`;
        }

        // ----------------------------------------------
        // فلترة المنتجات حسب نص البحث
        // ----------------------------------------------
        function filterProducts() {
            const query = document.getElementById('productSearch').value.toLowerCase();
            const filtered = products.filter(p => {
                const n = p.name ? p.name.toLowerCase() : '';
                const c = p.category ? p.category.toLowerCase() : '';
                const b = p.brand ? p.brand.toLowerCase() : '';
                const d = p.desc ? p.desc.toLowerCase() : '';
                return n.includes(query) || c.includes(query) || b.includes(query) || d.includes(query);
            });
            renderProducts(filtered);
        }

        // ----------------------------------------------
        // فتح المودال (إضافة أو تعديل منتج)
        // ----------------------------------------------
        function openProductModal(mode, productId = null) {
            const modal = document.getElementById('productModal');
            const title = document.getElementById('modalTitle');
            const form = document.getElementById('productForm');

            form.reset(); // تفريغ الحقول

            if (mode === 'add') {
                title.innerText = 'إضافة منتج جديد للمتجر';
                document.getElementById('modalProductId').value = '';
            } else if (mode === 'edit' && productId !== null) {
                const product = products.find(p => p.id == productId);
                if (!product) return;
                title.innerText = 'تعديل بيانات المنتج';
                document.getElementById('modalProductId').value = product.id;
                document.getElementById('modalProductName').value = product.name;
                document.getElementById('modalProductCategory').value = product.category;
                document.getElementById('modalProductBrand').value = product.brand || 'غير محدد';
                document.getElementById('modalProductStock').value = product.stock || 0;
                document.getElementById('modalProductPrice').value = product.price;
                document.getElementById('modalProductDesc').value = product.desc;
            }

            // إظهار المودال بتأثير حركي
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.querySelector('.transform').classList.remove('scale-95');
            modal.querySelector('.transform').classList.add('scale-100');
        }

        // ----------------------------------------------
        // إغلاق المودال
        // ----------------------------------------------
        function closeProductModal() {
            const modal = document.getElementById('productModal');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.querySelector('.transform').classList.remove('scale-100');
            modal.querySelector('.transform').classList.add('scale-95');
        }

        // ----------------------------------------------
        // حفظ المنتج (إضافة جديدة أو تعديل)
        // ----------------------------------------------
        async function saveProduct(event) {
            event.preventDefault();

            const productId = document.getElementById('modalProductId').value;
            const id = productId !== '' ? parseInt(productId, 10) : null;
            const name = document.getElementById('modalProductName').value.trim();
            const category = document.getElementById('modalProductCategory').value;
            const brand = document.getElementById('modalProductBrand').value;
            const priceRaw = document.getElementById('modalProductPrice').value;
            const stockRaw = document.getElementById('modalProductStock').value;
            const desc = document.getElementById('modalProductDesc').value.trim();
            const imageInput = document.getElementById('modalProductImage');

            const price = parseFloat(priceRaw);
            const stock = parseInt(stockRaw, 10);

            // التحقق من صحة المدخلات الأساسية
            if (!name || !category || !brand || isNaN(price) || price < 0 || isNaN(stock) || stock < 0 || !desc) {
                triggerToast('يرجى تعبئة كل الحقول بقيم صحيحة', 'error');
                return;
            }

            const action = id ? 'update_product' : 'add_product';

            // تجهيز بيانات النموذج لإرسالها (بما فيها الصورة إن وجدت)
            const formData = new FormData();
            formData.append('action', action);
            if (id) formData.append('id', id);
            formData.append('name', name);
            formData.append('category', category);
            formData.append('brand', brand);
            formData.append('price', price);
            formData.append('stock', stock);
            formData.append('desc', desc);

            if (imageInput.files.length > 0) {
                formData.append('image', imageInput.files[0]);
            }

            // تعطيل الزر مؤقتاً ومنع تكرار الإرسال
            const btn = event.target.querySelector('button[type="submit"]');
            const origText = btn.innerText;
            btn.innerText = 'جاري الحفظ...';
            btn.disabled = true;

            try {
                const res = await fetch('api.php', {
                    method: 'POST',
                    body: formData
                });
                if (!res.ok) throw new Error('HTTP ' + res.status);
                const data = await res.json();

                if (data.success) {
                    triggerToast(data.message);
                    closeProductModal();
                    fetchDashboardData(); // تحديث البيانات بعد الحفظ
                } else {
                    triggerToast(data.message, 'error');
                }
            } catch (err) {
                console.error(err);
                triggerToast('حدث خطأ في الاتصال بالخادم', 'error');
            }

            // إعادة زر الحفظ لحالته الأصلية
            btn.innerText = origText;
            btn.disabled = false;
        }

        // ----------------------------------------------
        // حذف منتج بعد تأكيد المستخدم
        // ----------------------------------------------
        async function deleteProduct(productId) {
            if (confirm('هل أنت متأكد من رغبتك في حذف هذا المنتج؟')) {
                const id = parseInt(productId, 10);
                try {
                    const res = await fetch('api.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ action: 'delete_product', id })
                    });
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    const data = await res.json();

                    if (data.success) {
                        triggerToast('تم حذف المنتج بنجاح!');
                        fetchDashboardData();
                    } else {
                        triggerToast(data.message, 'error');
                    }
                } catch (err) {
                    console.error(err);
                    triggerToast('حدث خطأ أثناء الحذف', 'error');
                }
            }
        }

        // ----------------------------------------------
        // عرض الطلبات في جدول الطلبات
        // ----------------------------------------------
        function renderOrders() {
            const body = document.getElementById('orders-table-body');
            body.innerHTML = '';

            orders.forEach((order, idx) => {
                // تحديد شكل الوسم (badge) حسب حالة الطلب
                let badgeClass = "bg-slate-800 text-slate-300";
                if (order.status === "مكتمل") badgeClass = "bg-emerald-500/10 border border-emerald-500/20 text-emerald-400";
                else if (order.status === "قيد التجهيز") badgeClass = "bg-blue-500/10 border border-blue-500/20 text-blue-400";
                else if (order.status === "قيد الانتظار") badgeClass = "bg-amber-500/10 border border-amber-500/20 text-amber-400";
                else if (order.status === "تم الشحن") badgeClass = "bg-purple-500/10 border border-purple-500/20 text-purple-400";
                else if (order.status === "ملغي") badgeClass = "bg-rose-500/10 border border-rose-500/20 text-rose-400";

                const phoneDisplay = order.phone || '—';

                const tr = document.createElement('tr');
                tr.className = "hover:bg-slate-800/20 transition";
                tr.innerHTML = `
                    <td class="p-4 font-mono font-bold text-slate-400">${escapeHtml(order.id)}</td>
                    <td class="p-4 font-bold text-white">${escapeHtml(order.customer)}</td>
                    <td class="p-4 font-mono text-accent dir-ltr text-right">${escapeHtml(phoneDisplay)}</td>
                    <td class="p-4 text-slate-300">${escapeHtml(order.product)}</td>
                    <td class="p-4 font-bold text-accent">${Number(order.total).toLocaleString()} ج.م</td>
                    <td class="p-4">
                        <span class="text-xs font-semibold px-2.5 py-1.5 rounded-lg ${badgeClass}">
                            ${escapeHtml(order.status)}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <!-- قائمة منسدلة لتغيير الحالة -->
                            <select onchange="updateOrderStatus(${idx}, this.value)" class="text-xs bg-darkBg border border-darkBorder rounded-lg px-2 py-1.5 focus:border-accent text-slate-300 outline-none cursor-pointer">
                                <option value="قيد الانتظار" ${order.status === 'قيد الانتظار' ? 'selected' : ''}>قيد الانتظار</option>
                                <option value="قيد التجهيز" ${order.status === 'قيد التجهيز' ? 'selected' : ''}>قيد التجهيز</option>
                                <option value="تم الشحن" ${order.status === 'تم الشحن' ? 'selected' : ''}>تم الشحن</option>
                                <option value="مكتمل" ${order.status === 'مكتمل' ? 'selected' : ''}>مكتمل</option>
                                <option value="ملغي" ${order.status === 'ملغي' ? 'selected' : ''}>ملغي</option>
                            </select>
                            <!-- زر حذف الطلب -->
                            <button onclick="deleteOrder('${escapeHtml(order.id)}')" class="w-8 h-8 rounded-lg bg-rose-600/20 text-rose-400 border border-rose-500/20 hover:bg-rose-600 hover:text-white transition flex items-center justify-center" title="حذف الطلب">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </td>
                `;
                body.appendChild(tr);
            });
        }

        // ----------------------------------------------
        // تحديث حالة الطلب عبر API
        // ----------------------------------------------
        async function updateOrderStatus(index, newStatus) {
            const id = orders[index].id;
            try {
                const res = await fetch('api.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ action: 'update_order_status', id, status: newStatus })
                });
                if (!res.ok) throw new Error('HTTP ' + res.status);
                const data = await res.json();

                if (data.success) {
                    triggerToast('تم تحديث حالة الطلب بنجاح!');
                    fetchDashboardData(); // إعادة جلب البيانات لتحديث الجدول
                } else {
                    triggerToast(data.message, 'error');
                    renderOrders(); // إعادة عرض الجدول بالقيم السابقة
                }
            } catch (err) {
                console.error(err);
                triggerToast('حدث خطأ أثناء التحديث', 'error');
            }
        }

        // ----------------------------------------------
        // حذف طلب نهائياً
        // ----------------------------------------------
        async function deleteOrder(orderId) {
            if (confirm('هل أنت متأكد من رغبتك في حذف هذا الطلب نهائياً؟')) {
                try {
                    const res = await fetch('api.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ action: 'delete_order', id: orderId })
                    });
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    const data = await res.json();

                    if (data.success) {
                        triggerToast('تم حذف الطلب بنجاح!');
                        fetchDashboardData();
                    } else {
                        triggerToast(data.message, 'error');
                    }
                } catch (err) {
                    console.error(err);
                    triggerToast('حدث خطأ أثناء الحذف', 'error');
                }
            }
        }

        // ==============================================
        // (7) إدارة الرسوم البيانية (Charts)
        // ==============================================
        let salesChart = null;      // كائن المخطط الخطي
        let doughnutChart = null;   // كائن المخطط الدائري

        /**
         * إنشاء أو تحديث الرسوم البيانية بناءً على بيانات المبيعات الشهرية.
         * إذا كانت Chart.js غير محملة يتم إلغاء العملية.
         */
        function renderCharts(monthlySales) {
            if (typeof Chart === 'undefined') {
                console.warn("Chart.js not loaded.");
                return;
            }
            // تدمير المخططات السابقة إن وجدت لتحديثها
            if (salesChart) salesChart.destroy();
            if (doughnutChart) doughnutChart.destroy();

            // ----- المخطط الخطي: المبيعات الشهرية -----
            const salesCtx = document.getElementById('salesLineChart').getContext('2d');
            salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
                    datasets: [{
                        label: 'المبيعات الشهرية (ج.م)',
                        data: monthlySales || [45000, 68000, 115000, 150000, 195000, 180000, 240000, 290000, 275000, 310000, 385000, 420000],
                        borderColor: '#06B6D4',
                        backgroundColor: 'rgba(6, 182, 212, 0.05)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#0B0F19',
                        pointBorderColor: '#06B6D4',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            grid: { color: '#1F2937' },
                            ticks: { color: '#94A3B8', font: { family: 'Cairo' } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#94A3B8', font: { family: 'Cairo' } }
                        }
                    }
                }
            });

            // ----- المخطط الدائري (دونات): توزيع المنتجات حسب الفئة -----
            const doughnutCtx = document.getElementById('categoriesDoughnutChart').getContext('2d');
            doughnutChart = new Chart(doughnutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['لابتوب', 'كاميرات', 'شاشات', 'اكسسوارات', 'أنظمة أمنية'],
                    datasets: [{
                        data: [0, 0, 0, 0, 0], // يتم تحديثه لاحقاً
                        backgroundColor: ['#4F46E5', '#06B6D4', '#8B5CF6', '#F59E0B', '#10B981'],
                        borderColor: '#111827',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { color: '#94A3B8', font: { family: 'Cairo', size: 11 }, padding: 15 }
                        }
                    },
                    cutout: '65%'
                }
            });

            // تحديث بيانات المخطط الدائري بناءً على المنتجات الحالية
            updateChartValues();
        }

        /**
         * حساب عدد المنتجات في كل فئة وتحديث بيانات المخطط الدائري.
         */
        function updateChartValues() {
            if (!doughnutChart) return;

            const counts = {
                'لابتوب': 0,
                'كاميرات': 0,
                'شاشات': 0,
                'اكسسوارات': 0,
                'أنظمة أمنية': 0
            };

            products.forEach(p => {
                if (counts[p.category] !== undefined) {
                    counts[p.category]++;
                }
            });

            doughnutChart.data.datasets[0].data = [
                counts['لابتوب'],
                counts['كاميرات'],
                counts['شاشات'],
                counts['اكسسوارات'],
                counts['أنظمة أمنية']
            ];

            doughnutChart.update();
        }
    </script>
</body>
</html>