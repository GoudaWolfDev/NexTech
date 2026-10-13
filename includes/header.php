<?php 
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// تحقق من صلاحية الأدمن بناءً على السيشن الفعلي في نظامك
$isAdmin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == 1;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="MbRqY-uSEni-fQMFEFYPpfpTWqreDpf6eTb0cxM3Ozc" />
    <title>NexTech - Premium Tech Store | Developed by Gouda Nasralla</title>
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0B0F19',
                        secondary: '#4F46E5',
                        accent: '#06B6D4',
                    },
                    fontFamily: {
                        sans: ['Cairo', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col">

    <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200 shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-20">

                <!-- Logo -->
                <a href="index.php" class="flex items-center gap-2.5 group shrink-0">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-secondary to-indigo-800 flex items-center justify-center shadow-md shadow-secondary/20 group-hover:scale-105 transition duration-300">
                        <i class="fa-solid fa-laptop-code text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-black tracking-tight text-primary">Nex<span class="text-secondary">Tech</span></span>
                </a>

                <!-- Desktop Links -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="index.php" class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-slate-600 hover:text-secondary hover:bg-slate-50 font-semibold text-sm transition duration-300">
                        <i class="fa-solid fa-house text-xs opacity-60"></i> الرئيسية
                    </a>
                    <a href="store.php" class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-slate-600 hover:text-secondary hover:bg-slate-50 font-semibold text-sm transition duration-300">
                        <i class="fa-solid fa-store text-xs opacity-60"></i> المتجر
                    </a>
                    <a href="index.php#services" class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-slate-600 hover:text-secondary hover:bg-slate-50 font-semibold text-sm transition duration-300">
                        <i class="fa-solid fa-gears text-xs opacity-60"></i> خدماتنا
                    </a>
                    <a href="index.php#contact" class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-slate-600 hover:text-secondary hover:bg-slate-50 font-semibold text-sm transition duration-300">
                        <i class="fa-solid fa-envelope text-xs opacity-60"></i> اتصل بنا
                    </a>
                </div>

                <!-- Right side: Dashboard (desktop) + Mobile toggle -->
                <div class="flex items-center gap-3">
                    <?php if ($isAdmin): ?>
                    <a href="dashboard.php" class="hidden md:flex items-center gap-2 px-5 py-2.5 bg-secondary text-white rounded-xl shadow-md shadow-secondary/25 hover:bg-indigo-700 hover:-translate-y-0.5 transition duration-300 font-bold text-sm">
                        <i class="fa-solid fa-chart-pie"></i> لوحة التحكم
                    </a>
                    <?php endif; ?>

                    <button id="mobile-menu-button" type="button" aria-expanded="false" aria-controls="mobile-menu" class="md:hidden w-11 h-11 flex items-center justify-center rounded-xl bg-slate-50 border border-slate-200 text-primary focus:outline-none focus:ring-2 focus:ring-secondary/40 transition">
                        <i id="menu-icon" class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-slate-100 shadow-lg" style="display:none;">
            <div class="px-4 py-4 space-y-1.5">
                <a href="index.php" class="flex items-center gap-3 py-3 px-4 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-secondary transition duration-300 font-semibold">
                    <i class="fa-solid fa-house text-lg opacity-70 w-6 text-center"></i> الرئيسية
                </a>
                <a href="store.php" class="flex items-center gap-3 py-3 px-4 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-secondary transition duration-300 font-semibold">
                    <i class="fa-solid fa-store text-lg opacity-70 w-6 text-center"></i> المتجر
                </a>
                <a href="index.php#services" class="flex items-center gap-3 py-3 px-4 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-secondary transition duration-300 font-semibold">
                    <i class="fa-solid fa-gears text-lg opacity-70 w-6 text-center"></i> خدماتنا
                </a>
                <a href="index.php#contact" class="flex items-center gap-3 py-3 px-4 rounded-xl text-slate-700 hover:bg-slate-50 hover:text-secondary transition duration-300 font-semibold">
                    <i class="fa-solid fa-envelope text-lg opacity-70 w-6 text-center"></i> اتصل بنا
                </a>

                <?php if ($isAdmin): ?>
                <div class="pt-3 mt-2 border-t border-slate-100">
                    <a href="dashboard.php" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-secondary text-white rounded-xl shadow-md shadow-secondary/20 hover:bg-indigo-700 transition duration-300 font-bold">
                        <i class="fa-solid fa-chart-pie"></i> لوحة التحكم
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <script>
    (function () {
        function initMobileMenu() {
            const menuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');

            if (!menuButton || !mobileMenu || !menuIcon) {
                console.error('Mobile menu elements not found:', { menuButton, mobileMenu, menuIcon });
                return;
            }

            if (menuButton.dataset.bound === 'true') return;
            menuButton.dataset.bound = 'true';

            let isOpen = false;

            menuButton.addEventListener('click', function () {
                isOpen = !isOpen;

                // نفرض الـ display صراحة عشان نتجاوز أي تعارض CSS خارجي محتمل
                mobileMenu.style.display = isOpen ? 'block' : 'none';
                mobileMenu.classList.toggle('hidden', !isOpen);

                menuButton.setAttribute('aria-expanded', String(isOpen));
                menuIcon.classList.toggle('fa-bars', !isOpen);
                menuIcon.classList.toggle('fa-xmark', isOpen);
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initMobileMenu);
        } else {
            initMobileMenu();
        }
    })();
    </script>