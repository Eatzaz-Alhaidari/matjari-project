<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'متجر صخر الإلكتروني') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/brand/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/brand/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-100 overflow-hidden">
    <div x-data="{ 
        sidebarOpen: true, 
        activeTab: localStorage.getItem('vendorActiveTab') || 'home',
        switchTab(tab) {
            this.activeTab = tab;
            localStorage.setItem('vendorActiveTab', tab);
            if (window.location.pathname !== '{{ route('vendor.dashboard', [], false) }}') {
                window.location.href = '{{ route('vendor.dashboard') }}';
            }
        }
    }" class="flex h-screen bg-slate-100">

        <aside
            class="fixed inset-y-0 right-0 z-30 flex-shrink-0 w-64 overflow-y-auto bg-brand-orange-700 shadow-lg transition-transform duration-300 transform"
            :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'">
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-center mt-6 mb-2 flex-shrink-0">
                    <div class="flex flex-col items-center">
                        <div class="transition-transform hover:scale-105 duration-300 bg-white/95 px-4 py-2 rounded-2xl shadow-lg ring-4 ring-white/10 mx-4">
                            <x-application-logo class="w-36 h-14 object-contain" />
                        </div>
                    </div>
                </div>

                <nav class="mt-4 flex-grow px-2 space-y-2">
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

                    <div class="my-4 border-t border-white/20"></div>

                    <!-- إدارة العمليات -->
                    <button @click="switchTab('operations')"
                        class="flex items-center w-full px-4 py-3 text-white/90 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'operations' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="mx-3 font-semibold w-full text-right">إدارة العمليات</span>
                    </button>

                    <!-- التسويق والمحتوى -->
                    <button @click="switchTab('content')"
                        class="flex items-center w-full px-4 py-3 text-white/90 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'content' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span class="mx-3 font-semibold w-full text-right">التسويق والمحتوى</span>
                    </button>

                    <!-- التحليل والتقارير -->
                    <button @click="switchTab('reports')"
                        class="flex items-center w-full px-4 py-3 text-white/90 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'reports' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="mx-3 font-semibold w-full text-right">التحليل والتقارير</span>
                    </button>

                    <!-- الدعم والتفاعل -->
                    <button @click="switchTab('support')"
                        class="flex items-center w-full px-4 py-3 text-white/90 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'support' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="mx-3 font-semibold w-full text-right">الدعم والتفاعل</span>
                    </button>

                    <!-- إعدادات المتجر -->
                    <button @click="switchTab('settings')"
                        class="flex items-center w-full px-4 py-3 text-white/90 rounded-xl transition-all duration-200 group text-right"
                        :class="activeTab === 'settings' ? 'bg-white/20 text-white shadow-inner' : 'hover:bg-white/10 hover:text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296-.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="mx-3 font-semibold w-full text-right">إعدادات المتجر</span>
                    </button>
                </nav>
            </div>
        </aside>

        <div class="flex flex-col flex-1 w-full transition-all duration-300" :class="{ 'lg:mr-64': sidebarOpen }">
            <header class="relative z-10 py-4 bg-white shadow-md">
                <div class="container flex items-center justify-between h-full px-6 mx-auto text-brand-orange-500">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-1 rounded-md focus:outline-none">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div class="flex items-center gap-4">
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" 
                                class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-50 transition-all duration-200 group">
                                <div class="flex flex-col text-left">
                                    <span class="text-xs text-gray-400 font-medium tracking-wider uppercase">لوحة التاجر</span>
                                    <span class="text-sm font-bold text-gray-800 group-hover:text-brand-orange-700">{{ Auth::user()->name }}</span>
                                </div>
                                <div class="w-10 h-10 rounded-full border-2 border-brand-orange-500/10 p-1 bg-transparent overflow-hidden shadow-sm group-hover:border-brand-orange-500/30 transition-colors text-center">
                                    <x-application-logo class="w-full h-full" />
                                </div>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-brand-orange-700 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                class="absolute left-0 mt-2 w-56 rounded-2xl bg-white shadow-xl ring-1 ring-black/5 p-2 space-y-1 overflow-hidden z-50 text-right">
                                
                                <div class="px-4 py-3 border-b border-gray-50 mb-1 text-right">
                                    <p class="text-xs text-gray-400">سجلت الدخول بصفتك</p>
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                <a href="{{ route('profile.edit') }}" class="flex items-center justify-end gap-3 px-4 py-2 text-sm text-gray-600 hover:bg-brand-orange-500/5 hover:text-brand-orange-500 rounded-xl transition-all">
                                    الملف الشخصي
                                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </a>

                                <a href="{{ route('logout.get') }}" class="flex items-center justify-end w-full gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-all text-right">
                                    تسجيل الخروج
                                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="h-full overflow-y-auto">
                <div class="container px-6 py-8 mx-auto">
                    <div class="flex items-center justify-between">
                        <h3 class="text-3xl font-bold text-gray-700">@yield('title')</h3>
                        @if(!request()->routeIs('vendor.dashboard'))
                            <a href="{{ route('vendor.dashboard') }}"
                                class="group flex items-center px-4 py-2 bg-white text-gray-600 rounded-full shadow-md hover:shadow-lg hover:bg-brand-orange hover:text-white transition-all duration-300 transform hover:-translate-y-1 ring-1 ring-gray-100 hover:ring-brand-orange-300">
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
                    <div class="max-w-full mx-auto">
                        @if (session('success'))
                            <div class="mb-6 px-5 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl font-bold shadow-sm flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="mb-6 px-5 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl font-bold shadow-sm flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ session('error') }}
                            </div>
                        @endif
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.body.addEventListener('submit', function (e) {
                const form = e.target;
                if (!form.tagName || form.tagName.toLowerCase() !== 'form') return;

                // Check for explicit bypass
                if (form.classList.contains('no-confirm')) return;

                // Logic to determine if confirmation is needed
                const methodInput = form.querySelector('input[name="_method"]');
                const method = methodInput ? methodInput.value.toUpperCase() : (form.method ? form.method.toUpperCase() : 'GET');
                const action = form.action.toLowerCase();
                const isExplicitConfirm = form.classList.contains('confirm-action') || form.classList.contains('confirm-delete');

                let shouldConfirm = false;
                let isDestructive = false;

                // 1. DELETE actions (Destructive)
                if (method === 'DELETE' || form.classList.contains('confirm-delete')) {
                    shouldConfirm = true;
                    isDestructive = true;
                }
                // 2. PUT/PATCH actions (Updates)
                else if (method === 'PUT' || method === 'PATCH') {
                    shouldConfirm = true;
                }
                // 3. Sensitive Keywords
                else if (action.includes('toggle') || action.includes('ban') || action.includes('activate') || action.includes('confirm') || action.includes('reject') || action.includes('restock') || action.includes('pay')) {
                    shouldConfirm = true;
                }
                // 4. Explicit class
                else if (isExplicitConfirm) {
                    shouldConfirm = true;
                }

                if (shouldConfirm) {
                    e.preventDefault();

                    let title = form.dataset.confirmTitle || 'هل أنت متأكد؟';
                    let text = form.dataset.confirmText || (isDestructive ? 'لا يمكن التراجع عن هذا الإجراء!' : 'سيتم تنفيذ العملية فوراً.');
                    let icon = form.dataset.confirmIcon || (isDestructive ? 'error' : 'warning');
                    let confirmButtonText = form.dataset.confirmButton || 'نعم، نفذ';
                    let confirmButtonColor = isDestructive ? '#ef4444' : '#ea580c'; // Red or Vendor Orange

                    Swal.fire({
                        title: title,
                        text: text,
                        icon: icon,
                        target: form.closest('dialog') || document.querySelector('dialog[open]') || 'body',
                        showCancelButton: true,
                        confirmButtonColor: confirmButtonColor,
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: confirmButtonText,
                        cancelButtonText: 'إلغاء'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>