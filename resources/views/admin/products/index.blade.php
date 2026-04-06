<x-admin-layout>
    <x-slot name="title">
        إدارة المنتجات
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">



            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-brand-blue-800">قائمة المنتجات</h2>
                    </div>

                    <!-- ##### بداية نموذج البحث ##### -->
                    <div class="mb-6">
                        <form action="{{ route('admin.products.index') }}" method="GET" class="flex items-center">
                            <input type="text" name="search" placeholder="ابحث باسم المنتج أو الوصف..."
                                class="w-full md:w-1/3 border-gray-300 rounded-lg shadow-sm"
                                value="{{ request('search') }}">
                            <button type="submit"
                                class="mr-3 px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow-md hover:bg-brand-blue-700 transition-colors">بحث</button>
                        </form>
                    </div>
                    <!-- ##### نهاية نموذج البحث ##### -->

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-brand-blue-50 text-right">
                                <tr>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider whitespace-nowrap">صورة</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider whitespace-nowrap">المنتج</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider whitespace-nowrap">التصنيف</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider whitespace-nowrap">الماركة</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider whitespace-nowrap">المتجر</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider whitespace-nowrap">الأحجام/الألوان</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider whitespace-nowrap">السعر</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider whitespace-nowrap">الخصم</th>
                                    <th scope="col" class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider whitespace-nowrap">المخزون</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider whitespace-nowrap">المنطقة</th>
                                    <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider whitespace-nowrap">الضمان</th>
                                    <th scope="col" class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider whitespace-nowrap">الحالة</th>
                                    <th scope="col" class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider whitespace-nowrap">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($products as $product)
                                    <tr class="hover:bg-gray-50 transition-colors">
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
                                        <td class="px-5 py-4 min-w-[250px]">
                                            <div class="text-sm font-medium text-gray-900 mb-0.5">{{ $product->name }}</div>
                                            <div class="text-[10px] text-gray-400 italic">{{ $product->description }}</div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-xs text-brand-blue-600 font-medium bg-blue-50 px-2 py-0.5 rounded border border-blue-100 inline-block">{{ $product->category->name ?? 'بدون قسم' }}</div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-xs text-amber-700 font-bold bg-amber-50 px-2 py-0.5 rounded border border-amber-100 inline-block">{{ $product->getRelationValue('brand')->name ?? '-' }}</div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="max-w-[150px] truncate">{{ $product->store->name ?? 'غير محدد' }}</div>
                                        </td>
                                        <td class="px-5 py-4 min-w-[180px]">
                                            <!-- Sizes Row -->
                                            <div class="flex flex-nowrap gap-1 mb-3 overflow-x-auto no-scrollbar pb-1">
                                                @foreach($product->sizes as $size)
                                                    <span class="px-2 py-1 bg-gray-50 text-gray-600 text-[10px] font-bold rounded-lg border border-gray-100 shadow-sm whitespace-nowrap">{{ $size->name }}</span>
                                                @endforeach
                                            </div>
                                            <!-- Colors Row -->
                                            <div class="flex flex-nowrap gap-1.5 overflow-x-auto no-scrollbar">
                                                @foreach($product->colors as $color)
                                                    @if($color->image_path)
                                                        <img src="{{ Storage::url($color->image_path) }}" class="h-6 w-6 rounded-full border-2 border-white shadow-md object-cover flex-shrink-0 hover:scale-110 transition-transform cursor-help" title="{{ $color->name }}">
                                                    @else
                                                        <div class="h-6 w-6 rounded-full border-2 border-white shadow-md bg-gray-200 flex items-center justify-center text-[8px] text-gray-500 font-bold flex-shrink-0 hover:scale-110 transition-transform cursor-help" title="{{ $color->name }}">
                                                            {{ mb_substr($color->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm">
                                            <div class="font-bold text-gray-900">{{ number_format($product->price, 0) }}</div>
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
                                            <div class="max-w-[120px] truncate" title="{{ $product->region }}">{{ $product->region ?? 'غير محدد' }}</div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm">
                                            <div class="text-xs text-orange-600 font-bold bg-orange-50 px-2 py-0.5 rounded">{{ $product->warranty_duration > 0 ? $product->warranty_duration . ' يوم' : 'لا يوجد' }}</div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-center">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $product->status === 'active' ? 'نشط' : 'معطل' }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center space-x-3 space-x-reverse">
                                                <form action="{{ route('admin.products.toggleStatus', $product->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                        class="px-2 py-1 text-xs rounded-full font-semibold {{ $product->status === 'active' ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }}"
                                                        title="{{ $product->status === 'active' ? 'تعطيل المنتج' : 'تفعيل المنتج' }}">
                                                        {{ $product->status === 'active' ? 'تعطيل المنتج' : 'تفعيل المنتج' }}
                                                    </button>
                                                </form>

                                                <a href="{{ route('admin.products.show', $product->id) }}" class="p-2 text-gray-400 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-full transition-all duration-200" title="عرض">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </a>

                                                <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 rounded-full transition-all duration-200" title="تعديل">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>

                                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 rounded-full transition-all duration-200" title="حذف">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                    </path>
                                                </svg>
                                                <p class="text-lg font-medium text-gray-900">لا توجد منتجات حالياً</p>
                                                <p class="text-sm text-gray-500 mb-4">ابدأ بإضافة منتجاتك الأولى إلى المتجر
                                                </p>
                                            </div>
                                        </td>
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
</x-admin-layout>