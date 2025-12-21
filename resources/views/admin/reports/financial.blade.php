<x-admin-layout>
    <x-slot name="title">
        التقارير المالية
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <!-- فلتر الفترة الزمنية (مطابق لتابِع البائع لكن توجيه للادمن) -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-black mb-6">التقارير المالية</h2>
                    <form action="{{ route('admin.reports.financial') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">الفترة الزمنية</label>
                                <select name="period" id="period" onchange="toggleCustomDates()"
                                    class="w-full border-gray-300 rounded-lg shadow-sm">
                                    <option value="week" {{ $period == 'week' ? 'selected' : '' }}>هذا الأسبوع</option>
                                    <option value="month" {{ $period == 'month' ? 'selected' : '' }}>هذا الشهر</option>
                                    <option value="year" {{ $period == 'year' ? 'selected' : '' }}>هذا العام</option>
                                    <option value="last_month" {{ $period == 'last_month' ? 'selected' : '' }}>الشهر الماضي</option>
                                    <option value="last_year" {{ $period == 'last_year' ? 'selected' : '' }}>العام الماضي</option>
                                    <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>مخصص</option>
                                </select>
                            </div>
                            <div id="custom-dates" style="{{ $period == 'custom' ? '' : 'display: none;' }}">
                                <label class="block text-sm font-medium text-gray-700 mb-1">من تاريخ</label>
                                <input type="date" name="start_date"
                                    value="{{ $customStart ?? $startDate->format('Y-m-d') }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm">
                            </div>
                            <div id="custom-dates-end" style="{{ $period == 'custom' ? '' : 'display: none;' }}">
                                <label class="block text-sm font-medium text-gray-700 mb-1">إلى تاريخ</label>
                                <input type="date" name="end_date" value="{{ $customEnd ?? $endDate->format('Y-m-d') }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm">
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-brand-orange-700">
                                    تطبيق
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- بطاقات المحفظة (ابقى على ألوان الادمن للبطاقات الثلاثة الأولى) -->
            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-3">
                <div class="p-6 bg-orange-100 rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">إجمالي الأرصدة الحالية</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2">{{ number_format($totalBalances, 2) }} ر.ي</p>
                        </div>
                        <div class="p-3 bg-orange-50 rounded-full">
                            <svg class="w-8 h-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-green-100 rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">إجمالي أرباح التجار</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2">{{ number_format($totalEarnings, 2) }} ر.ي</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-blue-100 rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">إجمالي المبالغ المسحوبة</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2">{{ number_format($totalWithdrawals, 2) }} ر.ي</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- إحصائيات المبيعات (مطابقة لتصميم البائع لكن مع ألوان متناسقة) -->
            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-4">
                <div class="p-6 bg-purple-100 rounded-xl shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">إجمالي المبيعات</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($summary['total_sales'], 2) }} ر.ي</p>
                            @if($summary['sales_growth'] != 0)
                                <p class="text-xs mt-1 {{ $summary['sales_growth'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $summary['sales_growth'] > 0 ? '↑' : '↓' }} {{ number_format(abs($summary['sales_growth']), 1) }}%
                                </p>
                            @endif
                        </div>
                        <div class="p-3 bg-purple-50 rounded-full">
                            <svg class="w-8 h-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-yellow-100 rounded-xl shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">إجمالي الطلبات</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($summary['total_orders']) }}</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-full">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-orange-100 rounded-xl shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">متوسط قيمة الطلب</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($summary['average_order_value'], 2) }} ر.ي</p>
                        </div>
                        <div class="p-3 bg-orange-50 rounded-full">
                            <svg class="w-8 h-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-indigo-100 rounded-xl shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">الكمية المباعة</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($summary['total_quantity_sold']) }}</p>
                            <p class="text-xs text-gray-500 mt-1">قطعة</p>
                        </div>
                        <div class="p-3 bg-indigo-50 rounded-full">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- المبيعات حسب حالة الطلب وطرق الدفع (مطابق للبائع) -->
            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">المبيعات حسب حالة الطلب</h3>
                        <div class="space-y-3">
                            @foreach(['delivered' => 'مسلمة', 'processing' => 'قيد المعالجة', 'shipped' => 'تم الشحن', 'pending' => 'في الانتظار', 'cancelled' => 'ملغاة'] as $status => $label)
                                @php
                                    $statusData = $salesByStatus->get($status);
                                    $count = $statusData ? $statusData->count : 0;
                                    $total = $statusData ? $statusData->total : 0;
                                @endphp
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $label }}</p>
                                        <p class="text-sm text-gray-600">{{ $count }} طلب</p>
                                    </div>
                                    <div class="text-left">
                                        <p class="font-bold text-gray-900">{{ number_format($total, 2) }} ر.ي</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">المبيعات حسب طريقة الدفع</h3>
                        <div class="space-y-3">
                            @php
                                $paymentLabels = [
                                    'cash_on_delivery' => 'الدفع عند الاستلام',
                                    'credit_card' => 'بطاقة ائتمانية',
                                    'bank_transfer' => 'تحويل بنكي',
                                ];
                            @endphp
                            @foreach($paymentLabels as $method => $label)
                                @php
                                    $paymentData = $salesByPayment->get($method);
                                    $count = $paymentData ? $paymentData->count : 0;
                                    $total = $paymentData ? $paymentData->total : 0;
                                @endphp
                                @if($count > 0)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $label }}</p>
                                            <p class="text-sm text-gray-600">{{ $count }} طلب</p>
                                        </div>
                                        <div class="text-left">
                                            <p class="font-bold text-gray-900">{{ number_format($total, 2) }} ر.ي</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- أفضل المنتجات حسب الإيرادات -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">أفضل المنتجات حسب الإيرادات</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-brand-orange-50">
                                <tr>
                                    <th class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase">المنتج</th>
                                    <th class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase">الكمية المباعة</th>
                                    <th class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase">الإيرادات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($topProductsByRevenue->where('revenue', '>', 0) as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4">
                                            <div class="flex items-center">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-lg object-cover ml-3">
                                                @endif
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                                    @if($product->brand)
                                                        <p class="text-xs text-gray-500">{{ $product->brand }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <span class="text-sm font-semibold text-gray-700">{{ number_format($product->quantity_sold) }}</span>
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <span class="text-sm font-bold text-gray-700">{{ number_format($product->revenue, 2) }} ر.ي</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">لا توجد بيانات في الفترة المحددة</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function toggleCustomDates() {
            const period = document.getElementById('period').value;
            const customDates = document.getElementById('custom-dates');
            const customDatesEnd = document.getElementById('custom-dates-end');

            if (period === 'custom') {
                customDates.style.display = 'block';
                customDatesEnd.style.display = 'block';
            } else {
                customDates.style.display = 'none';
                customDatesEnd.style.display = 'none';
            }
        }
    </script>
</x-admin-layout>