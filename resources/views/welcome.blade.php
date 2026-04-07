<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>متجر صخر الإلكتروني</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/brand/favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">

    <!-- Scripts & Styles (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .hero-gradient {
            background: linear-gradient(135deg, #E6F0F5 0%, #ffffff 100%);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
        }

        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>

<body class="antialiased font-sans bg-gray-50 text-gray-800" x-data="{ scrolled: false }"
    @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300 top-0 bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-8 sm:px-12 lg:px-16">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center">
                    <x-application-logo class="h-12 w-auto object-contain" />
                </div>

                <div class="hidden md:flex items-center space-x-6 space-x-reverse">
                    @auth
                        <div class="flex items-center space-x-4 space-x-reverse">
                            <span class="text-gray-600 font-medium">مرحباً، {{ Auth::user()->name }}</span>
                            @if(auth()->user()->hasRole('super-admin'))
                                <a href="{{ url('/admin/dashboard') }}"
                                    class="px-4 py-2 rounded-full bg-brand-blue-600 text-white hover:bg-brand-blue-700 transition shadow-md text-sm font-bold">لوحة
                                    التحكم</a>
                            @elseif(auth()->user()->hasRole('vendor'))
                                <a href="{{ url('/vendor/dashboard') }}"
                                    class="px-4 py-2 rounded-full bg-brand-blue-600 text-white hover:bg-brand-blue-700 transition shadow-md text-sm font-bold">لوحة
                                    البائع</a>
                            @endif
                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="text-sm text-red-500 hover:text-red-700 font-semibold transition">تسجيل
                                    خروج</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="flex items-center py-2.5 px-6 rounded-full bg-brand-blue-600 text-white hover:bg-brand-blue-700 transition shadow-md shadow-brand-blue-500/20 font-semibold text-sm tracking-wide">تسجيل
                            الدخول</a>

                    @endauth
                </div>

                <!-- Mobile menu button (Simplified) -->
                <div class="md:hidden flex items-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-brand-blue-600 font-bold">لوحة التحكم</a>
                    @else
                        <a href="{{ route('login') }}" class="text-brand-blue-600 font-bold">دخول</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-40 lg:pb-32 overflow-hidden hero-gradient flex flex-col items-center justify-center min-h-[60vh] text-center">
        <!-- Floating Shapes for Aesthetics -->
        <div
            class="absolute top-20 left-10 w-72 h-72 bg-brand-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob">
        </div>
        <div
            class="absolute top-40 right-10 w-72 h-72 bg-brand-orange-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 left-1/2 w-72 h-72 bg-brand-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10">
            <h1 class="font-black text-brand-blue-900 mb-8 max-w-5xl mx-auto flex flex-col gap-4 sm:gap-8">
                <span class="text-4xl sm:text-5xl md:text-6xl leading-normal block">
                    اكتشف أحدث <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-blue-600 to-brand-green-600">الأجهزة الإلكترونية</span>
                </span>
                <span class="text-4xl sm:text-5xl md:text-6xl leading-normal block mt-2">
                    بأفضل الأسعار
                </span>
            </h1>
            <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                أحدث المنتجات، أفضل الماركات، وتجربة شراء لا تُنسى. ابدأ رحلتك معنا اليوم واستمتع بالعروض الحصرية.
            </p>

            <div class="mb-10"></div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-20 bg-white relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-brand-blue-900 sm:text-4xl">لماذا تختار متجر صخر؟</h2>
                <p class="mt-4 text-gray-500 text-lg">نقدم لك تجربة متكاملة تجمع بين الجودة والراحة.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Feature 1 -->
                <div
                    class="feature-card bg-brand-blue-50 p-8 rounded-3xl transition-all duration-300 border border-brand-blue-100 flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 bg-brand-blue-100 text-brand-blue-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-brand-blue-900 mb-2">أسعار تنافسية</h3>
                    <p class="text-gray-600 leading-relaxed">نضمن لك الحصول على أفضل الأسعار في السوق مع عروض يومية
                        متجددة.</p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="feature-card bg-brand-orange-50 p-8 rounded-3xl transition-all duration-300 border border-brand-orange-100 flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 bg-brand-orange-100 text-brand-orange-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-brand-blue-900 mb-2">شحن فائق السرعة</h3>
                    <p class="text-gray-600 leading-relaxed">اطلب الآن واستلم منتجاتك في وقت قياسي بفضل شبكة التوصيل
                        المتطورة لدينا.</p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="feature-card bg-brand-green-50 p-8 rounded-3xl transition-all duration-300 border border-brand-green-100 flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 bg-brand-green-100 text-brand-green-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-brand-blue-900 mb-2">دفع آمن 100%</h3>
                    <p class="text-gray-600 leading-relaxed">تسوق براحة بال مع خيارات دفع متعددة ونظام حماية متكامل
                        لبياناتك.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-16 bg-brand-blue-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
        </div>
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl font-bold text-white mb-6">عزيزي التاجر، هل أنت جاهز لتنمية عملك؟</h2>
            <p class="text-brand-blue-100 mb-8 text-lg">انضم إلى منصة قوية تساعدك على إدارة متجرك وزيادة مبيعاتك بسهولة.</p>
            <a href="{{ route('register') }}"
                class="inline-block px-10 py-4 bg-brand-orange-500 hover:bg-brand-orange-600 text-white font-bold rounded-full shadow-lg transform hover:-translate-y-1 transition duration-200">
                ابدأ متجرك الآن
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 py-12">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0 flex items-center">
                <x-application-logo class="h-8 w-auto text-gray-400 grayscale opacity-70" />
                <span class="mr-2 text-gray-500 font-semibold">جميع الحقوق محفوظة &copy; {{ date('Y') }}</span>
            </div>
            <div class="flex space-x-6 space-x-reverse text-gray-400">
                <a href="#" class="hover:text-brand-blue-600 transition"><span class="sr-only">Facebook</span>FB</a>
                <a href="#" class="hover:text-brand-blue-600 transition"><span class="sr-only">Twitter</span>TW</a>
                <a href="#" class="hover:text-brand-blue-600 transition"><span class="sr-only">Instagram</span>IG</a>
            </div>
        </div>
    </footer>

</body>

</html>