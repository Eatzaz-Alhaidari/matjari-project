<x-vendor-layout>
    <x-slot name="title">
        معلومات الشحن (توصيل)
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">شحنات طلباتي</h2>
                    </div>

                    <div class="bg-blue-50 border-r-4 border-blue-500 p-4 mb-6 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="mr-3">
                                <p class="text-sm text-blue-700">
                                    هذه القائمة تعرض حالة الشحن للطلبات الخاصة بمتجرك التي يتم شحنها عبر شركة "توصيل".
                                    <br>
                                    يرجى ملاحظة أن تحديث حالة الشحن يتم حصراً من قبل إدارة المنصة.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-brand-orange-50">
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">رقم التتبع</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">رقم الطلب</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">العميل</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">تاريخ الشحن</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">الحالة</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-brand-orange-800 uppercase tracking-wider">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($shippings as $shipping)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-brand-orange-800 font-mono">{{ $shipping->tracking_number }}</div>
                                            <div class="text-xs text-gray-400">{{ $shipping->shipping_company }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-gray-900">#{{ $shipping->order->order_number }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $shipping->order->user->name ?? 'زائر' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $shipping->created_at->format('Y-m-d H:i') }}
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
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$shipping->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $statusTexts[$shipping->status] ?? $shipping->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <a href="{{ route('vendor.orders.show', $shipping->order->id) }}" class="px-2 py-1 text-xs rounded-full font-semibold bg-gray-100 text-gray-800 hover:bg-gray-200 transition-colors">
                                                عرض الطلب
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <p class="text-lg font-medium text-gray-900">لا توجد شحنات نشطة حالياً</p>
                                                <p class="text-sm text-gray-500">
                                                    الشحنات ستظهر هنا بمجرد أن يقوم الأدمن بإنشائها للطلبات.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-8 border-t border-gray-100 pt-4">
                        {{ $shippings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>
