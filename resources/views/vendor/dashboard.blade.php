<x-vendor-layout>
    <x-slot name="title">
        لوحة تحكم متجري
    </x-slot>

    <!-- 🏠 قسم الرئيسية: للإحصائيات فقط -->
    <div x-show="activeTab === 'home'" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100">

        {{-- Charts & Stats Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            {{-- Sales Chart --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-r-4 border-orange-500 pr-3">مبيعات آخر 7 أيام</h3>
                <div class="relative h-80 w-full">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- Ratings --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-r-4 border-yellow-500 pr-3">تقييمات المنتجات</h3>
                <div class="flex flex-col items-center justify-center p-4">
                    <div class="text-5xl font-bold text-gray-800 mb-2">{{ number_format($ratingStats['average'], 1) }}</div>
                    <div class="text-yellow-400 text-2xl mb-2 tracking-widest">
                        @for($i = 1; $i <= 5; $i++)
                            <span>{{ $i <= round($ratingStats['average']) ? '★' : '☆' }}</span>
                        @endfor
                    </div>
                    <p class="text-sm text-gray-500 mb-6">بناءً على {{ $ratingStats['count'] }} تقييم</p>

                    <div class="w-full space-y-3">
                        @foreach([5, 4, 3, 2, 1] as $star)
                            <div class="flex items-center text-xs">
                                <span class="w-8 font-medium text-gray-600">{{ $star }} ★</span>
                                <div class="flex-1 mx-2 h-2 bg-gray-100 rounded-full overflow-hidden">
                                    @php
                                        $percentage = $ratingStats['count'] > 0 ? ($ratingStats['stars'][$star] / $ratingStats['count']) * 100 : 0;
                                    @endphp
                                    <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="w-6 text-left text-gray-500">{{ $ratingStats['stars'][$star] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Lists Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            {{-- Top Selling Products --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-r-4 border-indigo-500 pr-3">الأكثر مبيعاً</h3>
                <div class="space-y-4">
                    @forelse($top5Products as $product)
                        <div class="flex items-center justify-between pb-3 border-b border-gray-50 last:border-0 hover:bg-gray-50 p-2 rounded transition-colors">
                            <div class="flex items-center flex-1 min-w-0">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        class="w-10 h-10 rounded-lg object-cover ml-3 bg-gray-100 flex-shrink-0">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center ml-3 text-indigo-500 flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="truncate">
                                    <p class="text-sm font-bold text-gray-800 truncate" title="{{ $product->name }}">{{ $product->name }}</p>
                                    <p class="text-xs text-indigo-600 font-semibold">{{ $product->total_quantity_sold }} قطعة مباعة</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-400">لا توجد مبيعات كافية لعرضها</div>
                    @endforelse
                </div>
            </div>

            {{-- Low Stock Products --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-r-4 border-red-500 pr-3">تنبيهات المخزون</h3>
                <div class="space-y-4">
                    @forelse($lowStockProducts as $product)
                        <div class="flex items-center justify-between pb-3 border-b border-gray-50 last:border-0 hover:bg-gray-50 p-2 rounded transition-colors">
                            <div class="flex-1 min-w-0 ml-2">
                                <p class="text-sm font-medium text-gray-800 truncate" title="{{ $product->name }}">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">الكمية الحالية</p>
                            </div>
                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-bold {{ $product->stock == 0 ? 'bg-red-100 text-red-800' : 'bg-red-50 text-red-600' }}">{{ $product->stock }}</span>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-green-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm text-gray-500">جميع المنتجات متوفرة</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Pending Orders --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-r-4 border-green-500 pr-3">طلبات جديدة</h3>
                <div class="space-y-4">
                    @forelse($latestPendingOrders as $order)
                        <a href="{{ route('vendor.orders.show', $order->id) }}" class="flex items-center justify-between pb-3 border-b border-gray-50 last:border-0 hover:bg-green-50 p-2 rounded transition-colors group">
                            <div>
                                <div class="flex items-center">
                                    <span class="text-sm font-bold text-gray-800 group-hover:text-green-700">#{{ $order->id }}</span>
                                    <span class="text-xs text-gray-400 mr-2">{{ $order->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ $order->user->name ?? 'عميل زائر' }}</p>
                            </div>
                            <div class="text-left">
                                <span class="block text-sm font-bold text-green-600">{{ number_format($order->total_amount, 0) }}</span>
                                <span class="text-xs text-gray-400">ريال</span>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-8 text-gray-400">لا توجد طلبات جديدة</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- 🛒 إدارة العمليات -->
    <div x-show="activeTab === 'operations'" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" x-transition>
        <a href="{{ route('vendor.orders.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-green-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-green-100 rounded-xl">
                    <svg class="w-10 h-10 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الطلبات</h3>
                    <p class="mt-1 text-sm text-gray-500"><span class="font-extrabold text-green-600">{{ $stats['total_orders'] ?? 0 }}</span> طلب</p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.shipping.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-orange-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-orange-100 rounded-xl">
                    <svg class="w-10 h-10 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">معلومات الشحن</h3>
                    <p class="mt-1 text-sm text-gray-500">إدارة الشحن والتوصيل</p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.warehouse.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-yellow-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-yellow-100 rounded-xl">
                    <svg class="w-10 h-10 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m0 10l8 4m-8-4v--8 4-8-4" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المخازن</h3>
                    <p class="mt-1 text-sm text-gray-500"><span class="font-extrabold text-yellow-600">{{ $stats['low_stock_products'] ?? 0 }}</span> منتج قارب على النفاذ</p>
                </div>
            </div>
        </a>
    </div>

    <!-- 📦 المحتوى والتسويق -->
    <div x-show="activeTab === 'content'" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" x-transition>
        <a href="{{ route('vendor.products.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-blue-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-blue-100 rounded-xl">
                    <svg class="w-10 h-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المنتجات</h3>
                    <p class="mt-1 text-sm text-gray-500"><span class="font-extrabold text-blue-600">{{ $stats['total_products'] ?? 0 }}</span> منتج</p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.advertisements.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-purple-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-purple-100 rounded-xl">
                    <svg class="w-10 h-10 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.834 9.168-4.432" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الإعلانات</h3>
                    <p class="mt-1 text-sm text-gray-500"><span class="font-extrabold text-purple-600">{{ $stats['active_advertisements'] ?? 0 }}</span> إعلان نشط</p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.discounts.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-pink-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-pink-100 rounded-xl">
                    <svg class="w-10 h-10 text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الخصومات</h3>
                    <p class="mt-1 text-sm text-gray-500"><span class="font-extrabold text-pink-600">{{ $stats['active_discounts'] ?? 0 }}</span> كوبون فعال</p>
                </div>
            </div>
        </a>
    </div>

    <!-- 📊 التحليل والتقارير -->
    <div x-show="activeTab === 'reports'" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" x-transition>
        <a href="{{ route('vendor.sales.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-red-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-red-100 rounded-xl">
                    <svg class="w-10 h-10 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المبيعات</h3>
                    <p class="mt-1 text-sm text-gray-500"><span class="font-extrabold text-red-600">0</span> ريال هذا الشهر</p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.financial-reports.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-cyan-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-cyan-100 rounded-xl">
                    <svg class="w-10 h-10 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">التقارير المالية</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if(isset($stats['wallet_balance']))
                            <span class="font-extrabold text-cyan-600">{{ number_format($stats['wallet_balance'], 2) }} ريال</span> بالمحفظة
                        @else
                            عرض تقارير الأرباح
                        @endif
                    </p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.top-products.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-indigo-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-indigo-100 rounded-xl">
                    <svg class="w-10 h-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">المنتجات الأكثر طلباً</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-indigo-600">{{ $stats['top_products_count'] ?? 0 }}</span> منتج مبيع
                    </p>
                </div>
            </div>
        </a>
    </div>

    <!-- 🎧 الدعم والتفاعل -->
    <div x-show="activeTab === 'support'" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" x-transition>
        <a href="{{ route('vendor.reviews.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-yellow-400/20 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-yellow-100 rounded-xl">
                    <svg class="w-10 h-10 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">التقييمات</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-yellow-500">{{ $stats['pending_reviews'] ?? 0 }}</span> قيد المراجعة
                    </p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.messages.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-orange-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-orange-100 rounded-xl">
                    <svg class="w-10 h-10 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">رسائل العملاء</h3>
                    <p class="mt-1 text-sm text-gray-500">الرد والتفاعل مع استفسارات عملائك</p>
                </div>
            </div>
        </a>

        <a href="{{ route('vendor.chatbot-rules.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-teal-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-teal-100 rounded-xl">
                    <svg class="w-10 h-10 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">الردود التلقائية (Chatbot)</h3>
                    <p class="mt-1 text-sm text-gray-500">إدارة الردود والرسائل المبرمجة</p>
                </div>
            </div>
        </a>
    </div>

    <!-- ⚙️ إعدادات المتجر -->
    <div x-show="activeTab === 'settings'" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" x-transition>
        <a href="{{ route('vendor.store.edit') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-gray-100 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-gray-200 rounded-xl">
                    <svg class="w-10 h-10 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إعدادات المتجر</h3>
                    <p class="mt-1 text-sm text-gray-500">تعديل اسم المتجر، الشعار والإعدادات</p>
                </div>
            </div>
        </a>
    </div>

    <!-- ChartJS Scripts (Only needed if home is loaded) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('salesChart')) {
                const ctx = document.getElementById('salesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($salesChartLabels),
                        datasets: [{
                            label: 'المبيعات (ريال)',
                            data: @json($salesChartData),
                            borderColor: '#ea580c',
                            backgroundColor: 'rgba(234, 88, 12, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#ea580c'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#fff',
                                titleColor: '#1f2937',
                                bodyColor: '#ea580c',
                                borderColor: '#e5e7eb',
                                borderWidth: 1,
                                padding: 10,
                                displayColors: false,
                                callbacks: {
                                    label: function (context) {
                                        return context.parsed.y.toLocaleString() + ' ريال';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { borderDash: [2, 2], color: '#f3f4f6' },
                                ticks: { font: { family: 'Tajawal' } }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { family: 'Tajawal' } }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                    }
                });
            }
        });
    </script>
    @aiAgentWidget
    <script src="/ai-agent/widget.js"></script>
</x-vendor-layout>