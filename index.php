<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 
?>
<head>
    <meta name="google-site-verification" content="MbRqY-uSEni-fQMFEFYPpfpTWqreDpf6eTb0cxM3Ozc" />
</head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2 family=Cairo:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        /* لوحة ألوان زرقاء داكنة وتقنية فاخرة */
        --navy-dark: #0A0F1D;      /* الأزرق الداكن العميق جداً */
        --navy-medium: #141B2D;    /* الكحلي الوسيط للأزرار والعناصر */
        --blue-primary: #2563EB;   /* الأزرق الحيوي للتفاصيل الهامة */
        --blue-accent: #60A5FA;    /* الأزرق المضيء لحالات التحويم */
        --text-main: #0F172A;      /* لون النصوص الأساسية */
        --text-muted: #64748B;     /* لون النصوص الثانوية */
        --bg-light: #F8FAFC;       /* لون الخلفية المريح للعين */
        --border-color: #E2E8F0;   /* لون الحدود الهندسية */
    }

    /* تطبيق الخطوط الاحترافية */
    .ds-font-display { font-family: 'Cairo', sans-serif; }
    .ds-font-mono { font-family: 'JetBrains Mono', monospace; }

    /* تأثير الشبكة الهندسية الخلفية المتطورة (Blueprint Grid) */
    .ds-blueprint {
        background-image: 
            linear-gradient(rgba(37, 99, 235, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(37, 99, 235, 0.05) 1px, transparent 1px);
        background-size: 36px 36px;
        background-position: center;
        mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, black 60%, transparent 100%);
    }

    /* [ANIMATION 1] أنيميشن الطفو الانسيابي لكارت المنتج */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .animate-float {
        animation: float 5s ease-in-out infinite;
    }

    /* [ANIMATION 2] أنيميشن ظهور محتوى الصفحة بشكل تدريجي صاعد */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(24px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* مؤشرات زوايا التركيز لكارت الفحص */
    .ds-specimen { position: relative; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    .ds-corner { position: absolute; width: 16px; height: 16px; transition: all 0.3s ease; z-index: 10; }
    .ds-corner.tl { top: -2px; left: -2px; border-top: 2.5px solid var(--blue-primary); border-left: 2.5px solid var(--blue-primary); }
    .ds-corner.tr { top: -2px; right: -2px; border-top: 2.5px solid var(--blue-primary); border-right: 2.5px solid var(--blue-primary); }
    .ds-corner.bl { bottom: -2px; left: -2px; border-bottom: 2.5px solid var(--blue-primary); border-left: 2.5px solid var(--blue-primary); }
    .ds-corner.br { bottom: -2px; right: -2px; border-bottom: 2.5px solid var(--blue-primary); border-right: 2.5px solid var(--blue-primary); }

    /* تفاعل الكارت عند تمرير الماوس */
    .ds-specimen:hover .ds-corner { width: 24px; height: 24px; border-color: var(--blue-accent); }
    .ds-specimen:hover { box-shadow: 0 30px 60px -15px rgba(10, 15, 29, 0.12); }

    /* أزرار بريميوم بتأثيرات حركة ناعمة */
    .btn-premium-primary {
        background: linear-gradient(135deg, var(--navy-dark), var(--navy-medium));
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: all 0.3s ease;
    }
    .btn-premium-primary:hover {
        background: linear-gradient(135deg, var(--blue-primary), #1d4ed8);
        transform: translateY(-2px);
        box-shadow: 0 12px 24px -6px rgba(37, 99, 235, 0.35);
    }

    .btn-premium-outline {
        border: 1.5px solid var(--navy-dark);
        color: var(--navy-dark);
        transition: all 0.3s ease;
    }
    .btn-premium-outline:hover {
        background: rgba(37, 99, 235, 0.04);
        border-color: var(--blue-primary);
        color: var(--blue-primary);
        transform: translateY(-2px);
    }

    /* تفاعل أقسام الإحصائيات */
    .stat-item { transition: all 0.3s ease; }
    .stat-item:hover { transform: translateY(-2px); }
    .stat-item:hover .stat-num { color: var(--blue-primary); }

    @media (prefers-reduced-motion: reduce) {
        .animate-float, .animate-fade-in-up, .ds-specimen, .btn-premium-primary, .btn-premium-outline { 
            animation: none !important; transition: none !important; transform: none !important; 
        }
    }
</style>

<section id="hero" class="relative bg-slate-50 overflow-hidden pt-32 pb-24 ds-font-display" dir="rtl">
    <div class="absolute inset-0 ds-blueprint pointer-events-none"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-7 space-y-8 text-right animate-fade-in-up">
                
                <div class="inline-flex items-center gap-2 bg-blue-50/80 border border-blue-100 px-4 py-1.5 rounded-full">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    <span class="ds-font-mono text-[11px] font-bold text-blue-700 tracking-wider">NEXTECH // VERIFIED_SPEC_01</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-950 leading-[1.2]">
                    كل جهاز <span class="bg-gradient-to-l from-blue-600 to-indigo-950 bg-clip-text text-transparent">بيتفحص بدقة</span> <br>
                    قبل ما يوصل ليدك
                </h1>

                <p class="max-w-2xl text-slate-600 text-base sm:text-lg leading-relaxed font-normal">
                    لابتوبات، كاميرات، وأنظمة أمنية بمواصفات حقيقية موثقة بوضوح تام. نلغي الاحتمالات والمفاجآت؛ لأن كل منتج يخضع لفحص فيزيائي وبرمجي شامل قبل الشحن مع ضمان رسمي يضمن كامل حقوقك.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 pt-4 justify-start">
                    <a href="store.php" class="btn-premium-primary inline-flex items-center justify-center gap-3 px-8 py-4 rounded-xl font-bold text-base shadow-sm">
                        تصفح المتجر الرقمي
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                    </a>
                    <a href="#contact" class="btn-premium-outline inline-flex items-center justify-center px-8 py-4 rounded-xl font-bold text-base">
                        تواصل مع مستشار فني
                    </a>
                </div>

                <div class="pt-8 border-t border-slate-200 grid grid-cols-3 gap-4 max-w-lg">
                    <div class="stat-item text-right">
                        <p class="stat-num text-3xl font-black text-slate-900 ds-font-mono tracking-tight transition-colors">+12K</p>
                        <p class="text-xs font-semibold text-slate-500 mt-1">عميل يثق بنا</p>
                    </div>
                    <div class="stat-item text-right border-r border-slate-200 pr-4">
                        <p class="stat-num text-3xl font-black text-slate-900 ds-font-mono tracking-tight transition-colors">100%</p>
                        <p class="text-xs font-semibold text-slate-500 mt-1">مفحوص مخبرياً</p>
                    </div>
                    <div class="stat-item text-right border-r border-slate-200 pr-4">
                        <p class="stat-num text-3xl font-black text-slate-900 ds-font-mono tracking-tight transition-colors">24/7</p>
                        <p class="text-xs font-semibold text-slate-500 mt-1">دعم فني حي</p>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-5 flex justify-center lg:justify-end animate-fade-in-up" style="animation-delay: 0.15s;">
                <div class="ds-specimen animate-float bg-white p-4 rounded-2xl border border-slate-100 max-w-[380px] w-full shadow-lg">
                    
                    <span class="ds-corner tl"></span>
                    <span class="ds-corner tr"></span>
                    <span class="ds-corner bl"></span>
                    <span class="ds-corner br"></span>

                    <div class="relative overflow-hidden rounded-xl bg-slate-950 aspect-[4/3]">
                        <img src="https://images.unsplash.com/photo-1603302576837-37561b2e2302?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="hp" class="w-full h-full object-cover opacity-95 transition-transform duration-700 hover:scale-105">
                        
                        <div class="absolute bottom-3 inset-x-3 bg-slate-950/80 backdrop-blur-md py-2.5 px-4 rounded-lg flex justify-between items-center border border-white/10">
                            <span class="ds-font-mono text-[11px] font-medium text-slate-200 tracking-wide">16GB RAM · 512GB SSD</span>
                            <span class="ds-font-mono text-[11px] text-amber-400 font-bold flex items-center gap-1">
                                <i class="fa-solid fa-star text-[10px]"></i> 4.9
                            </span>
                        </div>
                    </div>

                    <div class="pt-5 text-right">
                        <div class="flex justify-between items-center mb-1">
                            <span class="ds-font-mono text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">PASSED QA TEST</span>
                            <span class="ds-font-mono text-[11px] text-slate-400">SKU · LP-1042</span>
                        </div>
                        <h2 class="text-xl font-bold text-slate-950 mb-2">hp</h2>
                        <p class="text-slate-500 text-sm leading-relaxed font-normal">
                            معمارية هندسية متطورة توفر كفاءة معالجة فائقة مخصصة لتلبية تطلعات المحترفين وصناع المحتوى.
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>



<!-- Services / Categories Section -->
<section id="services" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">خدماتنا ومنتجاتنا</h2>
            <div class="w-24 h-1 bg-secondary mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">نقدم لك كل ما تحتاجه من حلول تقنية متكاملة بأعلى معايير الجودة.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Service 1 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2 group border border-gray-100" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-secondary transition duration-300">
                    <i class="fa-solid fa-laptop text-2xl text-secondary group-hover:text-white transition duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-primary mb-3">أجهزة لابتوب</h3>
                <p class="text-gray-600 leading-relaxed">أحدث أجهزة اللابتوب لجميع الاستخدامات، من الدراسة والعمل إلى الألعاب والتصميم.</p>
            </div>

            <!-- Service 2 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2 group border border-gray-100" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-cyan-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-accent transition duration-300">
                    <i class="fa-solid fa-video text-2xl text-accent group-hover:text-white transition duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-primary mb-3">كاميرات مراقبة</h3>
                <p class="text-gray-600 leading-relaxed">أنظمة أمنية متكاملة وكاميرات مراقبة عالية الدقة لحماية منزلك وممتلكاتك.</p>
            </div>

            <!-- Service 3 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2 group border border-gray-100" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-500 transition duration-300">
                    <i class="fa-solid fa-screwdriver-wrench text-2xl text-purple-500 group-hover:text-white transition duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-primary mb-3">صيانة متخصصة</h3>
                <p class="text-gray-600 leading-relaxed">مركز صيانة معتمد لإصلاح جميع أعطال الكمبيوتر واللابتوب بأيدي خبراء.</p>
            </div>

            <!-- Service 4 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2 group border border-gray-100" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-green-500 transition duration-300">
                    <i class="fa-solid fa-desktop text-2xl text-green-500 group-hover:text-white transition duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-primary mb-3">أجهزة كمبيوتر</h3>
                <p class="text-gray-600 leading-relaxed">تجميعات كمبيوتر احترافية للألعاب والأعمال الهندسية والمكتبية.</p>
            </div>

            <!-- Service 5 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2 group border border-gray-100" data-aos="fade-up" data-aos-delay="500">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-500 transition duration-300">
                    <i class="fa-solid fa-keyboard text-2xl text-orange-500 group-hover:text-white transition duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-primary mb-3">اكسسوارات</h3>
                <p class="text-gray-600 leading-relaxed">مجموعة متنوعة من الماوسات، الكيبوردات، السماعات، وشنط اللابتوب.</p>
            </div>

            <!-- Service 6 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2 group border border-gray-100" data-aos="fade-up" data-aos-delay="600">
                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-red-500 transition duration-300">
                    <i class="fa-solid fa-tv text-2xl text-red-500 group-hover:text-white transition duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-primary mb-3">شاشات</h3>
                <p class="text-gray-600 leading-relaxed">شاشات كمبيوتر وتلفزيون بأحجام ودقات مختلفة لتجربة مشاهدة مثالية.</p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-24 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-slate-900/[0.02] bg-[size:20px_20px] pointer-events-none"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-accent font-bold tracking-wider text-sm bg-accent/10 px-4 py-1.5 rounded-full border border-accent/20">لماذا تختار متجرنا؟</span>
            <h2 class="text-3xl md:text-4.5xl font-extrabold text-primary mt-4 mb-4">نحن لا نبيع التكنولوجيا فحسب، بل نبني الثقة</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-accent to-secondary mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white/75 backdrop-blur-md p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-accent/20 hover:-translate-y-1.5 transition duration-300 group" data-aos="fade-up" data-aos-delay="100">
                <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-accent text-accent group-hover:text-primary transition duration-300">
                    <i class="fa-solid fa-truck-fast text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-primary mb-3">شحن سريع ومؤمن</h3>
                <p class="text-slate-500 text-sm leading-relaxed">توصيل لباب المنزل في أسرع وقت مع فحص المنتج قبل الاستلام لضمان راحتك الكاملة.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white/75 backdrop-blur-md p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-accent/20 hover:-translate-y-1.5 transition duration-300 group" data-aos="fade-up" data-aos-delay="200">
                <div class="w-14 h-14 bg-secondary/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-secondary text-secondary group-hover:text-white transition duration-300">
                    <i class="fa-solid fa-shield-halved text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-primary mb-3">ضمان حقيقي 100%</h3>
                <p class="text-slate-500 text-sm leading-relaxed">جميع أجهزتنا تأتي بضمان رسمي معتمد، نوفر لك الأمان التام الذي تبحث عنه.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white/75 backdrop-blur-md p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-accent/20 hover:-translate-y-1.5 transition duration-300 group" data-aos="fade-up" data-aos-delay="300">
                <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 text-indigo-600 group-hover:text-white transition duration-300">
                    <i class="fa-solid fa-headset text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-primary mb-3">دعم فني متكامل</h3>
                <p class="text-slate-500 text-sm leading-relaxed">فريق دعم خبير ومستعد للإجابة على جميع استفساراتك ومساعدتك في اختيار جهازك المثالي.</p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-white/75 backdrop-blur-md p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-accent/20 hover:-translate-y-1.5 transition duration-300 group" data-aos="fade-up" data-aos-delay="400">
                <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-emerald-500 text-emerald-500 group-hover:text-white transition duration-300">
                    <i class="fa-solid fa-screwdriver-wrench text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-primary mb-3">مركز صيانة احترافي</h3>
                <p class="text-slate-500 text-sm leading-relaxed">نقدم خدمات ما بعد البيع من صيانة وتحديث لأجهزتك بأيدي مهندسين متخصصين.</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-24 bg-white relative">
    <div class="container mx-auto px-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-16 gap-4">
            <div>
                <span class="text-secondary font-bold tracking-wider text-sm uppercase">أحدث الإضافات</span>
                <h2 class="text-3xl sm:text-4.5xl font-extrabold text-primary mt-2">وصل حديثاً للمتجر</h2>
                <div class="w-16 h-1.5 bg-gradient-to-r from-accent to-secondary rounded-full mt-3"></div>
            </div>
            <a href="store.php" class="bg-slate-50 hover:bg-slate-100 border border-slate-200 text-primary font-bold py-3 px-6 rounded-xl flex items-center gap-3 transition duration-300 group">
                تصفح المتجر بالكامل 
                <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1.5"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            // Fetch newest 4 products
            $products_list = [];
            if (isset($db_fallback) && $db_fallback) {
                // Use fallback mock data
                $products_list = array_slice($mock_products, 0, 4);
            } else {
                $db_res = $conn->query("SELECT * FROM `products` ORDER BY id DESC LIMIT 4");
                if ($db_res) {
                    while ($row = $db_res->fetch_assoc()) {
                        $products_list[] = $row;
                    }
                }
                if (empty($products_list)) {
                    $products_list = array_slice($mock_products, 0, 4);
                }
            }

            foreach ($products_list as $product) {
                $price = number_format($product['price']);
                $category = htmlspecialchars($product['category']);
                $name = htmlspecialchars($product['name']);
                $description = htmlspecialchars($product['description'] ?? $product['desc'] ?? '');
                $image = htmlspecialchars($product['image'] ?? 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60');
                ?>
                <!-- Product Card -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-2xl transition duration-500 border border-slate-100 overflow-hidden group" data-aos="zoom-in">
                    <div class="relative h-56 bg-slate-50 overflow-hidden">
                        <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center pb-6">
                            <a href="product.php?id=<?php echo $product['id']; ?>" class="bg-accent hover:bg-cyan-400 text-primary font-bold py-2.5 px-6 rounded-xl transition duration-300 text-sm shadow-lg shadow-accent/20">
                                عرض التفاصيل
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-xs font-bold text-slate-400"><?php echo $category; ?></span>
                            <div class="flex text-amber-400 text-xs gap-0.5">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                        </div>
                        <h3 class="font-extrabold text-lg text-primary mb-2 truncate group-hover:text-accent transition duration-300"><?php echo $name; ?></h3>
                        <p class="text-xs text-slate-400 mb-4 leading-relaxed line-clamp-2"><?php echo $description; ?></p>
                        <div class="flex justify-between items-center border-t border-slate-50 pt-4">
                            <span class="text-accent font-black text-lg"><?php echo $price; ?> ج.م</span>
                            <button onclick="openCheckoutModal('<?php echo $name; ?>', <?php echo $product['price']; ?>)" class="w-10 h-10 rounded-xl bg-slate-50 hover:bg-accent text-slate-600 hover:text-primary flex items-center justify-center transition duration-300 shadow-inner">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>



<!-- Checkout Modal -->
<div id="checkoutModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/75 backdrop-blur-sm opacity-0 pointer-events-none transition duration-300">
    <div class="bg-white border border-gray-100 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl transform scale-95 transition duration-300">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-black text-lg text-primary">إتمام الشراء</h3>
            <button onclick="closeCheckoutModal()" class="text-gray-400 hover:text-red-500 text-lg focus:outline-none transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
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
                <textarea id="checkoutAddress" rows="2" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-primary text-sm focus:border-secondary outline-none transition" placeholder="المحافظة، المدينة، الشارع..."></textarea>
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
            alert(data.message);
            closeCheckoutModal();
            document.getElementById('checkoutForm').reset();
        } else {
            alert(data.message || 'حدث خطأ، يرجى المحاولة مرة أخرى.');
        }
    } catch (e) {
        alert('حدث خطأ في الاتصال بالخادم.');
    }
    btn.innerText = origText;
    btn.disabled = false;
}
</script>






<?php include 'includes/footer.php'; ?>