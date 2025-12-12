<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> body { font-family: 'Cairo', sans-serif; } </style>
</head>
<body class="font-sans antialiased bg-slate-100">
    <div x-data="{ sidebarOpen: true }" class="flex h-screen bg-slate-100">
        
        <aside 
            class="fixed inset-y-0 right-0 z-30 flex-shrink-0 w-64 overflow-y-auto bg-brand-orange shadow-lg transition-transform duration-300 transform"
            :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'"
        >
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-center mt-8 flex-shrink-0">
                    <div class="flex items-center">
                        <x-application-logo class="w-12 h-12 text-white"/>
                        <span class="mx-2 text-2xl font-semibold text-white">متجري</span>
                    </div>
                </div>
                
                <nav class="mt-10 flex-grow px-2">
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white" href="{{ route('vendor.dashboard') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        <span class="mx-3 font-semibold">الرئيسية</span>
                    </a>
                    
                    <hr class="my-4 border-white">

                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white" href="#">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        <span class="mx-3 font-semibold">إدارة المنتجات</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white  rounded-lg hover:bg-white/10 hover:text-white" href="#">
                         <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                        <span class="mx-3 font-semibold">إدارة الطلبات</span>
                    </a>
                     <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white" href="#">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m0 10l8 4m-8-4v--8 4-8-4" /></svg>
                        <span class="mx-3 font-semibold">إدارة المخازن</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white" href="#">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.834 9.168-4.432" /></svg>
                        <span class="mx-3 font-semibold">إدارة الإعلانات</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white" href="#">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
                        <span class="mx-3 font-semibold">إدارة الخصومات</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white" href="#">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        <span class="mx-3 font-semibold">إدارة المبيعات</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white" href="#">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                        <span class="mx-3 font-semibold">التقييمات</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white" href="#">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        <span class="mx-3 font-semibold">المنتجات الأكثر طلباً</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white" href="#">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                        <span class="mx-3 font-semibold">التقارير المالية</span>
                    </a>
                    
                    <hr class="my-4 border-white">

                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white" href="#">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <span class="mx-3 font-semibold">إعدادات المتجر</span>
                    </a>
                </nav>
            </div>
        </aside>

        <div class="flex flex-col flex-1 w-full transition-all duration-300" :class="{ 'lg:mr-64': sidebarOpen }">
            <header class="relative z-10 py-4 bg-white shadow-md">
                <div class="container flex items-center justify-between h-full px-6 mx-auto text-brand-orange-500">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-1 rounded-md focus:outline-none">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                    </button>
                    <div class="flex items-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-700 hover:text-brand-orange-700">تسجيل الخروج</a>
                        </form>
                    </div>
                </div>
            </header>
            
            <main class="h-full overflow-y-auto">
                <div class="container px-6 py-8 mx-auto">
                    <h3 class="text-3xl font-bold text-gray-700">@yield('title')</h3>
                    <div class="mt-4">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
