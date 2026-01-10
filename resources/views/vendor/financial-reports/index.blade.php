<x-vendor-layout>
    <x-slot name="title">
        التقارير المالية
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <!-- Filter Tabs (Like Orders Page) -->
            <div class="bg-white border-b border-gray-200 mb-6 flex overflow-x-auto shadow-sm sm:rounded-lg">
                <a href="{{ route('vendor.financial-reports.index', ['period' => 'week']) }}"
                    class="px-6 py-4 font-bold text-sm focus:outline-none border-b-2 transition-colors duration-150 {{ $period == 'week' ? 'border-orange-500 text-orange-600 bg-orange-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                    تقرير أسبوعي
                </a>
                <a href="{{ route('vendor.financial-reports.index', ['period' => 'month']) }}"
                    class="px-6 py-4 font-bold text-sm focus:outline-none border-b-2 transition-colors duration-150 {{ $period == 'month' ? 'border-orange-500 text-orange-600 bg-orange-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                    تقرير شهري
                </a>
                <a href="{{ route('vendor.financial-reports.index', ['period' => 'year']) }}"
                    class="px-6 py-4 font-bold text-sm focus:outline-none border-b-2 transition-colors duration-150 {{ $period == 'year' ? 'border-orange-500 text-orange-600 bg-orange-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                    تقرير سنوي
                </a>
                <a href="{{ route('vendor.financial-reports.index', ['period' => 'custom']) }}"
                    class="px-6 py-4 font-bold text-sm focus:outline-none border-b-2 transition-colors duration-150 {{ $period == 'custom' ? 'border-orange-500 text-orange-600 bg-orange-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                    فترة مخصصة
                </a>
            </div>

            <!-- Custom Date Form -->
            @if($period == 'custom')
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6 p-6 border-t-4 border-orange-500">
                    <form action="{{ route('vendor.financial-reports.index') }}" method="GET"
                        class="flex flex-wrap items-end gap-4">
                        <input type="hidden" name="period" value="custom">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">من تاريخ</label>
                            <input type="date" name="start_date" value="{{ $customStart }}"
                                class="rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-500 focus:ring-opacity-50 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">إلى تاريخ</label>
                            <input type="date" name="end_date" value="{{ $customEnd }}"
                                class="rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-500 focus:ring-opacity-50 text-sm">
                        </div>
                        <button type="submit"
                            class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded-lg shadow transition-colors">تحديث
                            التقرير</button>
                    </form>
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Sales -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-b-4 border-orange-500 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">إجمالي المبيعات</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($summary['total_sales'], 2) }}
                                <span class="text-sm font-normal text-gray-400">ر.س</span></h3>
                        </div>
                        <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    @if($summary['sales_growth'] != 0)
                        <div class="mt-4 text-sm {{ $summary['sales_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <span
                                class="font-bold">{{ $summary['sales_growth'] >= 0 ? '+' : '' }}{{ number_format($summary['sales_growth'], 1) }}%</span>
                            عن الفترة السابقة
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

                <!-- Products Sold -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-b-4 border-green-500 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">القطع المباعة</p>
                            <h3 class="text-2xl font-bold text-gray-800">
                                {{ number_format($summary['total_quantity_sold']) }} <span
                                    class="text-sm font-normal text-gray-400">قطعة</span></h3>
                        </div>
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-gray-500">
                        متوسط السلة: <span
                            class="font-bold">{{ number_format($summary['average_order_value'], 2) }}</span> ر.س
                    </div>
                </div>

                <!-- Wallet Balance -->
                <div
                    class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border-b-4 border-gray-600 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-300 mb-1">رصيد المحفظة</p>
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
                        <span>سحوبات: {{ number_format($walletStats['withdrawn_amount'], 2) }}</span>
                        <span>أرباح: {{ number_format($walletStats['total_earnings'], 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Sales Chart -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-orange-800 mb-4 border-b pb-2">منحنى المبيعات</h3>
                    <div class="relative h-72">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <!-- Status Chart -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-orange-800 mb-4 border-b pb-2">توزيع حالات الطلبات</h3>
                    <div class="relative h-56 flex justify-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="mt-4 text-sm text-gray-500 text-center">
                        إجمالي عدد الطلبات: {{ $summary['total_orders'] }}
                    </div>
                </div>
            </div>

            <!-- Top Products Table (Matching Admin Table Style) -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-bold text-orange-800 mb-4">أكثر المنتجات تحقيقاً للأرباح</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-orange-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-orange-800 uppercase tracking-wider">
                                        المنتج</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-orange-800 uppercase tracking-wider">
                                        سعر الوحدة</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-bold text-orange-800 uppercase tracking-wider">
                                        الكمية المباعة</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-orange-800 uppercase tracking-wider">
                                        الأرباح المحققة</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($topProductsByRevenue as $product)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($product->image)
                                                        <img class="h-10 w-10 rounded-lg object-cover border"
                                                            src="{{ Storage::url($product->image) }}" alt="">
                                                    @else
                                                        <div
                                                            class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="mr-4">
                                                    <div class="text-sm font-bold text-gray-900">{{ $product->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ number_format($product->price, 2) }} ر.س
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $product->quantity_sold }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                                            {{ number_format($product->revenue, 2) }} ر.س
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                            لا توجد بيانات متاحة لهذه الفترة.
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

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Shared Options for consistency
            Chart.defaults.font.family = "'Cairo', sans-serif";

            // Sales Chart
            const ctxSales = document.getElementById('salesChart').getContext('2d');
            new Chart(ctxSales, {
                type: 'line',
                data: {
                    labels: @json($dailySales->pluck('date')),
                    datasets: [{
                        label: 'المبيعات (ر.س)',
                        data: @json($dailySales->pluck('total')),
                        borderColor: '#ea580c', // orange-600
                        backgroundColor: 'rgba(234, 88, 12, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#ea580c',
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
</x-vendor-layout>