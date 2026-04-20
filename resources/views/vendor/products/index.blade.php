<x-vendor-layout>

    <x-slot name="title">
        إدارة المنتجات
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">قائمة منتجاتي</h2>
                        <a href="{{ route('vendor.products.create') }}"
                            class="px-4 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-brand-orange-700 transition-colors">
                            + إضافة منتج جديد
                        </a>
                    </div>
                    <!-- Search Form -->
                    <div class="mb-6">
                        <form action="{{ route('vendor.products.index') }}" method="GET" class="flex gap-2">
                            <div class="relative flex-grow max-w-lg">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="search" placeholder="ابحث باسم المنتج أو التصنيف..."
                                    class="w-full pr-10 border-gray-300 rounded-lg shadow-sm focus:ring-brand-orange focus:border-brand-orange"
                                    value="{{ request('search') }}">
                            </div>
                            <button type="submit"
                                class="px-5 py-2 bg-brand-orange text-white font-medium rounded-lg shadow hover:bg-brand-orange-700 transition-colors">
                                بحث
                            </button>
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-brand-orange-50 text-right">
                                <tr>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider whitespace-nowrap">صورة</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider whitespace-nowrap">المنتج</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider whitespace-nowrap">التصنيف</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider whitespace-nowrap">الماركة</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider whitespace-nowrap">الأحجام/الألوان</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider whitespace-nowrap">السعر</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider whitespace-nowrap">الخصم</th>
                                    <th scope="col" class="px-5 py-3 text-center text-xs font-bold text-brand-orange-800 uppercase tracking-wider whitespace-nowrap">المخزون</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider whitespace-nowrap">المنطقة</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider whitespace-nowrap">الضمان</th>
                                    <th scope="col" class="px-5 py-3 text-center text-xs font-bold text-brand-orange-800 uppercase tracking-wider whitespace-nowrap">الحالة</th>
                                    <th scope="col" class="px-5 py-3 text-center text-xs font-bold text-brand-orange-800 uppercase tracking-wider whitespace-nowrap">مراجعة AI</th>
                                    <th scope="col" class="px-5 py-3 text-center text-xs font-bold text-brand-orange-800 uppercase tracking-wider whitespace-nowrap">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($products as $product)
                                    <tr class="hover:bg-gray-50 transition-colors cursor-pointer" onclick="window.location.href='{{ route('vendor.products.show', $product->id) }}'">
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            @if($product->image)
                                                <img class="h-10 w-10 rounded-lg object-cover border border-gray-100 shadow-sm"
                                                    src="{{ asset('storage/' . $product->image) }}"
                                                    alt="{{ $product->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-lg bg-gray-50 flex items-center justify-center border border-gray-100">
                                                    <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 min-w-[200px]">
                                            <div class="text-sm font-medium text-gray-900 mb-0.5">{{ $product->name }}</div>
                                            <div class="text-[10px] text-gray-400 italic max-w-[180px] truncate">{{ $product->description }}</div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-xs text-brand-orange-600 font-medium bg-orange-50 px-2 py-0.5 rounded border border-orange-100 inline-block">{{ $product->category->name ?? 'بدون قسم' }}</div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-xs text-amber-700 font-bold bg-amber-50 px-2 py-0.5 rounded border border-amber-100 inline-block">{{ $product->getRelationValue('brand')->name ?? '-' }}</div>
                                        </td>
                                        <td class="px-5 py-4 min-w-[150px]">
                                            <!-- Sizes Row -->
                                            <div class="flex flex-nowrap gap-1 mb-2 overflow-x-auto no-scrollbar pb-1">
                                                @foreach($product->sizes as $size)
                                                    <span class="px-2 py-1 bg-gray-50 text-gray-600 text-[10px] font-bold rounded-lg border border-gray-100 shadow-sm whitespace-nowrap">{{ $size->name }}</span>
                                                @endforeach
                                            </div>
                                            <!-- Colors Row -->
                                            <div class="flex flex-nowrap gap-1.5 overflow-x-auto no-scrollbar">
                                                @foreach($product->colors as $color)
                                                    @if($color->image_path)
                                                        <img src="{{ Storage::url($color->image_path) }}" class="h-5 w-5 rounded-full border border-white shadow-sm object-cover flex-shrink-0" title="{{ $color->name }}">
                                                    @else
                                                        <div class="h-5 w-5 rounded-full border border-white shadow-sm bg-gray-200 flex items-center justify-center text-[7px] text-gray-500 font-bold flex-shrink-0" title="{{ $color->name }}">
                                                            {{ mb_substr($color->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm">
                                            <div class="font-bold text-gray-900">{{ number_format($product->price, 0) }} {{ $product->currency }}</div>
                                            @if($product->price_before > $product->price)
                                                <div class="text-xs text-red-400 line-through decoration-1">{{ number_format($product->price_before, 0) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm">
                                            @if($product->price_before > $product->price)
                                                @php $discount = round((($product->price_before - $product->price) / $product->price_before) * 100); @endphp
                                                <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full border border-red-100">-{{ $discount }}%</span>
                                            @else
                                                <span class="text-xs text-gray-300">-</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-center text-sm">
                                            <span class="font-bold {{ $product->stock > 5 ? 'text-green-600' : 'text-red-600' }}">{{ $product->stock }}</span>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="max-w-[100px] truncate" title="{{ $product->region }}">{{ $product->region ?? '-' }}</div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm">
                                            <div class="text-xs text-orange-600 font-bold bg-orange-50 px-2 py-0.5 rounded">{{ $product->warranty_duration > 0 ? $product->warranty_duration . ' ' . ($product->warranty_unit == 'months' ? 'شهر' : ($product->warranty_unit == 'years' ? 'سنة' : 'يوم')) : 'لا يوجد' }}</div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-center">
                                            @php
                                                $ai_badge_class = match($product->ai_status) {
                                                    'approved' => 'bg-green-100 text-green-800',
                                                    'rejected' => 'bg-red-100 text-red-800',
                                                    'needs_edit' => 'bg-yellow-100 text-yellow-800',
                                                    default => 'bg-blue-100 text-blue-800',
                                                };
                                                $ai_status_text = match($product->ai_status) {
                                                    'approved' => 'مقبول',
                                                    'rejected' => 'مرفوض',
                                                    'needs_edit' => 'تعديل',
                                                    default => 'قيد الانتظار',
                                                };
                                            @endphp
                                            <span class="px-2 py-0.5 inline-flex text-[10px] leading-5 font-bold rounded-full {{ $ai_badge_class }}">
                                                {{ $ai_status_text }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-center text-sm font-medium" onclick="event.stopPropagation()">
                                            <div class="flex items-center justify-center space-x-2 space-x-reverse">
                                                <form action="{{ route('vendor.products.toggleStatus', $product->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                        class="px-2 py-1 text-xs rounded-full font-semibold {{ $product->status === 'active' ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }}">
                                                        {{ $product->status === 'active' ? 'تعطيل' : 'تفعيل' }}
                                                    </button>
                                                </form>

                                                <a href="{{ route('vendor.products.edit', $product->id) }}" class="px-3 py-1 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-full transition-colors">تعديل</a>

                                                <form action="{{ route('vendor.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 bg-red-100 text-red-700 hover:bg-red-200 rounded-full transition-colors">حذف</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                                <p class="text-lg font-medium text-gray-900">لا توجد منتجات حالياً</p>
                                                <p class="text-sm text-gray-500 mb-4">ابدأ بإضافة منتجاتك الأولى إلى المتجر</p>
                                                <a href="{{ route('vendor.products.create') }}" class="px-4 py-2 bg-brand-orange text-white text-sm font-semibold rounded-lg shadow hover:bg-brand-orange-700 transition-colors">إضافة منتج جديد</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination Links -->
                    <div class="mt-8 border-t border-gray-100 pt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>
