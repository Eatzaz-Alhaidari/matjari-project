<x-vendor-layout>
    <x-slot name="title">
        إدارة الطلبات
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

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-black">قائمة الطلبات</h2>
                    </div>

                    <!-- Filters -->
                    <div class="mb-6 flex flex-col md:flex-row gap-4">
                        <form action="{{ route('vendor.orders.index') }}" method="GET" class="flex items-center gap-4">
                            <input type="text" name="search" placeholder="ابحث برقم الطلب أو اسم العميل..."
                                class="w-full md:w-1/3 border-gray-300 rounded-lg shadow-sm"
                                value="{{ request('search') }}">
                            <select name="status" class="border-gray-300 rounded-lg shadow-sm">
                                <option value="">جميع الحالات</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>في
                                    الانتظار</option>
                                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>قيد
                                    المعالجة</option>
                                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>تم الشحن
                                </option>
                                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>تم
                                    التسليم</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>ملغي
                                </option>
                            </select>
                            <button type="submit"
                                class="px-4 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-brand-orange-700">بحث</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto bg-white">
                        <table class="min-w-full">
                            <thead class="bg-brand-orange-50">
                                <tr>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        رقم الطلب</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        العميل</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        المبلغ الإجمالي</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        الحالة</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        تاريخ الطلب</th>
                                    <th
                                        class="px-5 py-3 text-center text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($orders as $order)
                                    <tr class="hover:bg-gray-50 cursor-pointer"
                                        onclick="window.location.href='{{ route('vendor.orders.show', $order->id) }}'">
                                        <td class="px-5 py-4 text-sm font-medium text-gray-900">
                                            {{ $order->order_number }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            <div>
                                                <div class="font-medium">{{ $order->user->name }}</div>
                                                <div class="text-gray-500">{{ $order->user->email }}</div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            {{ number_format($order->total_amount, 2) }} ر.ي
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full font-semibold
                                                                bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800">
                                                {{ $order->status_text }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-500">
                                            {{ $order->created_at->format('Y-m-d H:i') }}
                                        </td>
                                        <td class="px-5 py-4 text-center text-sm font-medium"
                                            onclick="event.stopPropagation()">
                                            <div class="flex items-center justify-center space-x-2 space-x-reverse">
                                                <a href="{{ route('vendor.orders.show', $order->id) }}"
                                                    class="px-2 py-1 text-xs rounded-full font-semibold bg-gray-100 text-gray-800 hover:bg-gray-200"
                                                    title="عرض التفاصيل">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">لا توجد طلبات حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>