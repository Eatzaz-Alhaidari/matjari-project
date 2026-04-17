<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'متجر صخر الإلكتروني') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/brand/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #ffffff;
            color: #334155; /* Neutral gray */
            overflow-x: hidden;
        }

        /* Identity */
        .text-brand-blue { color: #015C92; } /* Primary */
        .text-brand-orange { color: #FFA931; } /* Accent */
        .bg-brand-blue { background-color: #015C92; }
        .bg-brand-orange { background-color: #FFA931; }
        
        .text-main-dark { color: #0f172a; } /* Dark navy/black for headings */

        .nav-link {
            color: #64748b;
            font-weight: 700;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }
        .nav-link:hover { color: #015C92; }

        /* Minimal Phone UI (Not empty, but very clean) */
        .css-phone {
            width: 200px;
            height: 380px;
            background: #ffffff;
            border: 8px solid #f1f5f9;
            border-radius: 36px;
            position: relative;
            margin: 0 auto;
            border-bottom: 0;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            overflow: hidden;
        }
        .css-phone::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 45%;
            height: 20px;
            background: #f1f5f9;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            z-index: 10;
        }
        .phone-header {
            height: 55px;
            background: #fafafa;
            border-bottom: 1px solid #f1f5f9;
        }
        .phone-content {
            padding: 12px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .phone-box {
            height: 55px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #f1f5f9;
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>

<body class="antialiased" x-data="{ mobileMenu: false }">

    <!-- Header -->
    <header class="w-full bg-white py-3 px-6 lg:px-12 fixed top-0 z-50 border-b border-gray-100">
        <div class="max-w-[1400px] mx-auto flex items-center justify-between h-14">
            <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer" onclick="window.scrollTo(0,0)">
                <x-application-logo class="h-10 w-auto object-contain" />
            </div>

            <nav class="hidden lg:flex items-center gap-8">
                <a href="#hero" class="nav-link !text-brand-blue font-extrabold">الرئيسية</a>
                <a href="#services" class="nav-link">المميزات</a>
                <a href="#how" class="nav-link">كيف يعمل</a>
                <a href="#faq" class="nav-link">الأسئلة الشائعة</a>
            </nav>

            <div class="hidden lg:flex items-center gap-3">
                @auth
                    @if(auth()->user()->hasRole('vendor'))
                        <a href="{{ url('/vendor/dashboard') }}" class="px-6 py-2.5 text-sm font-bold bg-brand-blue text-white rounded-full transition-colors hover:bg-[#014a75]">لوحة التاجر</a>
                    @else
                        <a href="{{ url('/admin/dashboard') }}" class="px-6 py-2.5 text-sm font-bold bg-brand-blue text-white rounded-full transition-colors hover:bg-[#014a75]">لوحة الإدارة</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 text-sm font-bold text-gray-500 hover:text-red-500 rounded-full transition-colors bg-gray-50 border border-gray-100">خروج</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2.5 text-sm font-bold bg-gray-50 text-main-dark border border-gray-200 rounded-full transition-colors hover:bg-gray-100">تسجيل الدخول</a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 text-sm font-bold bg-brand-blue text-white rounded-full transition-colors hover:bg-[#014a75]">إنشاء حساب</a>
                @endauth
            </div>

            <button class="lg:hidden text-gray-600" @click="mobileMenu = !mobileMenu">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>

        <div x-show="mobileMenu" x-cloak class="lg:hidden absolute top-full left-0 w-full bg-white border-b border-gray-100 py-4 shadow-lg flex flex-col gap-4 px-6">
            <a href="#hero" @click="mobileMenu = false" class="font-bold text-brand-blue">الرئيسية</a>
            <a href="#services" @click="mobileMenu = false" class="font-bold text-gray-600">المميزات</a>
            <a href="#how" @click="mobileMenu = false" class="font-bold text-gray-600">كيف يعمل</a>
            <a href="#faq" @click="mobileMenu = false" class="font-bold text-gray-600">الأسئلة الشائعة</a>
            <div class="h-px bg-gray-100 my-2"></div>
            @auth
                <a href="{{ url('/dashboard') }}" class="font-bold text-brand-blue">لوحة التحكم</a>
            @else
                <a href="{{ route('login') }}" class="font-bold text-brand-blue">تسجيل الدخول</a>
            @endauth
        </div>
    </header>

    <main class="pt-[80px]">
        
        <!-- Hero Section (Dark Slate text, Orange accent) -->
        <section id="hero" class="bg-white py-20 lg:py-28 flex flex-col items-center justify-center text-center px-6">
            <h1 class="text-4xl lg:text-6xl font-black text-brand-blue leading-[1.3] mb-4">
                تجارتك الإلكترونية بكل أمان وسهولة مع
                <br>
                <span class="text-brand-orange mt-2 block">متجر صخر</span>
            </h1>
            
            <p class="text-[17px] lg:text-lg text-gray-500 max-w-2xl mx-auto mt-4 mb-10 font-medium leading-relaxed">
                متجر صخر هو بوابتك الموثوقة للوصول إلى أفضل المنتجات وإدارة مبيعاتك بكل احترافية. ابدأ متجرك الآن مع أحدث التقنيات وأفضل الخدمات.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full">
                <!-- App Buttons exactly as requested (dark, compact) -->
                <a href="#" class="flex items-center justify-center gap-4 bg-[#111827] hover:bg-black text-white rounded-[1rem] px-6 py-3 min-w-[190px] transition-colors">
                    <div class="text-right">
                        <div class="text-[10px] text-gray-300 font-medium font-sans">تحميل من</div>
                        <div class="text-[1.1rem] font-bold font-sans">Google Play</div>
                    </div>
                    <i class="fa-brands fa-google-play text-[1.6rem] text-brand-orange"></i>
                </a>

                <a href="#" class="flex items-center justify-center gap-4 bg-[#111827] hover:bg-black text-white rounded-[1rem] px-6 py-3 min-w-[190px] transition-colors">
                    <div class="text-right">
                        <div class="text-[10px] text-gray-300 font-medium font-sans">تحميل من</div>
                        <div class="text-[1.1rem] font-bold font-sans">App Store</div>
                    </div>
                    <i class="fa-brands fa-apple text-[1.8rem] text-white"></i>
                </a>
            </div>
        </section>

        <!-- Services Section (Primary Blue block) -->
        <section id="services" class="px-4 lg:px-12 pb-20">
            <div class="bg-brand-blue rounded-[2rem] lg:rounded-[3rem] px-6 lg:px-16 py-20 text-center w-full max-w-[1400px] mx-auto">
                <h2 class="text-3xl lg:text-[2.8rem] font-bold text-white mb-6">لماذا تختار منصة صخر؟</h2>
                <p class="text-blue-100 text-lg max-w-3xl mx-auto mb-16 font-medium leading-relaxed">
                    نقدم تجربة رقمية شاملة تجمع بين الكفاءة وسهولة الاستخدام لضمان حصولك على أفضل الأدوات لإدارة تجارتك.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-[1.5rem] p-10 flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full bg-[#f8fafc] border border-gray-100 flex items-center justify-center text-brand-blue mb-6">
                            <i class="fa-solid fa-chart-line text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-main-dark mb-4">تحليل ذكي</h3>
                        <p class="text-gray-500 font-medium leading-relaxed text-sm">
                            ذكاء اصطناعي يحلل مبيعاتك ونمو متجرك بدقة ويقترح لك أفضل الاستراتيجيات لزيادة أرباحك.
                        </p>
                    </div>

                    <div class="bg-white rounded-[1.5rem] p-10 flex flex-col items-center">
                        <!-- Orange as a subtle touch here -->
                        <div class="w-16 h-16 rounded-full bg-[#fffaf0] border border-orange-50 flex items-center justify-center text-brand-orange mb-6">
                            <i class="fa-solid fa-bolt text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-main-dark mb-4">حجز سهل وسريع</h3>
                        <p class="text-gray-500 font-medium leading-relaxed text-sm">
                            واجهة بسيطة تتيح لك إدراج منتجاتك وتلقي طلباتك في دقائق معدودة، بدون أية تعقيدات.
                        </p>
                    </div>

                    <div class="bg-white rounded-[1.5rem] p-10 flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full bg-[#f8fafc] border border-gray-100 flex items-center justify-center text-brand-blue mb-6">
                            <i class="fa-solid fa-shield-halved text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-main-dark mb-4">متاجر موثوقة</h3>
                        <p class="text-gray-500 font-medium leading-relaxed text-sm">
                            نخبة من المتاجر والمتاجر المعتمدة بجميع التخصصات تحت سقف واحد لضمان موثوقية عالية.
                        </p>
                    </div>
                </div>
            </div>
        </section>


        <!-- How It Works Section (White background, light gray cards, formatted UI mockups) -->
        <section id="how" class="bg-white py-16 px-4 lg:px-12 text-center pb-0">
            <h2 class="text-3xl lg:text-[2.5rem] font-bold text-main-dark mb-16 flex items-center justify-center gap-3">
                كيف يعمل النظام؟ <span class="text-brand-orange text-3xl">✨</span> 
            </h2>

            <div class="max-w-[1200px] mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="bg-[#f8fafc] rounded-[2rem] rounded-b-none pt-12 px-6 flex flex-col items-center h-[460px] border border-[#f1f5f9]">
                    <!-- Pill number -->
                    <div class="px-6 py-2 bg-[#e0eff8] text-brand-blue rounded-full font-bold text-lg mb-8">1</div>
                    <h3 class="text-xl font-bold text-main-dark mb-3">إنشاء حساب بائع</h3>
                    <p class="text-gray-500 text-[13px] leading-relaxed px-4 mb-auto max-w-[260px]">
                        قم بإنشاء حسابك وإعداد ملفك التجاري وجهز متجرك لاستقبال العملاء الجدد بكل سهولة.
                    </p>
                    
                    <!-- Clean formatted UI mockup (not totally empty) -->
                    <div class="css-phone mt-8">
                        <div class="phone-header flex items-center justify-center text-[10px] font-bold text-gray-400">ملف المتجر</div>
                        <div class="phone-content text-center">
                             <div class="w-16 h-16 rounded-full bg-[#e0eff8] mx-auto my-1 flex items-center justify-center">
                                 <i class="fa-regular fa-image text-brand-blue/30 text-2xl"></i>
                             </div>
                             <div class="phone-box w-full mb-1 flex flex-col justify-center px-4">
                                 <div class="h-2 w-1/3 bg-gray-200 rounded mb-2"></div>
                                 <div class="h-1.5 w-1/2 bg-gray-100 rounded"></div>
                             </div>
                             <div class="phone-box w-full flex flex-col justify-center px-4">
                                 <div class="h-2 w-2/3 bg-gray-200 rounded mb-2"></div>
                                 <div class="h-1.5 w-full bg-gray-100 rounded"></div>
                             </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[#f8fafc] rounded-[2rem] rounded-b-none pt-12 px-6 flex flex-col items-center h-[460px] border border-[#f1f5f9]">
                    <!-- Orange accent as touch -->
                    <div class="px-6 py-2 bg-[#fffaf0] text-brand-orange rounded-full font-bold text-lg mb-8">2</div>
                    <h3 class="text-xl font-bold text-main-dark mb-3">إضافة المنتجات بمرونة</h3>
                    <p class="text-gray-500 text-[13px] leading-relaxed px-4 mb-auto max-w-[260px]">
                        ارفع منتجاتك بالخيارات المتعددة وادفع بمبيعاتك للأمام بأسلوب عرض احترافي وواضح.
                    </p>
                    
                    <div class="css-phone mt-8">
                        <div class="phone-header flex items-center justify-center text-[10px] font-bold text-gray-400">المنتجات</div>
                        <div class="phone-content p-2 grid grid-cols-2 gap-2">
                             <div class="bg-white rounded-lg p-2 h-[80px] shadow-sm flex flex-col border border-gray-100">
                                 <div class="w-full h-8 bg-gray-100 rounded mb-2"></div>
                                 <div class="h-1.5 w-full bg-gray-200 rounded mb-1"></div>
                                 <div class="h-1.5 w-1/2 bg-brand-orange/40 rounded"></div>
                             </div>
                             <div class="bg-white rounded-lg p-2 h-[80px] shadow-sm flex flex-col border border-gray-100">
                                 <div class="w-full h-8 bg-gray-100 rounded mb-2"></div>
                                 <div class="h-1.5 w-full bg-gray-200 rounded mb-1"></div>
                                 <div class="h-1.5 w-1/2 bg-brand-blue/40 rounded"></div>
                             </div>
                             <div class="bg-white rounded-lg p-2 h-[80px] shadow-sm flex flex-col border border-gray-100">
                                 <div class="w-full h-8 bg-gray-100 rounded mb-2"></div>
                                 <div class="h-1.5 w-1/2 bg-gray-200 rounded mb-1"></div>
                             </div>
                             <div class="bg-white rounded-lg p-2 h-[80px] shadow-sm flex flex-col border border-gray-100">
                                 <div class="w-full h-8 bg-gray-100 rounded mb-2"></div>
                                 <div class="h-1.5 w-1/2 bg-gray-200 rounded mb-1"></div>
                             </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[#f8fafc] rounded-[2rem] rounded-b-none pt-12 px-6 flex flex-col items-center h-[460px] border border-[#f1f5f9]">
                    <div class="px-6 py-2 bg-[#e0eff8] text-brand-blue rounded-full font-bold text-lg mb-8">3</div>
                    <h3 class="text-xl font-bold text-main-dark mb-3">تلبية الطلبات بسلاسة</h3>
                    <p class="text-gray-500 text-[13px] leading-relaxed px-4 mb-auto max-w-[260px]">
                        תلقى إشعارات الطلبات وحدّث حالات الشحن لحظياً لتبقي عملائك على علم بكل التطورات.
                    </p>
                    
                    <div class="css-phone mt-8">
                        <div class="phone-header flex items-center justify-between px-4 text-[10px] font-bold text-gray-400">
                            <i class="fa-solid fa-arrow-right"></i>
                            إدارة الطلبات
                        </div>
                        <div class="phone-content text-right pt-4">
                             <!-- Formatted UI lists -->
                             <div class="flex gap-3 mb-4 items-center bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                                 <div class="w-10 h-10 rounded-full bg-[#fffaf0] border border-orange-50 flex items-center justify-center flex-shrink-0">
                                     <i class="fa-solid fa-box text-brand-orange text-sm"></i>
                                 </div>
                                 <div class="flex-1">
                                     <div class="h-2 w-1/2 bg-gray-300 rounded mb-2"></div>
                                     <div class="h-1.5 w-1/3 bg-gray-200 rounded"></div>
                                 </div>
                             </div>
                             <div class="flex gap-3 items-center bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                                 <div class="w-10 h-10 rounded-full bg-[#f8fafc] border border-gray-100 flex items-center justify-center flex-shrink-0">
                                     <i class="fa-solid fa-box text-gray-400 text-sm"></i>
                                 </div>
                                 <div class="flex-1">
                                     <div class="h-2 w-1/2 bg-gray-300 rounded mb-2"></div>
                                     <div class="h-1.5 w-1/3 bg-gray-200 rounded"></div>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <!-- FAQ Section -->
        <section id="faq" class="bg-white py-24 px-4 lg:px-12 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-main-dark mb-12">الأسئلة الشائعة</h2>

            <div class="max-w-3xl mx-auto flex flex-col gap-3">
                <div x-data="{ open: false }" class="bg-[#f8fafc] rounded-2xl cursor-pointer" @click="open = !open">
                    <div class="px-6 py-4 flex justify-between items-center text-[17px] font-bold text-main-dark">
                        <span>كيف يمكنني البدء في البيع على المنصة؟</span>
                        <i class="fa-solid fa-chevron-down text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </div>
                    <div x-show="open" x-collapse x-cloak>
                        <div class="px-6 pb-4 text-gray-500 text-right leading-relaxed font-medium text-[14px]">
                            ببساطة، انقر على زر إنشاء حساب في أعلى الصفحة، وقم باختيار تسجيل بائع. ستقوم بإدخال تفاصيل متجرك مثل الاسم التجاري وسيتم تفعيل حسابك للبدء بكل سهولة.
                        </div>
                    </div>
                </div>

                <div x-data="{ open: false }" class="bg-[#f8fafc] rounded-2xl cursor-pointer" @click="open = !open">
                    <div class="px-6 py-4 flex justify-between items-center text-[17px] font-bold text-main-dark">
                        <span>هل بياناتي البنكية آمنة؟</span>
                        <i class="fa-solid fa-chevron-down text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </div>
                </div>
                
                <div x-data="{ open: false }" class="bg-[#f8fafc] rounded-2xl cursor-pointer" @click="open = !open">
                    <div class="px-6 py-4 flex justify-between items-center text-[17px] font-bold text-main-dark">
                        <span>ما هي تكلفة فتح متجر عبر المنصة؟</span>
                        <i class="fa-solid fa-chevron-down text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="bg-white py-10 border-t border-gray-100 text-center">
        <x-application-logo class="h-10 w-auto mx-auto mb-4 grayscale opacity-40 hover:grayscale-0 hover:opacity-100 transition-colors" />
        <p class="text-gray-400 font-medium text-sm">&copy; {{ date('Y') }} حقوق الطبع والنشر محفوظة لمتجر صخر الإلكتروني.</p>
    </footer>

</body>
</html>