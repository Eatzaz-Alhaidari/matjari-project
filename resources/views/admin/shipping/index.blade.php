<x-admin-layout>
    <x-slot name="title">
        إدارة شحن مدينة صنعاء (شركة توصيل)
    </x-slot>

    <div class="py-6" x-data="{ openStatusModal: false, activeShipment: null, openCreateModal: false }">
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Shipments Table -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-xl font-bold text-brand-blue-800">قائمة الشحنات النشطة</h2>
                            </div>

                            <div class="overflow-x-auto rounded-lg border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-brand-blue-50">
                                        <tr>
                                            <th class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">رقم التتبع</th>
                                            <th class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">الطلب</th>
                                            <th class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">العميل</th>
                                            <th class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">الحالة</th>
                                            <th class="px-6 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">تحديث</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($shippings as $shipping)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-bold text-brand-blue-800">{{ $shipping->tracking_number }}</div>
                                                    <div class="text-xs text-gray-400">ID: {{ $shipping->shipment_id }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-bold text-gray-900">#{{ $shipping->order->order_number }}</div>
                                                    <div class="text-xs text-gray-500">{{ $shipping->order->store->name ?? '-' }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $shipping->order->user->name ?? 'زائر' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @php
                                                        $statusColors = [
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'picked_up' => 'bg-blue-100 text-blue-800',
                                                            'in_transit' => 'bg-indigo-100 text-indigo-800',
                                                            'delivered' => 'bg-green-100 text-green-800',
                                                            'failed' => 'bg-red-100 text-red-800',
                                                        ];
                                                        $statusTexts = [
                                                            'pending' => 'قيد التجهيز',
                                                            'picked_up' => 'تم الاستلام',
                                                            'in_transit' => 'في الطريق',
                                                            'delivered' => 'تم التسليم',
                                                            'failed' => 'فشل التسليم',
                                                        ];
                                                    @endphp
                                                    <span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full {{ $statusColors[$shipping->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                        {{ $statusTexts[$shipping->status] ?? $shipping->status }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                    <button @click="activeShipment = {{ $shipping->id }}; openStatusModal = true" 
                                                        class="text-brand-blue hover:text-brand-blue-800 bg-brand-blue-50 p-2 rounded-full transition-colors">
                                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                                    لا توجد شحنات نشطة حالياً.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Orders Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-orange-100">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-orange-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                طلبات بانتظار الشحن (صنعاء)
                            </h3>
                            
                            <div class="space-y-4">
                                @forelse ($pendingOrders as $order)
                                    <div class="p-4 bg-orange-50 rounded-xl border border-orange-100 hover:shadow-md transition">
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="font-bold text-gray-900">#{{ $order->order_number }}</span>
                                            <span class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-3">{{ $order->user->name ?? 'زائر' }} - {{ $order->shipping_address }}</p>
                                        
                                        <form action="{{ route('admin.shipping.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <button type="submit" class="w-full py-2 bg-brand-blue text-white text-xs font-bold rounded-lg hover:bg-brand-blue-700 transition">
                                                إنشاء شحنة وتوليد تتبع
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-400 text-sm py-4">لا توجد طلبات جديدة للشحن في صنعاء.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Update Modal -->
        <div x-show="openStatusModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="openStatusModal = false">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form :action="'{{ url('admin/shipping') }}/' + activeShipment + '/update-status'" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-bold text-brand-blue-800 mb-4 border-b pb-2">تحديث حالة الشحنة</h3>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-2">الحالة الحالية</label>
                                <select name="status" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                                    <option value="pending">قيد التجهيز</option>
                                    <option value="picked_up">تم الاستلام من البائع</option>
                                    <option value="in_transit">في الطريق (قيد التوصيل)</option>
                                    <option value="delivered">تم التسليم بنجاح</option>
                                    <option value="failed">فشل التسليم</option>
                                </select>
                            </div>

                            <div class="bg-blue-50 p-4 rounded-lg flex items-start">
                                <svg class="w-5 h-5 text-blue-500 ml-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-xs text-blue-700">عند تحويل الحالة إلى "تم التسليم"، سيتم تحديث الطلب المرتبط تلقائياً إلى "تم التوصيل".</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse space-x-2 space-x-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand-blue text-base font-bold text-white hover:bg-brand-blue-700 focus:outline-none sm:w-auto sm:text-sm transition">حفظ التعديلات</button>
                            <button type="button" @click="openStatusModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm transition">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>