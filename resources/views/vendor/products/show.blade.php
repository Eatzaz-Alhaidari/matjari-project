<x-vendor-layout>
    <x-slot name="title">
        عرض المنتج: {{ $product->name }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-black">تفاصيل المنتج</h2>
                        <a href="{{ route('vendor.products.index') }}"
                            class="px-4 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-brand-orange-700">
                            العودة للقائمة
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- معلومات المنتج الأساسية -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">معلومات المنتج</h3>
                                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">اسم المنتج:</span>
                                        <span class="text-gray-900">{{ $product->name }}</span>
                                    </div>
                                    @if($product->brand)
                                        <div class="flex justify-between">
                                            <span class="font-medium text-gray-700">الماركة:</span>
                                            <span class="text-gray-900">{{ $product->brand }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">السعر:</span>
                                        <span
                                            class="text-green-600 font-semibold">{{ number_format($product->price, 2) }}
                                            ر.ي</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">المخزون:</span>
                                        <span class="text-gray-900">{{ $product->stock }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">الحالة:</span>
                                        <span
                                            class="px-2 py-1 text-xs rounded-full font-semibold
                                            {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $product->status === 'active' ? 'نشط' : 'معطل' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">التصنيف:</span>
                                        <span class="text-gray-900">{{ $product->category->name ?? 'غير محدد' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">تاريخ الإضافة:</span>
                                        <span
                                            class="text-gray-900">{{ $product->created_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">آخر تحديث:</span>
                                        <span
                                            class="text-gray-900">{{ $product->updated_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- الوصف المختصر -->
                            @if($product->description)
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">الوصف المختصر</h3>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- الصورة والوصف الكامل -->
                        <div class="space-y-6">
                            <!-- صور المنتج -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">صور المنتج</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    @if($product->images->count() > 0)
                                        <div class="grid grid-cols-2 gap-4">
                                            @foreach($product->images as $img)
                                                <a href="{{ asset('storage/' . $img->image_path) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $img->image_path) }}"
                                                        class="w-full h-48 object-cover rounded-lg shadow-sm hover:opacity-75 transition-opacity">
                                                </a>
                                            @endforeach
                                        </div>
                                    @elseif($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            class="w-full h-auto object-cover rounded-lg shadow-md">
                                    @else
                                        <div class="flex items-center justify-center h-64">
                                            <div class="text-center">
                                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <p class="text-gray-500">لا توجد صور</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- الوصف الكامل -->
                            @if($product->full_description)
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">الوصف الكامل</h3>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-gray-700 leading-relaxed">{{ $product->full_description }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- أزرار الإجراءات -->
                    <div class="mt-8 flex justify-center space-x-4 space-x-reverse">
                        <a href="{{ route('vendor.products.edit', $product->id) }}"
                            class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-colors">
                            تعديل المنتج
                        </a>
                        <form action="{{ route('vendor.products.toggleStatus', $product->id) }}" method="POST"
                            class="inline-block" data-confirm-title="تغيير حالة المنتج"
                            data-confirm-text="{{ $product->status === 'active' ? 'سيتم تعطيل المنتج ولن يظهر للعملاء.' : 'سيتم تفعيل المنتج وعرضه في المتجر.' }}"
                            data-confirm-button="نعم، غير الحالة" data-confirm-icon="question">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="px-6 py-2 font-semibold rounded-lg shadow-md transition-colors
                                {{ $product->status === 'active' ? 'bg-yellow-500 text-white hover:bg-yellow-600' : 'bg-green-500 text-white hover:bg-green-600' }}">
                                {{ $product->status === 'active' ? 'تعطيل المنتج' : 'تفعيل المنتج' }}
                            </button>
                        </form>
                        <form action="{{ route('vendor.products.destroy', $product->id) }}" method="POST"
                            class="inline-block" data-confirm-title="حذف المنتج"
                            data-confirm-text="هل أنت متأكد من حذف هذا المنتج نهائياً؟"
                            data-confirm-button="احذف المنتج" data-confirm-icon="warning">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-6 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition-colors">
                                حذف المنتج
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>