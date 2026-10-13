<footer class="bg-gray-50 text-gray-600 border-t border-gray-200 py-12 mt-auto">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-laptop-code text-indigo-600"></i>
                        NexTech
                    </h3>
                    <p class="text-sm leading-relaxed text-gray-500">
                        وجهتك الأولى لأحدث أجهزة اللابتوب، كاميرات المراقبة، وأنظمة الأمان. نقدم أفضل المنتجات بأسعار تنافسية وخدمة صيانة متميزة.
                    </p>
                </div>

                <div class="flex flex-col md:items-end">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">تواصل معنا</h3>
                    <ul class="space-y-3 text-sm md:text-left">
                        <li class="flex items-center gap-3 justify-start md:justify-end">
                            <span>القاهرة، مصر - شارع التكنولوجيا</span>
                            <i class="fa-solid fa-location-dot text-indigo-600 w-5 text-center order-first md:order-last"></i>
                        </li>
                        <li class="flex items-center gap-3 justify-start md:justify-end">
                            <span dir="ltr" class="hover:text-indigo-600 transition duration-300">+20 10 0000 0000</span>
                            <i class="fa-solid fa-phone text-indigo-600 w-5 text-center order-first md:order-last"></i>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-200 mt-10 pt-6 text-sm flex flex-col md:flex-row justify-between items-center gap-4 text-gray-400">
                <p>&copy; 2026 NexTech. جميع الحقوق محفوظة.</p>
                <p>تم التطوير بكل حب بواسطة <a href="https://github.com/GoudaWolfDev" target="_blank" class="text-indigo-600 hover:underline font-semibold transition duration-300"><i class="fa-solid fa-code text-xs"></i> جودة نصر الله (GoudaWolfDev)</a></p>
            </div>
        </div>
    </footer>

    <a id="whatsapp-btn" 
       href="#" 
       target="_blank" 
       class="fixed bottom-6 left-6 z-50 bg-[#25D366] text-white w-14 h-14 rounded-full flex items-center justify-center shadow-xl hover:bg-[#20ba5a] hover:scale-110 active:scale-95 transition-all duration-300 group"
       title="تواصل معنا عبر واتساب">
        <i class="fa-brands fa-whatsapp text-3xl animate-bounce group-hover:animate-none"></i>
        <span class="absolute inset-0 rounded-full bg-[#25D366] opacity-40 -z-10 animate-ping"></span>
    </a>

    <script src="assets/js/main.js"></script>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // توليد رابط الواتساب بنص عربي واضح تماماً ومقروء داخل الكود
        const phoneNumber = "201000000000";
        const message = "مرحباً NexTech، أود الاستفسار عن أحد الأجهزة أو الصيانة";
        
        document.getElementById("whatsapp-btn").href = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    </script>
</body>
</html>