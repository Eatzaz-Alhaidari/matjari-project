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
    <div x-data="{ 
        sidebarOpen: true, 
        activeTab: localStorage.getItem('adminActiveTab') || 'home',
        switchTab(tab) {
            this.activeTab = tab;
            localStorage.setItem('adminActiveTab', tab);
            if (window.location.pathname !== '{{ route('admin.dashboard', [], false) }}') {
                window.location.href = '{{ route('admin.dashboard') }}';
            }
        }
    }" class="flex h-screen bg-slate-100">

        <aside
            class="fixed inset-y-0 right-0 z-30 flex-shrink-0 w-72 overflow-y-auto bg-brand-blue shadow-lg transition-transform duration-300 transform"
            :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'">
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-center mt-8 flex-shrink-0">
                    <div class="flex items-center">
                        <x-application-logo class="w-12 h-12 text-white" />
                        <span class="mx-2 text-2xl font-semibold text-white">لوحة التحكم</span>
                    </div>
                </div>

                <nav class="mt-10 flex-grow px-4 space-y-2">
                    <!-- الرئيسية -->
                    <button @click="switchTab('home')"
                        class="flex items-center w-full px-4 py-3 text-white rounded-xl transition-all duration-200 group"
                        :class="activeTab === 'home' ? 'bg-white/20 shadow-inner' : 'hover:bg-white/10'">
                        <span class="text-xl">🏠</span>
                        <span class="mx-3 font-bold text-lg text-right w-full">الرئيسية</span>
                    </button>

                    <div class="my-4 border-t border-white/10"></div>

                    <!-- إدارة العمليات -->
                    <button @click="switchTab('operations')"
                        class="flex items-center w-full px-4 py-3 text-gray-200 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'operations' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <span class="text-xl">🛒</span>
                        <span class="mx-3 font-semibold w-full text-right">إدارة العمليات</span>
                    </button>

                    <!-- إدارة المحتوى التجاري -->
                    <button @click="switchTab('content')"
                        class="flex items-center w-full px-4 py-3 text-gray-200 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'content' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <span class="text-xl">📦</span>
                        <span class="mx-3 font-semibold w-full text-right">إدارة المحتوى التجاري</span>
                    </button>

                    <!-- إدارة الأطراف -->
                    <button @click="switchTab('parties')"
                        class="flex items-center w-full px-4 py-3 text-gray-200 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'parties' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <span class="text-xl">🏪</span>
                        <span class="mx-3 font-semibold w-full text-right">إدارة الأطراف</span>
                    </button>

                    <!-- التحليل والتقارير -->
                    <button @click="switchTab('reports')"
                        class="flex items-center w-full px-4 py-3 text-gray-200 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'reports' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <span class="text-xl">📊</span>
                        <span class="mx-3 font-semibold w-full text-right">التحليل والتقارير</span>
                    </button>

                    <!-- الدعم والمتابعة -->
                    <button @click="switchTab('support')"
                        class="flex items-center w-full px-4 py-3 text-gray-200 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'support' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <span class="text-xl">🎧</span>
                        <span class="mx-3 font-semibold w-full text-right">الدعم والمتابعة</span>
                    </button>

                    <!-- النظام والإعدادات -->
                    <button @click="switchTab('settings')"
                        class="flex items-center w-full px-4 py-3 text-gray-200 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'settings' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <span class="text-xl">🔔</span>
                        <span class="mx-3 font-semibold w-full text-right">النظام والإعدادات</span>
                    </button>
                </nav>
            </div>
        </aside>

        <div class="flex flex-col flex-1 w-full transition-all duration-300" :class="{ 'lg:mr-72': sidebarOpen }">
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
                    <div class="flex items-center justify-between">
                        <h3 class="text-3xl font-bold text-brand-blue-800">@yield('title')</h3>
                        @if(!request()->routeIs('admin.dashboard'))
                            <a href="{{ route('admin.dashboard') }}"
                                class="group flex items-center px-4 py-2 bg-white text-gray-600 rounded-full shadow-md hover:shadow-lg hover:bg-brand-blue hover:text-white transition-all duration-300 transform hover:-translate-y-1 ring-1 ring-gray-100 hover:ring-brand-blue-300">
                                <span
                                    class="ml-2 font-bold text-sm opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all duration-300 w-0 group-hover:w-auto overflow-hidden whitespace-nowrap">عودة
                                    للرئيسية</span>
                                <div class="bg-gray-100 p-1.5 rounded-full group-hover:bg-white/20 transition-colors">
                                    <svg class="w-5 h-5 rtl:rotate-180 transition-transform duration-300 group-hover:-translate-x-1"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                </div>
                            </a>
                        @endif
                    </div>
                    <div class="mt-4">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>