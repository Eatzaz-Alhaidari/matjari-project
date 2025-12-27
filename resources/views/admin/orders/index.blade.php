<x-admin-layout>
    <x-slot name="title">
        إدارة الطلبات
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <!-- Tabs -->
            <div class="bg-white border-b border-gray-200 mb-6 flex overflow-x-auto">
                <a href="{{ route('admin.orders.index', ['tab' => 'all']) }}"
                    class="px-6 py-4 font-bold text-sm hover:bg-gray-50 focus:outline-none border-b-2 {{ $tab == 'all' ? 'border-brand-blue text-brand-blue' : 'border-transparent text-gray-500' }}">
                    الكل
                </a>
                <a href="{{ route('admin.orders.index', ['tab' => 'pending']) }}"
                    class="px-6 py-4 font-bold text-sm hover:bg-gray-50 focus:outline-none border-b-2 {{ $tab == 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500' }}">
                    قيد الانتظار <span
                        class="bg-yellow-100 text-yellow-800 py-0.5 px-2 rounded-full text-xs mr-1">{{ $pendingCount }}</span>
                </a>
                <a href="{{ route('admin.orders.index', ['tab' => 'problem']) }}"
                    class="px-6 py-4 font-bold text-sm hover:bg-gray-50 focus:outline-none border-b-2 {{ $tab == 'problem' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500' }}">
                    طلبات عالقة (مشاكل) <span
                        class="bg-red-100 text-red-800 py-0.5 px-2 rounded-full text-xs mr-1">{{ $problemCount }}</span>
                </a>
                <a href="{{ route('admin.orders.index', ['tab' => 'delayed']) }}"
                    class="px-6 py-4 font-bold text-sm hover:bg-gray-50 focus:outline-none border-b-2 {{ $tab == 'delayed' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500' }}">
                    طلبات متأخرة <span
                        class="bg-orange-100 text-orange-800 py-0.5 px-2 rounded-full text-xs mr-1">{{ $delayedCount }}</span>
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        رقم الطلب</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        العميل / المتجر</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        تاريخ الطلب</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        الحالة</th>
                                    @if($tab == 'problem')
                                        <th
                                            class="px-6 py-3 text-right text-xs font-bold text-red-500 uppercase tracking-wider">
                                            سبب المشكلة</th>
                                    @endif
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        الاجمالي</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($orders as $order)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                                            #{{ $order->order_number }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $order->user->name ?? 'زائر' }}</div>
                                            <div class="text-xs text-gray-500 flex items-center">
                                                <svg class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                {{ $order->store->name ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->created_at->format('Y-m-d') }}
                                            <div class="text-xs">{{ $order->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($order->status == 'pending')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">قيد
                                                    الانتظار</span>
                                            @elseif($order->status == 'processing')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">جاري
                                                    التجهيز</span>
                                            @elseif($order->status == 'shipped')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">تم
                                                    الشحن</span>
                                            @elseif($order->status == 'delivered')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">تم
                                                    التوصيل</span>
                                            @elseif($order->status == 'cancelled')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">ملغي</span>
                                            @endif
                                        </td>

                                        @if($tab == 'problem')
                                            <td
                                                class="px-6 py-4 text-sm text-red-600 font-bold bg-red-50 border-r border-l border-red-100">
                                                ⚠ {{ $order->problem_reason }}
                                            </td>
                                        @endif

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            {{ number_format($order->total_amount, 2) }} ر.ي
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <a href="#" class="text-brand-blue hover:text-brand-blue-700 font-bold ml-3">عرض
                                                التفاصيل</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                                لا توجد طلبات في هذه القائمة حالياً.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $orders->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>