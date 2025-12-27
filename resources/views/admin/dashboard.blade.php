<x-admin-layout>

    <x-slot name="title">
        لوحة التحكم الرئيسية
    </x-slot>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Pie Chart (Right in RTL) -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-lg font-bold text-gray-800 mb-4">التصنيفات الأكثر طلبًا</h3>
            <div class="relative h-64 flex justify-center">
                <canvas id="categoriesChart"></canvas>
            </div>
        </div>

        <!-- Line Chart (Left in RTL) -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-lg font-bold text-gray-800 mb-4">إحصائيات المبيعات (آخر 30 يوم)</h3>
            <div class="relative h-64">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3 lg:grid-cols-4">

        <!-- 1. Orders Management (New) -->
        <a href="{{ route('admin.orders.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-cyan-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-cyan-100 rounded-xl">
                    <svg class="w-8 h-8 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الطلبات</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-cyan-600">{{ $ordersCount }}</span> طلب
                    </p>
                </div>
            </div>
        </a>

        <!-- 2. Products Management (Existing) -->
        <a href="{{ route('admin.products.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-blue-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-blue-100 rounded-xl">
                    <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المنتجات</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-blue-600">{{ $productCount }}</span> منتج
                    </p>
                </div>
            </div>
        </a>

        <!-- 3. Categories Management (New - Priority Placement) -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-violet-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-violet-100 rounded-xl">
                    <svg class="w-8 h-8 text-violet-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة التصنيفات</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-violet-600">{{ $categoriesCount }}</span> تصنيف
                    </p>
                </div>
            </div>
        </a>

        <!-- 3. Stores Management (Existing) -->
        <a href="{{ route('admin.stores.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-orange-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-orange-100 rounded-xl">
                    <svg class="w-8 h-8 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المتاجر</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-orange-600">{{ $activeStoresCount }}</span> متجر نشط
                    </p>
                </div>
            </div>
        </a>

        <!-- 4. Vendors Management (Existing) -->
        <a href="{{ route('admin.vendors.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-indigo-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-indigo-100 rounded-xl">
                    <svg class="w-8 h-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة البائعين</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-indigo-600">{{ $vendorCount }}</span> بائع مسجل
                    </p>
                </div>
            </div>
        </a>

        <!-- 5. Customers Management (Existing) -->
        <a href="{{ route('admin.users.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-green-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-green-100 rounded-xl">
                    <svg class="w-8 h-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A10.99 10.99 0 0112 10c2.67 0 5.057 1.22 6.75 3.147" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة العملاء</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-green-600">{{ $customerCount }}</span> عميل مسجل
                    </p>
                </div>
            </div>
        </a>

        <!-- 6. Returns Management (New) -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-rose-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-rose-100 rounded-xl">
                    <svg class="w-8 h-8 text-rose-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المرتجعات</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-rose-600">{{ $returnsCount }}</span> طلب مرتجع
                    </p>
                </div>
            </div>
        </a>

        <!-- 7. Shipping Management (New) -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-slate-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-slate-100 rounded-xl">
                    <svg class="w-8 h-8 text-slate-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الشحن</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-slate-600">{{ $shippingCount }}</span> شحنة نشطة
                    </p>
                </div>
            </div>
        </a>

        <!-- 8. Inventory Management (New) -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-teal-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-teal-100 rounded-xl">
                    <svg class="w-8 h-8 text-teal-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المخزون</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-teal-600">{{ $inventoryCount }}</span> وحدة
                    </p>
                </div>
            </div>
        </a>

        <!-- 9. Financial Reports (Existing) -->
        <a href="{{ route('admin.reports.financial') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-emerald-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-emerald-100 rounded-xl">
                    <svg class="w-8 h-8 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">التقارير المالية</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-emerald-600">{{ $financialReportsCount }}</span> تقرير
                    </p>
                </div>
            </div>
        </a>

        <!-- 10. Wallets Management (Existing) -->
        <a href="{{ route('admin.wallets.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-purple-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-purple-100 rounded-xl">
                    <svg class="w-8 h-8 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المحافظ</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-purple-600">{{ number_format($walletTotalBalance, 2) }}</span>
                        ر.ي
                    </p>
                </div>
            </div>
        </a>

        <!-- 11. Payment Management (New) -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-lime-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-lime-100 rounded-xl">
                    <svg class="w-8 h-8 text-lime-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الدفع</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-lime-600">{{ $paymentCount }}</span> عملية دفع
                    </p>
                </div>
            </div>
        </a>

        <!-- 12. Offers & Ads (New) -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-yellow-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-yellow-100 rounded-xl">
                    <svg class="w-8 h-8 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">العروض والإعلانات</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-yellow-600">{{ $advertisementCount }}</span> إعلان
                    </p>
                </div>
            </div>
        </a>

        <!-- 13. Discount Coupons (New) -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-amber-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-amber-100 rounded-xl">
                    <svg class="w-8 h-8 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">كوبونات الخصم</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-amber-600">{{ $discountCount }}</span> كوبون
                    </p>
                </div>
            </div>
        </a>

        <!-- 14. Reviews (Existing) -->
        <a href="{{ route('admin.reviews.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-yellow-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-yellow-100 rounded-xl">
                    <svg class="w-8 h-8 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">التقييمات</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-yellow-600">{{ $reviewCount }}</span> تقييم
                    </p>
                </div>
            </div>
        </a>

        <!-- 15. Customer Analysis (New) -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-sky-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-sky-100 rounded-xl">
                    <svg class="w-8 h-8 text-sky-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">تحليل العملاء</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-sky-600">{{ $newCustomersCount }}</span> عميل جديد
                    </p>
                </div>
            </div>
        </a>

        <!-- 16. Complaints (Existing) -->
        <a href="{{ route('admin.complaints.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-red-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-red-100 rounded-xl">
                    <svg class="w-8 h-8 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الشكاوى</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-red-600">{{ $complaintOpenCount }}</span> شكوى
                    </p>
                </div>
            </div>
        </a>

        <!-- 17. Technical Support (New) -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-fuchsia-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-fuchsia-100 rounded-xl">
                    <svg class="w-8 h-8 text-fuchsia-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">الدعم الفني</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-fuchsia-600">0</span> تذكرة
                    </p>
                </div>
            </div>
        </a>

        <!-- 18. Notifications (Existing) -->
        <a href="{{ route('admin.notifications.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-pink-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-pink-100 rounded-xl">
                    <svg class="w-8 h-8 text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الإشعارات</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-pink-600">{{ $notificationCount }}</span> إشعار
                    </p>
                </div>
            </div>
        </a>

        <!-- 19. Platform Settings (New) -->
        <a href="{{ route('admin.settings.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-gray-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-gray-100 rounded-xl">
                    <svg class="w-8 h-8 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إعدادات المنصة</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-gray-600">عام</span>
                    </p>
                </div>
            </div>
        </a>

        <!-- 22. Activity Log (New) -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-slate-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-slate-100 rounded-xl">
                    <svg class="w-8 h-8 text-slate-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">سجل الأنشطة</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-slate-600">{{ $activityLogCount }}</span> عملية
                    </p>
                </div>
            </div>
        </a>

    </div>

    <!-- ChartJS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sales Chart (Line)
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: @json($salesLabels),
                    datasets: [{
                        label: 'المبيعات (ر.ي)',
                        data: @json($salesValues),
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Categories Chart (Pie)
            const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
            new Chart(categoriesCtx, {
                type: 'pie',
                data: {
                    labels: @json($categoryLabels),
                    datasets: [{
                        data: @json($categoryValues),
                        backgroundColor: [
                            '#3B82F6', // Blue
                            '#10B981', // Green
                            '#F59E0B', // Yellow
                            '#EF4444', // Red
                            '#8B5CF6'  // Purple
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>