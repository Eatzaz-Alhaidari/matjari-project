<x-vendor-layout>
    <x-slot name="title">
        المنتجات الأكثر طلباً
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">


            <!-- إحصائيات -->
            <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-3">
                <div class="p-4 bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">إجمالي الكمية المباعة</p>
                            <p class="text-2xl font-bold text-gray-800">
                                {{ number_format($stats['total_quantity_sold']) }}
                            </p>
                            <p class="text-xs text-gray-500">آخر {{ $stats['period_days'] }} يوم</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">إجمالي الإيرادات</p>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($stats['total_revenue'], 2) }}
                                ر.ي</p>
                            <p class="text-xs text-gray-500">آخر {{ $stats['period_days'] }} يوم</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">عدد المنتجات المباعة</p>
                            <p class="text-2xl font-bold text-purple-600">{{ $stats['total_products_in_orders'] }}</p>
                            <p class="text-xs text-gray-500">منتج لديه مبيعات</p>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-full">
                            <svg class="w-8 h-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m0 10l8 4m-8-4v--8 4-8-4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-black">المنتجات الأكثر طلباً</h2>
                    </div>

                    <!-- فلاتر البحث -->
                    <form action="{{ route('vendor.top-products.index') }}" method="GET" class="mb-6">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">الفترة الزمنية</label>
                                <select name="days" class="w-full border-gray-300 rounded-lg shadow-sm">
                                    <option value="7" {{ $days == 7 ? 'selected' : '' }}>آخر 7 أيام</option>
                                    <option value="30" {{ $days == 30 ? 'selected' : '' }}>آخر 30 يوم</option>
                                    <option value="60" {{ $days == 60 ? 'selected' : '' }}>آخر 60 يوم</option>
                                    <option value="90" {{ $days == 90 ? 'selected' : '' }}>آخر 90 يوم</option>
                                    <option value="365" {{ $days == 365 ? 'selected' : '' }}>آخر سنة</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">حالة الطلب</label>
                                <select name="order_status" class="w-full border-gray-300 rounded-lg shadow-sm">
                                    <option value="all" {{ $orderStatus == 'all' ? 'selected' : '' }}>جميع الطلبات
                                    </option>
                                    <option value="delivered" {{ $orderStatus == 'delivered' ? 'selected' : '' }}>الطلبات
                                        المسلمة فقط</option>
                                    <option value="paid" {{ $orderStatus == 'paid' ? 'selected' : '' }}>الطلبات المدفوعة
                                        فقط</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-brand-orange-700">
                                    تطبيق الفلاتر
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="overflow-x-auto bg-white">
                        <table class="min-w-full">
                            <thead class="bg-brand-orange-50">
                                <tr>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        الترتيب
                                    </th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        المنتج
                                    </th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        الكمية المباعة
                                    </th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        إجمالي الإيرادات
                                    </th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        عدد الطلبات
                                    </th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        السعر الحالي
                                    </th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        المخزون
                                    </th>
                                    <th
                                        class="px-5 py-3 text-center text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        الإجراءات
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($products as $index => $product)
                                                            <tr class="hover:bg-gray-50 {{ $index < 5 ? 'bg-yellow-50' : '' }}">
                                                                <td class="px-5 py-4 text-center">
                                                                    @if($index < 3)
                                                                        <span class="text-2xl">
                                                                            @if($index == 0) 🥇
                                                                            @elseif($index == 1) 🥈
                                                                            @else 🥉
                                                                            @endif
                                                                        </span>
                                                                    @else
                                                                        <span class="text-lg font-bold text-gray-600">#{{ $index + 1 }}</span>
                                                                    @endif
                                                                </td>
                                                                <td class="px-5 py-4">
                                                                    <div class="flex items-center">
                                                                        @if($product->image)
                                                                            <div class="flex-shrink-0 w-12 h-12 ml-3">
                                                                                <img class="w-12 h-12 rounded-lg object-cover"
                                                                                    src="{{ asset('storage/' . $product->image) }}"
                                                                                    alt="{{ $product->name }}">
                                                                            </div>
                                                                        @endif
                                                                        <div>
                                                                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}
                                                                            </div>
                                                                            @if($product->brand)
                                                                                <div class="text-xs text-gray-500">{{ $product->brand }}</div>
                                                                            @endif
                                                                            @if($product->category && $product->category->name)
                                                                                <div class="text-xs text-gray-400">{{ $product->category->name }}</div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="px-5 py-4 text-center">
                                                                    <span class="text-lg font-bold text-indigo-600">
                                                                        {{ number_format($product->total_quantity_sold ?? 0) }}
                                                                    </span>
                                                                    <div class="text-xs text-gray-500">قطعة</div>
                                                                </td>
                                                                <td class="px-5 py-4 text-center">
                                                                    <span class="text-lg font-bold text-green-600">
                                                                        {{ number_format($product->total_revenue ?? 0, 2) }} ر.ي
                                                                    </span>
                                                                </td>
                                                                <td class="px-5 py-4 text-center">
                                                                    <span class="text-sm font-semibold text-gray-700">
                                                                        {{ number_format($product->total_orders ?? 0) }}
                                                                    </span>
                                                                    <div class="text-xs text-gray-500">طلب</div>
                                                                </td>
                                                                <td class="px-5 py-4 text-center">
                                                                    <span class="text-sm font-semibold text-gray-900">
                                                                        {{ number_format($product->price, 2) }} ر.ي
                                                                    </span>
                                                                </td>
                                                                <td class="px-5 py-4 text-center">
                                                                    <span
                                                                        class="px-2 py-1 text-xs rounded-full font-semibold 
                                                                                                                                                                {{ $product->stock > 10 ? 'bg-green-100 text-green-800' :
                                    ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                                        {{ $product->stock }}
                                                                    </span>
                                                                </td>
                                                                <td class="px-5 py-4 text-center text-sm font-medium">
                                                                    <a href="{{ route('vendor.products.show', $product->id) }}"
                                                                        class="px-3 py-1 text-xs rounded-full font-semibold bg-blue-100 text-blue-800 hover:bg-blue-200">
                                                                        عرض التفاصيل
                                                                    </a>
                                                                </td>
                                                            </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                            لا توجد منتجات مع مبيعات في الفترة المحددة.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($products->isEmpty())
                        <div class="mt-6 text-center">
                            <p class="text-gray-500">لا توجد مبيعات في الفترة المحددة. جرب تغيير الفترة الزمنية أو حالة
                                الطلب.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>