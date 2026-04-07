<x-vendor-layout>
    <x-slot name="title">
        إدارة المخازن
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

            <!-- إحصائيات المخزون -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m0 10l8 4m-8-4v--8 4-8-4" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mr-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">إجمالي المنتجات</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['total_products'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mr-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">نفد المخزون</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['out_of_stock'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mr-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">مخزون منخفض</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['low_stock'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-orange-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m0 10l8 4m-8-4v--8 4-8-4" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mr-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">مخزون متوسط</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['medium_stock'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mr-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">مخزون جيد</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['good_stock'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-black">إدارة المخزون</h2>
                        <div class="flex flex-col items-end">
                            <a href="{{ route('vendor.warehouse.import') }}"
                                class="px-5 py-2.5 bg-brand-orange text-white font-bold rounded-xl shadow-lg shadow-brand-orange/20 hover:bg-brand-orange-700 transition-all flex items-center">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                استيراد المنتجات (CSV)
                            </a>
                            <p class="text-[10px] text-gray-400 mt-1 flex items-center">
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                يرجى قراءة تعليمات الرفع داخل صفحة الاستيراد
                            </p>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="mb-6 flex flex-col md:flex-row gap-4">
                        <form action="{{ route('vendor.warehouse.index') }}" method="GET"
                            class="flex items-center gap-4">
                            <input type="text" name="search" placeholder="ابحث باسم المنتج أو الماركة..."
                                class="w-full md:w-1/3 border-gray-300 rounded-lg shadow-sm"
                                value="{{ request('search') }}">
                            <select name="stock_status" class="border-gray-300 rounded-lg shadow-sm">
                                <option value="">جميع المنتجات</option>
                                <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>نفد المخزون</option>
                                <option value="low_stock" {{ request('stock_status') === 'low_stock' ? 'selected' : '' }}>
                                    مخزون منخفض (≤5)</option>
                                <option value="medium_stock" {{ request('stock_status') === 'medium_stock' ? 'selected' : '' }}>مخزون متوسط (6-20)</option>
                                <option value="good_stock" {{ request('stock_status') === 'good_stock' ? 'selected' : '' }}>مخزون جيد (>20)</option>
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
                                        المنتج</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        الماركة</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        السعر</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        المخزون الحالي</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        حالة المخزون</th>
                                    <th
                                        class="px-5 py-3 text-center text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        تحديث المخزون</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($products as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4">
                                            <div class="flex items-center">
                                                @if($product->image)
                                                    <div class="flex-shrink-0 w-10 h-10 ml-3">
                                                        <img class="w-10 h-10 rounded-full object-cover"
                                                            src="{{ asset('storage/' . $product->image) }}"
                                                            alt="{{ $product->name }}">
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $product->category->name ?? 'غير مصنف' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            {{ $product->brand ?? 'غير محدد' }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            {{ number_format($product->price, 2) }} ر.ي
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            <span
                                                class="font-semibold {{ $product->stock <= 5 ? 'text-red-600' : 'text-gray-900' }}">
                                                {{ $product->stock }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            @if($product->stock == 0)
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full font-semibold bg-red-100 text-red-800">
                                                    نفد المخزون
                                                </span>
                                            @elseif($product->stock <= 5)
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full font-semibold bg-yellow-100 text-yellow-800">
                                                    منخفض
                                                </span>
                                            @elseif($product->stock <= 20)
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full font-semibold bg-orange-100 text-orange-800">
                                                    متوسط
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full font-semibold bg-green-100 text-green-800">
                                                    جيد
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-center text-sm font-medium">
                                            <form action="{{ route('vendor.warehouse.updateStock', $product->id) }}"
                                                method="POST" class="inline-flex items-center">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="stock" value="{{ $product->stock }}" min="0"
                                                    class="w-20 px-2 py-1 text-sm border border-gray-300 rounded-l-md focus:ring-brand-orange focus:border-brand-orange">
                                                <button type="submit"
                                                    class="px-3 py-1 bg-brand-orange text-white text-sm font-semibold rounded-r-md hover:bg-brand-orange-700 transition-colors">
                                                    تحديث
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">لا توجد منتجات في
                                            المخزن.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>