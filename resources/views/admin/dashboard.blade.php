<x-admin-layout>

    <x-slot name="title">
        لوحة التحكم الرئيسية
    </x-slot>

    <!-- 🏠 قسم الرئيسية: المخططات البيانية فقط -->
    <div x-show="activeTab === 'home'" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100">
        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-bold text-gray-800 mb-4">التصنيفات الأكثر طلبًا</h3>
                <div class="relative h-64 flex justify-center">
                    <canvas id="categoriesChart"></canvas>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-bold text-gray-800 mb-4">إحصائيات المبيعات (آخر 30 يوم)</h3>
                <div class="relative h-64">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- New Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-bold text-gray-800 mb-4">نمو المستخدمين (آخر 30 يوم)</h3>
                <div class="relative h-64">
                    <canvas id="growthChart"></canvas>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-bold text-gray-800 mb-4">حالات المتاجر</h3>
                <div class="relative h-64 flex justify-center">
                    <canvas id="vendorsStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- 🛒 إدارة العمليات -->
    <div x-show="activeTab === 'operations'" class="grid grid-cols-1 gap-6 md:grid-cols-3 lg:grid-cols-4" x-transition>
        <!-- إدارة الطلبات -->
        <a href="{{ route('admin.orders.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-cyan-50 transition-all duration-300 font-bold">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-cyan-100 rounded-xl">
                    <span class="text-2xl">📦</span>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الطلبات</h3>
                    <p class="text-sm text-cyan-600">{{ $ordersCount }} طلب</p>
                </div>
            </div>
        </a>
        <!-- إدارة المرتجعات -->
        <a href="{{ route('admin.returns.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-rose-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-rose-100 rounded-xl"><span class="text-2xl">🔄</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المرتجعات</h3>
                    <p class="text-sm text-rose-600">{{ $returnsCount }} طلب</p>
                </div>
            </div>
        </a>
        <!-- إدارة الشحن -->
        <a href="{{ route('admin.shipping.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-slate-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-slate-100 rounded-xl"><span class="text-2xl">🚚</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الشحن</h3>
                    <p class="text-sm text-slate-600">{{ $shippingCount }} شحنة</p>
                </div>
            </div>
        </a>
        <!-- إدارة الدفع -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-lime-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-lime-100 rounded-xl"><span class="text-2xl">💳</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الدفع</h3>
                    <p class="text-sm text-lime-600">{{ $paymentCount }} عملية</p>
                </div>
            </div>
        </a>
        <!-- إدارة المحافظ -->
        <a href="{{ route('admin.wallets.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-purple-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-purple-100 rounded-xl"><span class="text-2xl">💰</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المحافظ</h3>
                    <p class="text-sm text-purple-600">{{ number_format($walletTotalBalance, 2) }} ر.ي</p>
                </div>
            </div>
        </a>
        <!-- إدارة المخزون -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-teal-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-teal-100 rounded-xl"><span class="text-2xl">🏗️</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المخزون</h3>
                    <p class="text-sm text-teal-600">{{ $inventoryCount }} وحدة</p>
                </div>
            </div>
        </a>
    </div>

    <!-- 📦 إدارة المحتوى التجاري -->
    <div x-show="activeTab === 'content'" class="grid grid-cols-1 gap-6 md:grid-cols-3 lg:grid-cols-4" x-transition>
        <!-- إدارة المنتجات -->
        <a href="{{ route('admin.products.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-blue-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-blue-100 rounded-xl"><span class="text-2xl">🍕</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المنتجات</h3>
                    <p class="text-sm text-blue-600">{{ $productCount }} منتج</p>
                </div>
            </div>
        </a>
        <!-- إدارة التصنيفات -->
        <a href="{{ route('admin.categories.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-violet-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-violet-100 rounded-xl"><span class="text-2xl">📑</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة التصنيفات</h3>
                    <p class="text-sm text-violet-600">{{ $categoriesCount }} تصنيف</p>
                </div>
            </div>
        </a>
        <!-- إدارة العروض والإعلانات -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-yellow-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-yellow-100 rounded-xl"><span class="text-2xl">📢</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة العروض والإعلانات</h3>
                    <p class="text-sm text-yellow-600">{{ $advertisementCount }} إعلان</p>
                </div>
            </div>
        </a>
        <!-- كوبونات الخصم -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-amber-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-amber-100 rounded-xl"><span class="text-2xl">🎟️</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">كوبونات الخصم</h3>
                    <p class="text-sm text-amber-600">{{ $discountCount }} كوبون</p>
                </div>
            </div>
        </a>
        <!-- التقييمات -->
        <a href="{{ route('admin.reviews.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-yellow-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-yellow-100 rounded-xl"><span class="text-2xl">⭐</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">التقييمات</h3>
                    <p class="text-sm text-yellow-600">{{ $reviewCount }} تقييم</p>
                </div>
            </div>
        </a>
    </div>

    <!-- 🏪 إدارة الأطراف -->
    <div x-show="activeTab === 'parties'" class="grid grid-cols-1 gap-6 md:grid-cols-3 lg:grid-cols-4" x-transition>
        <!-- إدارة المتاجر -->
        <a href="{{ route('admin.stores.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-orange-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-orange-100 rounded-xl"><span class="text-2xl">🏪</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المتاجر</h3>
                    <p class="text-sm text-orange-600">{{ $activeStoresCount }} متجر نشط</p>
                </div>
            </div>
        </a>
        <!-- إدارة البائعين -->
        <a href="{{ route('admin.vendors.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-indigo-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-indigo-100 rounded-xl"><span class="text-2xl">👔</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة البائعين</h3>
                    <p class="text-sm text-indigo-600">{{ $vendorCount }} بائع</p>
                </div>
            </div>
        </a>
        <!-- إدارة العملاء -->
        <a href="{{ route('admin.users.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-green-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-green-100 rounded-xl"><span class="text-2xl">👥</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة العملاء</h3>
                    <p class="text-sm text-green-600">{{ $customerCount }} عميل</p>
                </div>
            </div>
        </a>
    </div>

    <!-- 📊 التحليل والتقارير -->
    <div x-show="activeTab === 'reports'" class="grid grid-cols-1 gap-6 md:grid-cols-3 lg:grid-cols-4" x-transition>
        <!-- التقارير المالية -->
        <a href="{{ route('admin.reports.financial') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-emerald-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-emerald-100 rounded-xl"><span class="text-2xl">📈</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">التقارير المالية</h3>
                    <p class="text-sm text-emerald-600">{{ $financialReportsCount }} تقرير</p>
                </div>
            </div>
        </a>
        <!-- تحليل العملاء -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-sky-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-sky-100 rounded-xl"><span class="text-2xl">🔬</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">تحليل العملاء</h3>
                    <p class="text-sm text-sky-600">{{ $newCustomersCount }} عميل جديد</p>
                </div>
            </div>
        </a>
    </div>

    <!-- 🎧 الدعم والمتابعة -->
    <div x-show="activeTab === 'support'" class="grid grid-cols-1 gap-6 md:grid-cols-3 lg:grid-cols-4" x-transition>
        <!-- إدارة الشكاوى -->
        <a href="{{ route('admin.complaints.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-red-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-red-100 rounded-xl"><span class="text-2xl">😠</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الشكاوى</h3>
                    <p class="text-sm text-red-600">{{ $complaintOpenCount }} شكوى نشطة</p>
                </div>
            </div>
        </a>
        <!-- الدعم الفني -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-fuchsia-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-fuchsia-100 rounded-xl"><span class="text-2xl">🛠️</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">الدعم الفني</h3>
                    <p class="text-sm text-fuchsia-600">0 تذكرة</p>
                </div>
            </div>
        </a>
    </div>

    <!-- 🔔 النظام والإعدادات -->
    <div x-show="activeTab === 'settings'" class="grid grid-cols-1 gap-6 md:grid-cols-3 lg:grid-cols-4" x-transition>
        <!-- إدارة الإشعارات -->
        <a href="{{ route('admin.notifications.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-pink-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-pink-100 rounded-xl"><span class="text-2xl">🔔</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الإشعارات</h3>
                    <p class="text-sm text-pink-600">{{ $notificationCount }} إشعار</p>
                </div>
            </div>
        </a>
        <!-- إعدادات المنصة -->
        <a href="{{ route('admin.settings.index') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-gray-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-gray-100 rounded-xl"><span class="text-2xl">⚙️</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إعدادات المنصة</h3>
                    <p class="text-sm text-gray-600">عام</p>
                </div>
            </div>
        </a>
        <!-- سجل الأنشطة -->
        <a href="{{ route('admin.coming-soon') }}"
            class="block p-6 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-slate-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-4 bg-slate-100 rounded-xl"><span class="text-2xl">📜</span></div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">سجل الأنشطة</h3>
                    <p class="text-sm text-slate-600">{{ $activityLogCount }} عملية</p>
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

            // --- NEW CHARTS ---

            // Users Growth Chart
            const growthCtx = document.getElementById('growthChart').getContext('2d');
            new Chart(growthCtx, {
                type: 'line',
                data: {
                    labels: @json($growthLabels),
                    datasets: [
                        {
                            label: 'المستخدمين الجدد',
                            data: @json($userGrowthValues),
                            borderColor: '#8B5CF6', // Purple
                            backgroundColor: 'rgba(139, 92, 246, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'البائعين الجدد',
                            data: @json($vendorGrowthValues),
                            borderColor: '#F97316', // Orange
                            backgroundColor: 'rgba(249, 115, 22, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: { usePointStyle: true }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { display: true, drawBorder: false }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // Vendors Status Chart
            const vendorsStatusCtx = document.getElementById('vendorsStatusChart').getContext('2d');
            new Chart(vendorsStatusCtx, {
                type: 'pie',
                data: {
                    labels: ['متاجر مفعلة', 'متاجر معلقة', 'متاجر محظورة'],
                    datasets: [{
                        data: [@json($activeVendors), @json($pendingVendors), @json($bannedVendors)],
                        backgroundColor: [
                            '#10B981', // Green (Active)
                            '#F59E0B', // Yellow (Pending)
                            '#EF4444'  // Red (Banned)
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