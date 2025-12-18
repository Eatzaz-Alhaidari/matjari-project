<x-vendor-layout>
    <x-slot name="title">
        إدارة المبيعات
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 px-4 py-2 bg-red-100 border border-red-200 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Date Range Filter -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">فلترة المبيعات</h2>
                    <form action="{{ route('vendor.sales.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">من تاريخ</label>
                            <input type="date" id="start_date" name="start_date"
                                value="{{ $startDate }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-orange focus:ring-brand-orange">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">إلى تاريخ</label>
                            <input type="date" id="end_date" name="end_date"
                                value="{{ $endDate }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-orange focus:ring-brand-orange">
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full px-4 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-brand-orange-700 transition-colors">
                                تطبيق الفلترة
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistics Cards -->
            @if($stats['total_orders'] > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white border-r-4 border-green-500 rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 font-medium mb-1">إجمالي المبيعات</p>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_sales'], 2) }}                                             ر.ي</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-full">
                                <svg class="w-8 h-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border-r-4 border-blue-500 rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 font-medium mb-1">إجمالي الطلبات</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_orders'] }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-full">
                                <svg class="w-8 h-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border-r-4 border-gray-500 rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 font-medium mb-1">الطلبات المكتملة</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $stats['completed_orders'] }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-full">
                                <svg class="w-8 h-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border-r-4 border-yellow-500 rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 font-medium mb-1">الطلبات المعلقة</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $stats['pending_orders'] }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-full">
                                <svg class="w-8 h-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white border-r-4 border-gray-400 rounded-lg shadow-md p-6 col-span-full">
                        <div class="flex items-center justify-center">
                            <div class="text-center">
                                <div class="flex justify-center mb-4">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <h3 class="text-base font-semibold text-gray-900 mb-2">لا توجد بيانات مبيعات</h3>
                                <p class="text-sm text-gray-500">لم يتم تسجيل أي طلبات في هذه الفترة. سيتم عرض الإحصائيات هنا عند وجود مبيعات.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Charts and Tables Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 mt-8">

                <!-- Monthly Sales Chart -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-base font-bold text-gray-800">المبيعات الشهرية</h3>
                    </div>
                    <div class="p-4">
                        <div class="h-[200px] w-full">
                            <canvas id="monthlySalesChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Sales by Status Chart -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-base font-bold text-gray-800">توزيع الطلبات حسب الحالة</h3>
                    </div>
                    <div class="p-4">
                        <div class="h-[200px] w-full">
                            <canvas id="salesStatusChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Top Selling Products -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800">أفضل المنتجات مبيعاً</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @forelse($topProducts as $index => $product)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center flex-1">
                                        <span class="text-lg font-bold text-gray-400 mr-4 w-6">#{{ $index + 1 }}</span>
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover ml-3">
                                        @endif
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900">{{ $product->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ number_format($product->price, 2) }} ر.ي</p>
                                        </div>
                                    </div>
                                    <div class="text-left">
                                        <span class="text-lg font-bold text-gray-700">{{ $product->sold_quantity }}</span>
                                        <p class="text-xs text-gray-500">قطعة مباعة</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-gray-500">لا توجد مبيعات في هذه الفترة</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800">أحدث الطلبات</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @forelse($recentOrders as $order)
                                <a href="{{ route('vendor.orders.show', $order->id) }}" class="block">
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="font-semibold text-gray-900">طلب #{{ $order->order_number ?? $order->id }}</h4>
                                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                                    @if($order->status === 'delivered') bg-green-100 text-green-800
                                                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ $order->status_text }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600">{{ $order->user->name ?? 'عميل' }}</p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $order->created_at->diffForHumans() }}</p>
                                        </div>
                                        <div class="text-left mr-4">
                                            <span class="text-lg font-bold text-gray-800">{{ number_format($order->total_amount, 2) }} ر.ي</span>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-gray-500">لا توجد طلبات حديثة</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export Button -->
            <div class="mt-6 flex justify-center">
                <a href="{{ route('vendor.sales.export', request()->query()) }}"
                    class="inline-flex items-center px-6 py-3 bg-gray-800 text-white font-semibold rounded-lg shadow-md hover:bg-gray-900 transition-colors">
                    <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    تصدير التقرير
                </a>
            </div>
        </div>
    </div>

    <!-- Charts Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Monthly Sales Chart
        const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
        const monthlySalesData = @json($monthlySales);

        new Chart(monthlySalesCtx, {
            type: 'line',
            data: {
                labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
                datasets: [{
                    label: 'المبيعات (ريال)',
                    data: Object.values(monthlySalesData),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + ' ر.ي';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Sales by Status Chart
        const salesStatusCtx = document.getElementById('salesStatusChart').getContext('2d');
        const salesStatusData = @json($salesByStatus);

        const statusLabels = {
            'pending': 'معلق',
            'processing': 'قيد المعالجة',
            'shipped': 'مُشحون',
            'delivered': 'مُسلم',
            'cancelled': 'ملغي'
        };

        const statusColors = {
            'pending': '#fbbf24',
            'processing': '#3b82f6',
            'shipped': '#8b5cf6',
            'delivered': '#10b981',
            'cancelled': '#ef4444'
        };

        new Chart(salesStatusCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(salesStatusData).map(key => statusLabels[key] || key),
                datasets: [{
                    data: Object.values(salesStatusData),
                    backgroundColor: Object.keys(salesStatusData).map(key => statusColors[key] || '#6b7280'),
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 10,
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-vendor-layout>