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
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-brand-blue-800">قائمة الطلبات</h2>
                    </div>

                    <!-- Search Form -->
                    <div class="mb-6">
                        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex items-center">
                            <input type="hidden" name="tab" value="{{ $tab }}">
                            <input type="text" name="search" placeholder="ابحث برقم الطلب أو اسم العميل..."
                                class="w-full md:w-1/3 border-gray-300 rounded-lg shadow-sm"
                                value="{{ request('search') }}">
                            <button type="submit"
                                class="mr-3 px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow-md hover:bg-brand-blue-700">بحث</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        رقم الطلب</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        العميل / المتجر</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        تاريخ الطلب</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        المندوب</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الحالة</th>
                                    @if($tab == 'problem')
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-bold text-red-600 uppercase tracking-wider">
                                            سبب المشكلة</th>
                                    @endif
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الاجمالي</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($orders as $order)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                                            #{{ $order->order_number }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-gray-900">
                                                {{ $order->user->name ?? 'زائر' }}</div>
                                            <div class="text-xs text-gray-500 flex items-center mt-1">
                                                <svg class="w-3.5 h-3.5 ml-1 text-brand-blue" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                {{ $order->store->name ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 font-medium">{{ $order->created_at->format('Y-m-d') }}</div>
                                            <div class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($order->driver)
                                                <div class="text-sm font-bold text-gray-900">{{ $order->driver->name }}</div>
                                                <div class="text-xs text-gray-500">#{{ $order->driver_id }}</div>
                                            @else
                                                <span class="text-xs text-gray-400 italic">غير مسند</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $colorMap = [
                                                    'yellow' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                    'blue' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                    'purple' => 'bg-purple-100 text-purple-800 border-purple-200',
                                                    'indigo' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                    'green' => 'bg-green-100 text-green-800 border-green-200',
                                                    'red' => 'bg-red-100 text-red-800 border-red-200',
                                                    'gray' => 'bg-gray-100 text-gray-800 border-gray-200',
                                                ];
                                                $colorClass = $colorMap[$order->status_color] ?? $colorMap['gray'];
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $colorClass }}">
                                                {{ $order->status_text }}
                                            </span>
                                        </td>

                                        @if($tab == 'problem')
                                            <td
                                                class="px-6 py-4 text-sm text-red-600 font-bold bg-red-50 border-r border-l border-red-100">
                                                ⚠ {{ $order->problem_reason }}
                                            </td>
                                        @endif

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-brand-blue-800">
                                                {{ number_format($order->total_amount, 2) }} <span class="text-xs text-gray-500">ر.ي</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center">
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                    class="inline-flex items-center px-3 py-1 bg-brand-blue-50 text-brand-blue-800 text-xs font-bold rounded-full hover:bg-brand-blue-100 transition-colors">
                                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    عرض التفاصيل
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $tab == 'problem' ? 8 : 7 }}" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                    </path>
                                                </svg>
                                                <p class="text-lg font-medium text-gray-900">لا توجد طلبات في هذه القائمة حالياً</p>
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