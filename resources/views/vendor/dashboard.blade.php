<x-vendor-layout>
    <x-slot name="title">
        لوحة تحكم متجري
    </x-slot>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3">

        <a href="{{ route('vendor.products.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-blue-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-blue-100 rounded-xl">
                    <svg class="w-10 h-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المنتجات</h3>
                    <p class="mt-1 text-sm text-gray-500"><span
                            class="font-extrabold text-blue-600">{{ $stats['total_products'] ?? 0 }}</span> منتج</p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.orders.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-green-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-green-100 rounded-xl">
                    <svg class="w-10 h-10 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الطلبات</h3>
                    <p class="mt-1 text-sm text-gray-500"><span
                            class="font-extrabold text-green-600">{{ $stats['total_orders'] ?? 0 }}</span> طلب</p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.warehouse.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-yellow-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-yellow-100 rounded-xl">
                    <svg class="w-10 h-10 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m0 10l8 4m-8-4v--8 4-8-4" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المخازن</h3>
                    <p class="mt-1 text-sm text-gray-500"><span
                            class="font-extrabold text-yellow-600">{{ $stats['low_stock_products'] ?? 0 }}</span> منتج
                        قارب على النفاذ</p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.advertisements.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-purple-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-purple-100 rounded-xl">
                    <svg class="w-10 h-10 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.834 9.168-4.432" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الإعلانات</h3>
                    <p class="mt-1 text-sm text-gray-500"><span
                            class="font-extrabold text-purple-600">{{ $stats['active_advertisements'] ?? 0 }}</span>
                        إعلان نشط</p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.discounts.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-pink-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-pink-100 rounded-xl">
                    <svg class="w-10 h-10 text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الخصومات </h3>
                    <p class="mt-1 text-sm text-gray-500"><span
                            class="font-extrabold text-pink-600">{{ $stats['active_discounts'] ?? 0 }}</span> كوبون فعال
                    </p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.sales.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-red-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-red-100 rounded-xl">
                    <svg class="w-10 h-10 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المبيعات</h3>
                    <p class="mt-1 text-sm text-gray-500"><span class="font-extrabold text-red-600">0</span> ريال هذا
                        الشهر</p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.reviews.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-yellow-400/20 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-yellow-100 rounded-xl">
                    <svg class="w-10 h-10 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">التقييمات</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-yellow-500">{{ $stats['pending_reviews'] ?? 0 }}</span> تقييم
                        قيد المراجعة
                        @if(($stats['average_rating'] ?? 0) > 0)
                            | <span class="font-extrabold text-yellow-600">{{ number_format($stats['average_rating'], 1) }}
                                ⭐</span>
                        @endif
                    </p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.top-products.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-indigo-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-indigo-100 rounded-xl">
                    <svg class="w-10 h-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">المنتجات الأكثر طلباً</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-indigo-600">{{ $stats['top_products_count'] ?? 0 }}</span> منتج
                        مبيع
                        @if(($stats['top_products_total_sold'] ?? 0) > 0)
                            | <span
                                class="font-extrabold text-indigo-600">{{ number_format($stats['top_products_total_sold']) }}</span>
                            قطعة
                        @endif
                    </p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.financial-reports.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-cyan-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-cyan-100 rounded-xl">
                    <svg class="w-10 h-10 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">التقارير المالية</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if(isset($stats['wallet_balance']))
                            <span class="font-extrabold text-cyan-600">{{ number_format($stats['wallet_balance'], 2) }} ريال
                                يمني</span> في المحفظة
                        @else
                            عرض تقارير الأرباح والمبيعات
                        @endif
                    </p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.store.edit') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-gray-100 transition-all duration-300 md:col-span-2 xl:col-span-3">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-gray-200 rounded-xl">
                    <svg class="w-10 h-10 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إعدادات المتجر</h3>
                    <p class="mt-1 text-sm text-gray-500">تعديل اسم المتجر، الشعار، إلخ.</p>
                </div>
            </div>
        </a>

    </div>
</x-vendor-layout>