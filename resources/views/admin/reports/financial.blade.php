<x-admin-layout>
    <x-slot name="title">
        التقارير المالية للمنصة
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <!-- Filter Tabs -->
            <div class="bg-white border-b border-gray-200 mb-6 flex overflow-x-auto shadow-sm sm:rounded-lg">
                <a href="{{ route('admin.reports.financial', ['period' => 'week']) }}"
                    class="px-6 py-4 font-bold text-sm focus:outline-none border-b-2 transition-colors duration-150 {{ $period == 'week' ? 'border-brand-blue text-brand-blue bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                    تقرير أسبوعي
                </a>
                <a href="{{ route('admin.reports.financial', ['period' => 'month']) }}"
                    class="px-6 py-4 font-bold text-sm focus:outline-none border-b-2 transition-colors duration-150 {{ $period == 'month' ? 'border-brand-blue text-brand-blue bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                    تقرير شهري
                </a>
                <a href="{{ route('admin.reports.financial', ['period' => 'year']) }}"
                    class="px-6 py-4 font-bold text-sm focus:outline-none border-b-2 transition-colors duration-150 {{ $period == 'year' ? 'border-brand-blue text-brand-blue bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                    تقرير سنوي
                </a>
                <a href="{{ route('admin.reports.financial', ['period' => 'custom']) }}"
                    class="px-6 py-4 font-bold text-sm focus:outline-none border-b-2 transition-colors duration-150 {{ $period == 'custom' ? 'border-brand-blue text-brand-blue bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                    فترة مخصصة
                </a>
            </div>

            <!-- Custom Date Form -->
            @if($period == 'custom')
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6 p-6 border-t-4 border-brand-blue">
                    <form action="{{ route('admin.reports.financial') }}" method="GET"
                        class="flex flex-wrap items-end gap-4">
                        <input type="hidden" name="period" value="custom">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">من تاريخ</label>
                            <input type="date" name="start_date" value="{{ $customStart }}"
                                class="rounded-lg border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">إلى تاريخ</label>
                            <input type="date" name="end_date" value="{{ $customEnd }}"
                                class="rounded-lg border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 text-sm">
                        </div>
                        <button type="submit"
                            class="bg-brand-blue hover:bg-blue-800 text-white font-bold py-2 px-6 rounded-lg shadow transition-colors">تحديث
                            التقرير</button>
                    </form>
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Platform Net Profit (NEW) -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-b-4 border-yellow-500 p-6 relative">
                    <div class="absolute top-0 left-0 p-2">
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded">عمولة 10%</span>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">صافي أرباح المنصة</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($platformNetProfit, 2) }}
                                <span class="text-sm font-normal text-gray-400">ر.س</span></h3>
                        </div>
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-gray-500">
                        الدخل الصافي للمنصة من العمولات
                    </div>
                </div>

                <!-- Total Sales (GMV) -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-b-4 border-blue-500 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">إجمالي مبيعات المتاجر (GMV)</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($summary['total_sales'], 2) }}
                                <span class="text-sm font-normal text-gray-400">ر.س</span></h3>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                    @if($summary['sales_growth'] != 0)
                        <div class="mt-4 text-sm {{ $summary['sales_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <span
                                class="font-bold">{{ $summary['sales_growth'] >= 0 ? '+' : '' }}{{ number_format($summary['sales_growth'], 1) }}%</span>
                            نمو عن الفترة السابقة
                        </div>
                    @endif
                </div>

                <!-- Total Orders -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-b-4 border-purple-500 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">إجمالي الطلبات</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($summary['total_orders']) }}
                                <span class="text-sm font-normal text-gray-400">طلب</span></h3>
                        </div>
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-gray-500">
                        <span class="font-bold text-gray-800">{{ $summary['delivered_orders'] }}</span> طلب مكتمل
                    </div>
                </div>

                <!-- Wallet Balance -->
                <div
                    class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border-b-4 border-gray-600 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-300 mb-1">مستحقات التجار</p>
                            <h3 class="text-2xl font-bold">{{ number_format($walletStats['balance'], 2) }} <span
                                    class="text-sm font-normal text-gray-400">ر.س</span></h3>
                        </div>
                        <div class="p-3 rounded-full bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-gray-400 flex justify-between">
                        <span>تم سحبه: {{ number_format($walletStats['withdrawn_amount'], 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Sales Chart -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-brand-blue-800 mb-4 border-b pb-2">منحنى مبيعات المنصة</h3>
                    <div class="relative h-72">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <!-- Status Chart -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-brand-blue-800 mb-4 border-b pb-2">توزيع حالات الطلبات</h3>
                    <div class="relative h-56 flex justify-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="mt-4 text-sm text-gray-500 text-center">
                        إجمالي عدد الطلبات: {{ $summary['total_orders'] }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top Stores Table (NEW) -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-bold text-brand-blue-800 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 ml-2"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            المتاجر الأعلى أداءً
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-brand-blue-50">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                            المتجر</th>
                                        <th
                                            class="px-4 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                            عدد الطلبات</th>
                                        <th
                                            class="px-4 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                            إجمالي المبيعات</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($topStoresByRevenue as $storeData)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-4 py-4 whitespace-nowrap font-bold text-gray-800">
                                                {{ $storeData->store->name ?? 'متجر غير معروف' }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ $storeData->orders_count }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                                                {{ number_format($storeData->revenue, 2) }} ر.س
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-8 text-center text-gray-500 text-sm">
                                                لا توجد بيانات.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Top Products Table -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-bold text-brand-blue-800 mb-4">المنتجات الأكثر مبيعاً</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-brand-blue-50">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                            المنتج</th>
                                        <th
                                            class="px-4 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                            مباع</th>
                                        <th
                                            class="px-4 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                            الإيرادات</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($topProductsByRevenue->take(5) as $product)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-4 py-4 whitespace-nowrap flex items-center gap-2">
                                                @if($product->image)
                                                    <img src="{{ Storage::url($product->image) }}"
                                                        class="w-8 h-8 rounded object-cover border">
                                                @endif
                                                <div class="text-sm font-medium text-gray-900 truncate max-w-[150px]"
                                                    title="{{ $product->name }}">{{ $product->name }}</div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                                <span class="text-sm text-gray-600">{{ $product->quantity_sold }}</span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                                                {{ number_format($product->revenue, 2) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-8 text-center text-gray-500 text-sm">
                                                لا توجد بيانات.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Shared Options
            Chart.defaults.font.family = "'Cairo', sans-serif";

            // Sales Chart
            const ctxSales = document.getElementById('salesChart').getContext('2d');
            new Chart(ctxSales, {
                type: 'line',
                data: {
                    labels: @json($dailySales->pluck('date')),
                    datasets: [{
                        label: 'مبيعات المنصة (ر.س)',
                        data: @json($dailySales->pluck('total')),
                        borderColor: '#2563EB', // brand-blue-600 approx
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#2563EB',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 4] }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // Status Chart
            const arabicStatus = {
                'pending': 'قيد الانتظار',
                'processing': 'جاري التجهيز',
                'shipped': 'تم الشحن',
                'delivered': 'تم التوصيل',
                'cancelled': 'ملغي'
            };
            const statusKeys = @json(array_keys($salesByStatus->toArray()));
            const statusLabels = statusKeys.map(k => arabicStatus[k] || k);

            new Chart(document.getElementById('statusChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: @json(array_column($salesByStatus->toArray(), 'count')),
                        backgroundColor: ['#fbbf24', '#60a5fa', '#818cf8', '#34d399', '#f87171'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right', labels: { boxWidth: 12 } }
                    }
                }
            });
        });
    </script>
</x-admin-layout>