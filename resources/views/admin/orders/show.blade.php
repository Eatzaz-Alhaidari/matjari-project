<x-admin-layout>
    <x-slot name="title">
        تفاصيل الطلب #{{ $order->order_number }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('admin.orders.index') }}"
                    class="inline-flex items-center text-brand-blue hover:text-brand-blue-700 font-bold transition">
                    <svg class="w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    العودة لقائمة الطلبات
                </a>

                <div class="flex space-x-2 space-x-reverse">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold {{ 
                        $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : (
        $order->status == 'delivered' ? 'bg-green-100 text-green-800' : (
            $order->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) 
                    }}">
                        حالة الطلب: {{ 
                            $order->status == 'pending' ? 'قيد الانتظار' : (
        $order->status == 'processing' ? 'جاري التجهيز' : (
            $order->status == 'shipped' ? 'تم الشحن' : (
                $order->status == 'delivered' ? 'تم التوصيل' : 'ملغي')))
                        }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Order Information -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-brand-blue-800 mb-4 border-b pb-2 flex items-center">
                                <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 118 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                منتجات الطلب
                            </h3>

                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            المنتج</th>
                                        <th
                                            class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            الكمية</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            السعر</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            الإجمالي</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-50">
                                    @php $subtotal = 0; @endphp
                                    @foreach($order->items as $item)
                                        @php $subtotal += $item->price * $item->quantity; @endphp
                                        <tr>
                                            <td class="px-4 py-4">
                                                <div class="flex items-center">
                                                    @if($item->product && $item->product->image)
                                                        <img class="h-10 w-10 rounded object-cover ml-3 border border-gray-100"
                                                            src="{{ asset('storage/' . $item->product->image) }}" alt="">
                                                    @else
                                                        <div
                                                            class="h-10 w-10 rounded bg-gray-100 flex items-center justify-center ml-3">
                                                            <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="text-sm font-bold text-gray-900">
                                                            {{ $item->product->name ?? 'منتج محذوف' }}
                                                        </div>
                                                        <div class="text-xs text-gray-500">{{ $item->variant_info ?? '' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-center text-sm font-medium text-gray-900">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="px-4 py-4 text-left text-sm text-gray-900">
                                                {{ number_format($item->price, 2) }} ر.ي
                                            </td>
                                            <td class="px-4 py-4 text-left text-sm font-bold text-brand-blue-800">
                                                {{ number_format($item->price * $item->quantity, 2) }} ر.ي
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-6 border-t pt-4 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">الإجمالي الفرعي:</span>
                                    <span class="font-medium">{{ number_format($subtotal, 2) }} ر.ي</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">الشحن:</span>
                                    <span class="font-medium text-green-600">مجاني</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold border-t pt-2">
                                    <span class="text-brand-blue-800">الإجمالي النهائي:</span>
                                    <span class="text-brand-blue-800">{{ number_format($order->total_amount, 2) }}
                                        ر.ي</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline / History -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-brand-blue-800 mb-4 border-b pb-2 flex items-center">
                                <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                سجل الطلب
                            </h3>

                            <div class="space-y-4">
                                <div class="flex pr-4 border-r-2 border-brand-blue-100 relative">
                                    <div class="absolute -right-1 top-0 w-2 h-2 bg-brand-blue rounded-full"></div>
                                    <div class="pr-6">
                                        <p class="text-sm font-bold text-gray-900">تم إنشاء الطلب</p>
                                        <p class="text-xs text-gray-500">{{ $order->created_at->format('Y-m-d H:i') }}
                                            ({{ $order->created_at->diffForHumans() }})</p>
                                    </div>
                                </div>

                                @if($order->problem_reason)
                                    <div class="flex pr-4 border-r-2 border-red-100 relative">
                                        <div class="absolute -right-1 top-0 w-2 h-2 bg-red-500 rounded-full animate-pulse">
                                        </div>
                                        <div class="pr-6">
                                            <p class="text-sm font-bold text-red-600">تم الإبلاغ عن مشكلة</p>
                                            <p
                                                class="text-sm bg-red-50 p-2 rounded border border-red-100 text-red-700 mt-1">
                                                {{ $order->problem_reason }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                <!-- Add more status updates here if you have a status_history table -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer & Store Info -->
                <div class="space-y-6">
                    <!-- Customer Card -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-brand-blue-800 mb-4 border-b pb-2 flex items-center">
                                <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                معلومات العميل
                            </h3>
                            <div class="flex items-center mb-4">
                                <div
                                    class="w-12 h-12 bg-brand-blue-50 rounded-full flex items-center justify-center text-brand-blue font-bold text-xl ml-3">
                                    {{ mb_substr($order->user->name ?? 'ز', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $order->user->name ?? 'زائر' }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->user->email ?? 'لا يوجد بريد' }}</p>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">رقم الهاتف:</span>
                                    <span class="font-medium">{{ $order->user->phone ?? '-' }}</span>
                                </div>
                                <div class="pt-2 border-t">
                                    <p class="text-gray-500 mb-1">عنوان الشحن:</p>
                                    <p class="font-medium text-gray-800">
                                        {{ $order->shipping_address ?? 'صنعاء، اليمن' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Store Card -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-brand-blue-800 mb-4 border-b pb-2 flex items-center">
                                <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                المتجر المسؤول
                            </h3>
                            <div class="flex items-center mb-4">
                                @if($order->store && $order->store->logo)
                                    <img src="{{ asset('storage/' . $order->store->logo) }}"
                                        class="w-12 h-12 rounded-lg object-cover ml-3" alt="">
                                @else
                                    <div
                                        class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center text-orange-600 font-bold ml-3">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-bold text-gray-900">{{ $order->store->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-500">البائع:
                                        {{ $order->store->vendor->name ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('admin.stores.show', $order->store_id) }}"
                                    class="text-xs font-bold text-brand-blue hover:underline">
                                    عرض ملف المتجر
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Shipment Management Card (Admin) -->
                    <div
                        class="bg-white overflow-hidden shadow-xl sm:rounded-xl border {{ $order->shipment ? 'border-brand-blue-100' : 'border-orange-100' }}">
                        <div class="p-6">
                            <h3
                                class="text-lg font-bold {{ $order->shipment ? 'text-brand-blue-800' : 'text-orange-800' }} mb-4 border-b pb-2 flex items-center">
                                <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                إدارة الشحن
                            </h3>

                            @if($order->shipment)
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">رقم التتبع:</span>
                                        <span
                                            class="text-sm font-mono font-bold text-brand-blue-800">{{ $order->shipment->tracking_number }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">شركة الشحن:</span>
                                        <span
                                            class="text-sm font-bold text-gray-800">{{ $order->shipment->shipping_company }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">الحالة:</span>
                                        <span
                                            class="px-2 py-0.5 rounded-full text-xs font-bold bg-brand-blue-50 text-brand-blue-800">
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
                                    <div class="pt-4 mt-2 border-t">
                                        <a href="{{ route('admin.shipping.index') }}"
                                            class="w-full inline-block text-center py-2 bg-brand-blue text-white text-xs font-bold rounded-lg hover:bg-brand-blue-700 transition">
                                            إدارة الشحنات
                                        </a>
                                    </div>
                                </div>
                            @elseif($order->shipping_city == 'صنعاء' || str_contains($order->shipping_address, 'صنعاء'))
                                <div class="text-center py-2">
                                    <p class="text-sm text-gray-600 mb-4">هذا الطلب في مدينة صنعاء ولا يوجد له شحنة حالياً.
                                    </p>
                                    <form action="{{ route('admin.shipping.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <button type="submit"
                                            class="w-full py-2 bg-orange-600 text-white text-xs font-bold rounded-lg hover:bg-orange-700 transition">
                                            إنشاء شحنة الآن (توصيل)
                                        </button>
                                    </form>
                                </div>
                            @else
                                <p class="text-xs text-gray-500 text-center">خارج نطاق تغطية شركة "توصيل" (صنعاء فقط).</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>