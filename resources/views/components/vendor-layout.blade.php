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
    <div x-data="{ sidebarOpen: true }" class="flex h-screen bg-slate-100">

        <aside
            class="fixed inset-y-0 right-0 z-30 flex-shrink-0 w-64 overflow-y-auto bg-brand-orange-700 shadow-lg transition-transform duration-300 transform"
            :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'">
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-center mt-10 mb-6 flex-shrink-0">
                    <div class="flex flex-col items-center gap-4">
                        <div class="transition-transform hover:scale-110 duration-300 drop-shadow-xl">
                            <x-application-logo class="w-44 h-16 object-contain" />
                        </div>
                    </div>
                </div>

                <nav class="mt-10 flex-grow px-2">
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('vendor.dashboard') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="mx-3 font-semibold">الرئيسية</span>
                    </a>

                    <hr class="my-4 border-white">

                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('vendor.products.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="mx-3 font-semibold">إدارة المنتجات</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('vendor.orders.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span class="mx-3 font-semibold">إدارة الطلبات</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('vendor.shipping.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                        </svg>
                        <span class="mx-3 font-semibold">معلومات الشحن</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('vendor.warehouse.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m0 10l8 4m-8-4v--8 4-8-4" />
                        </svg>
                        <span class="mx-3 font-semibold">إدارة المخازن</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('vendor.advertisements.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.834 9.168-4.432" />
                        </svg>
                        <span class="mx-3 font-semibold">إدارة الإعلانات</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('vendor.discounts.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        <span class="mx-3 font-semibold">إدارة الخصومات</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('vendor.sales.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="mx-3 font-semibold">إدارة المبيعات</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('vendor.reviews.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <span class="mx-3 font-semibold">التقييمات</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('vendor.top-products.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="mx-3 font-semibold">المنتجات الأكثر طلباً</span>
                    </a>
                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('vendor.financial-reports.index') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="mx-3 font-semibold">التقارير المالية</span>
                    </a>

                    <hr class="my-4 border-white">

                    <a class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-white/10 hover:text-white"
                        href="{{ route('vendor.store.edit') }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="mx-3 font-semibold">إعدادات المتجر</span>
                    </a>
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

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center justify-end w-full gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-all text-right">
                                        تسجيل الخروج
                                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    </button>
                                </form>
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