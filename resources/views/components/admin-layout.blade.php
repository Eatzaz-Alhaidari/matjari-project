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

        .bg-mesh {
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 0% 0%, hsla(215, 90%, 70%, 0.07) 0px, transparent 50%),
                radial-gradient(at 100% 0%, hsla(230, 90%, 70%, 0.05) 0px, transparent 50%),
                radial-gradient(at 50% 100%, hsla(215, 90%, 70%, 0.07) 0px, transparent 50%);
        }

        .geometric-shape {
            position: absolute;
            z-index: 0;
            opacity: 0.4;
            pointer-events: none;
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
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="mx-3 font-bold text-lg text-right w-full">الرئيسية</span>
                    </button>

                    <div class="my-4 border-t border-white/10"></div>

                    <!-- إدارة العمليات -->
                    <button @click="switchTab('operations')"
                        class="flex items-center w-full px-4 py-3 text-gray-200 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'operations' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="mx-3 font-semibold w-full text-right">إدارة العمليات</span>
                    </button>

                    <!-- إدارة المحتوى التجاري -->
                    <button @click="switchTab('content')"
                        class="flex items-center w-full px-4 py-3 text-gray-200 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'content' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span class="mx-3 font-semibold w-full text-right">إدارة المحتوى التجاري</span>
                    </button>

                    <!-- إدارة الأطراف -->
                    <button @click="switchTab('parties')"
                        class="flex items-center w-full px-4 py-3 text-gray-200 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'parties' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="mx-3 font-semibold w-full text-right">إدارة الأطراف</span>
                    </button>

                    <!-- التحليل والتقارير -->
                    <button @click="switchTab('reports')"
                        class="flex items-center w-full px-4 py-3 text-gray-200 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'reports' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="mx-3 font-semibold w-full text-right">التحليل والتقارير</span>
                    </button>

                    <!-- الدعم والمتابعة -->
                    <button @click="switchTab('support')"
                        class="flex items-center w-full px-4 py-3 text-gray-200 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'support' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="mx-3 font-semibold w-full text-right">الدعم والمتابعة</span>
                    </button>

                    <!-- النظام والإعدادات -->
                    <button @click="switchTab('settings')"
                        class="flex items-center w-full px-4 py-3 text-gray-200 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'settings' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296-.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
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

            <main class="h-full overflow-y-auto bg-mesh relative">
                <!-- Background Decorative Shapes -->
                <div class="geometric-shape top-20 left-10 w-64 h-64 bg-brand-blue/5 rounded-full blur-3xl"></div>
                <div class="geometric-shape bottom-20 right-10 w-96 h-96 bg-brand-blue/5 rounded-full blur-3xl"></div>

                <div class="container px-6 py-8 mx-auto relative z-10">
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