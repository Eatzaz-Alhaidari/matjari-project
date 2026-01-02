<x-vendor-layout>
    <x-slot name="title">
        تفاصيل الطلب: {{ $order->order_number }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-black">تفاصيل الطلب</h2>
                        <a href="{{ route('vendor.orders.index') }}"
                            class="px-4 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-brand-orange-700">
                            العودة للقائمة
                        </a>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- معلومات الطلب الأساسية -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- معلومات الطلب -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">معلومات الطلب</h3>
                                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">رقم الطلب:</span>
                                        <span class="text-gray-900">{{ $order->order_number }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">تاريخ الطلب:</span>
                                        <span class="text-gray-900">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">المبلغ الإجمالي:</span>
                                        <span class="text-green-600 font-semibold">{{ number_format($order->total_amount, 2) }}                                             ريال يمني</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">حالة الدفع:</span>
                                        <span class="text-gray-900">{{ $order->payment_status === 'paid' ? 'مدفوع' : 'غير مدفوع' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">طريقة الدفع:</span>
                                        <span class="text-gray-900">
                                            @switch($order->payment_method)
                                                @case('cash_on_delivery')
                                                    الدفع عند التسليم
                                                    @break
                                                @case('credit_card')
                                                    بطاقة ائتمان
                                                    @break
                                                @case('bank_transfer')
                                                    تحويل بنكي
                                                    @break
                                            @endswitch
                                        </span>
                                    </div>
                                    @if($order->shipped_at)
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">تاريخ الشحن:</span>
                                        <span class="text-gray-900">{{ $order->shipped_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    @endif
                                    @if($order->delivered_at)
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">تاريخ التسليم:</span>
                                        <span class="text-gray-900">{{ $order->delivered_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- منتجات الطلب -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">منتجات الطلب</h3>
                                <div class="bg-white border rounded-lg overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    المنتج</th>
                                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    الكمية</th>
                                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    السعر</th>
                                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    الإجمالي</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($order->orderItems as $item)
                                            <tr>
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center">
                                                        @if($item->product->image)
                                                            <div class="flex-shrink-0 w-10 h-10 ml-3">
                                                                <img class="w-10 h-10 rounded-full object-cover"
                                                                    src="{{ asset('storage/' . $item->product->image) }}"
                                                                    alt="{{ $item->product->name }}">
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                                            @if($item->product->brand)
                                                                <div class="text-sm text-gray-500">{{ $item->product->brand }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-900">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-900">
                                                    {{ number_format($item->price, 2) }} ر.ي
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-900">
                                                    {{ number_format($item->total, 2) }} ر.ي
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- ملاحظات -->
                            @if($order->notes)
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">ملاحظات</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-700">{{ $order->notes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- معلومات العميل وتحديث الحالة -->
                        <div class="space-y-6">
                            <!-- معلومات العميل -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">معلومات العميل</h3>
                                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                    <div>
                                        <span class="font-medium text-gray-700">الاسم:</span>
                                        <span class="text-gray-900">{{ $order->user->name }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">البريد الإلكتروني:</span>
                                        <span class="text-gray-900">{{ $order->user->email }}</span>
                                    </div>
                                    @if($order->user->phone)
                                    <div>
                                        <span class="font-medium text-gray-700">الهاتف:</span>
                                        <span class="text-gray-900">{{ $order->user->phone }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- عنوان الشحن -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">عنوان الشحن</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-700 whitespace-pre-line">{{ $order->shipping_address }}</p>
                                </div>
                            </div>

                            <!-- معلومات الشحن -->
                            @if($order->shipment)
                            <div>
                                <h3 class="text-lg font-semibold text-brand-blue-800 mb-4">معلومات الشحن (توصيل)</h3>
                                <div class="bg-brand-blue-50 border border-brand-blue-100 rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm font-bold text-gray-700">رقم التتبع:</span>
                                        <span class="text-sm font-mono font-bold text-brand-blue-800">{{ $order->shipment->tracking_number }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-bold text-gray-700">الحالة:</span>
                                        <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-white text-brand-blue-800 border border-brand-blue-200">
                                            @php
                                                $shipmentStatuses = [
                                                    'pending' => 'قيد التجهيز',
                                                    'picked_up' => 'تم الاستلام من البائع',
                                                    'in_transit' => 'في الطريق',
                                                    'delivered' => 'تم التسليم',
                                                    'failed' => 'فشل التسليم',
                                                ];
                                            @endphp
                                            {{ $shipmentStatuses[$order->shipment->status] ?? $order->shipment->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- تحديث حالة الطلب -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">تحديث حالة الطلب</h3>
                                <form action="{{ route('vendor.orders.update', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="space-y-4">
                                        <div>
                                            <label for="status" class="block text-sm font-medium text-gray-700">الحالة الحالية</label>
                                            <span class="inline-flex px-2 py-1 text-xs rounded-full font-semibold
                                                bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800">
                                                {{ $order->status_text }}
                                            </span>
                                        </div>

                                        <div>
                                            <label for="status" class="block text-sm font-medium text-gray-700">تحديث الحالة</label>
                                            <select name="status" id="status"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-orange focus:border-brand-orange">
                                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>في الانتظار</option>
                                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>تم التسليم</option>
                                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                            </select>
                                        </div>

                                        <button type="submit"
                                            class="w-full px-4 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-brand-orange-700 transition-colors">
                                            تحديث الحالة
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>