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
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-100">
    <div x-data="{ sidebarOpen: true }" class="flex h-screen bg-slate-100">

        <aside
            class="fixed inset-y-0 right-0 z-30 flex-shrink-0 w-64 overflow-y-auto bg-brand-blue shadow-lg transition-transform duration-300 transform"
            :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'">
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-center mt-8 flex-shrink-0">
                    <div class="flex items-center">
                        <x-application-logo class="w-12 h-12 text-white" />
                        <span class="mx-2 text-2xl font-semibold text-white">لوحة التحكم</span>
                    </div>
                </div>

                <nav class="mt-10 flex-grow px-2">
                    <a class="flex items-center px-4 py-3 mt-2 text-gray-200 rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('admin.dashboard') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="mx-3 font-semibold">الرئيسية</span>
                    </a>

                    <hr class="my-4 border-gray-600">

                    <a class="flex items-center px-4 py-3 mt-2 text-gray-200 rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('admin.vendors.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="mx-3 font-semibold">إدارة البائعين</span>
                    </a>

                    <a class="flex items-center px-4 py-3 mt-2 text-gray-200 rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('admin.users.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A10.99 10.99 0 0112 10c2.67 0 5.057 1.22 6.75 3.147" />
                        </svg>
                        <span class="mx-3 font-semibold">إدارة العملاء</span>
                    </a>

                    <a class="flex items-center px-4 py-3 mt-2 text-gray-200 rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('admin.stores.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="mx-3 font-semibold">إدارة المتاجر</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-gray-200 rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('admin.products.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="mx-3 font-semibold">إدارة المنتجات</span>
                    </a>

                    <a class="flex items-center px-4 py-3 mt-2 text-gray-200 rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('admin.wallets.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <span class="mx-3 font-semibold">إدارة المحافظ</span>
                    </a>

                    <hr class="my-4 border-gray-600">


                    <a class="flex items-center px-4 py-3 mt-2 text-gray-200 rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('admin.reports.financial') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="mx-3 font-semibold">التقارير المالية</span>
                    </a>

                    <hr class="my-4 border-gray-600">

                    <a class="flex items-center px-4 py-3 mt-2 text-gray-200 rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('admin.reviews.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <span class="mx-3 font-semibold">التقييمات</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-gray-200 rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('admin.notifications.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="mx-3 font-semibold">الإشعارات</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-gray-200 rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('admin.complaints.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                        <span class="mx-3 font-semibold">الشكاوى</span>
                    </a>
                </nav>
            </div>
        </aside>

        <div class="flex flex-col flex-1 w-full transition-all duration-300" :class="{ 'lg:mr-64': sidebarOpen }">
            <header class="relative z-10 py-4 bg-white shadow-md">
                <div class="container flex items-center justify-between h-full px-6 mx-auto text-brand-blue">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="p-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div class="flex items-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-gray-700 hover:text-brand-blue">تسجيل الخروج</a>
                        </form>
                    </div>
                </div>
            </header>

            <main class="h-full overflow-y-auto">
                <div class="container px-6 py-8 mx-auto">
                    <h3 class="text-3xl font-bold text-brand-blue-800">@yield('title')</h3>
                    <div class="mt-4">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>