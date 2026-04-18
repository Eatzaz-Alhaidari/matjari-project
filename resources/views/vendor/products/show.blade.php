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

                        <!-- AI Analysis & Status -->
                        <div class="md:col-span-2 mt-6">
                            <div class="bg-white border rounded-xl overflow-hidden shadow-sm">
                                <div class="px-6 py-4 border-b flex items-center justify-between {{ match($product->ai_status) { 'approved' => 'bg-green-50', 'rejected' => 'bg-red-50', 'needs_edit' => 'bg-yellow-50', default => 'bg-blue-50' } }}">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 rounded-lg {{ match($product->ai_status) { 'approved' => 'bg-green-100 text-green-700', 'rejected' => 'bg-red-100 text-red-700', 'needs_edit' => 'bg-yellow-100 text-yellow-700', default => 'bg-blue-100 text-blue-700' } }}">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900">تحليل جودة المنتج (الذكاء الاصطناعي)</h3>
                                            <p class="text-xs text-gray-500">تم التحقق من تطابق الاسم والوصف مع الصورة</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="px-4 py-1.5 rounded-full text-sm font-bold {{ match($product->ai_status) { 'approved' => 'bg-green-600 text-white', 'rejected' => 'bg-red-600 text-white', 'needs_edit' => 'bg-yellow-600 text-white', default => 'bg-blue-600 text-white' } }}">
                                            {{ match($product->ai_status) { 'approved' => 'مقبول', 'rejected' => 'مرفوض', 'needs_edit' => 'يحتاج تعديل', default => 'قيد الانتظار' } }}
                                        </span>
                                        @if($product->ai_status !== 'pending')
                                            <form action="{{ route('vendor.products.reReview', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-xs font-bold text-brand-orange hover:underline">طلب إعادة مراجعة الجديد</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="p-6">
                                    @if($product->ai_status === 'pending')
                                        <div class="flex flex-col items-center py-4">
                                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-brand-orange mb-3"></div>
                                            <p class="text-sm text-gray-600 font-medium">جاري تحليل بيانات المنتج بواسطة الذكاء الاصطناعي...</p>
                                        </div>
                                    @else
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <div class="md:col-span-2">
                                                <h4 class="text-sm font-bold text-gray-700 mb-2 uppercase tracking-tight">التشخيص</h4>
                                                <div class="p-4 rounded-lg bg-gray-50 border border-gray-100">
                                                    <p class="text-gray-800 leading-relaxed">{{ $product->ai_notes['reason'] ?? 'لا يوجد تفاصيل متاحة.' }}</p>
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-bold text-gray-700 mb-2 uppercase tracking-tight">نوع التعارض</h4>
                                                <div class="p-3 rounded-lg border {{ ($product->ai_notes['mismatch_type'] ?? '') == 'unclear' ? 'bg-yellow-50 border-yellow-100 text-yellow-700' : 'bg-red-50 border-red-100 text-red-700' }} text-sm font-bold text-center">
                                                    {{ match($product->ai_notes['mismatch_type'] ?? '') { 
                                                        'name_vs_image' => 'اسم المنتج لا يطابق الصورة',
                                                        'description_vs_image' => 'الوصف لا يطابق الصورة',
                                                        'unclear' => 'البيانات غير واضحة',
                                                        default => 'لا يوجد تعارض'
                                                    } }}
                                                </div>
                                            </div>
                                            @if(!empty($product->ai_notes['suggestions']))
                                                <div class="md:col-span-3">
                                                    <h4 class="text-sm font-bold text-gray-700 mb-2">اقتراحات التصحيح</h4>
                                                    <div class="p-4 rounded-lg bg-blue-50 border border-blue-100 text-blue-800 text-sm leading-relaxed">
                                                        {{ $product->ai_notes['suggestions'] }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
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

                            <!-- عرض 3D و 360 درجة -->
                            @if($product->three_d_model || $product->three_sixty_images)
                                <div class="mt-6 space-y-6">
                                    @if($product->three_d_model)
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-4">عرض 3D</h3>
                                            <div class="bg-blue-50 rounded-lg p-4 flex items-center justify-between">
                                                <span class="text-blue-700 font-medium">ملف 3D متاح للعرض في التطبيق</span>
                                                <a href="{{ asset('storage/' . $product->three_d_model) }}" target="_blank"
                                                    class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                                                    تحميل الملف
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    @if($product->three_sixty_images)
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-4">عرض 360 درجة</h3>
                                            <div class="bg-green-50 rounded-lg p-4">
                                                <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                                                    @foreach($product->three_sixty_images as $path)
                                                        <img src="{{ asset('storage/' . $path) }}"
                                                            class="w-full h-12 object-cover rounded shadow-sm">
                                                    @endforeach
                                                </div>
                                                <p class="text-xs text-green-700 mt-2 font-medium">مجموعة مكونة من
                                                    {{ count($product->three_sixty_images) }} صورة للعرض الدوار</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

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