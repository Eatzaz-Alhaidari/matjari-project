<x-admin-layout>
    <x-slot name="title">
        تعديل المنتج: {{ $product->name }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-brand-blue-800 mb-6">تعديل المنتج</h2>

                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Code -->
                            <div>
                                <x-input-label for="product_code" :value="__('رمز المنتج (SKU)')" />
                                <x-text-input id="product_code" class="block mt-1 w-full" type="text"
                                    name="product_code" :value="old('product_code', $product->product_code)"
                                    placeholder="مثال: PRD-001" />
                                <x-input-error :messages="$errors->get('product_code')" class="mt-2" />
                            </div>

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('اسم المنتج')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name', $product->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Brand -->
                            <div>
                                <x-input-label for="brand" :value="__('الماركة')" />
                                <x-text-input id="brand" class="block mt-1 w-full" type="text" name="brand"
                                    :value="old('brand', $product->brand)" />
                                <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                            </div>

                            <!-- Price -->
                            <div>
                                <x-input-label for="price" :value="__('سعر البيع الحالي')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01"
                                    name="price" :value="old('price', $product->price)" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Price Before Discount -->
                            <div>
                                <x-input-label for="price_before" :value="__('السعر قبل الخصم')" />
                                <x-text-input id="price_before" class="block mt-1 w-full" type="number" step="0.01"
                                    name="price_before" :value="old('price_before', $product->price_before)" />
                                <x-input-error :messages="$errors->get('price_before')" class="mt-2" />
                            </div>

                            <!-- Cost Price -->
                            <div>
                                <x-input-label for="cost_price" :value="__('تكلفة الشراء')" />
                                <x-text-input id="cost_price" class="block mt-1 w-full" type="number" step="0.01"
                                    name="cost_price" :value="old('cost_price', $product->cost_price)" />
                                <x-input-error :messages="$errors->get('cost_price')" class="mt-2" />
                            </div>

                            <!-- Stock -->
                            <div>
                                <x-input-label for="stock" :value="__('الكمية (المخزون)')" />
                                <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock"
                                    :value="old('stock', $product->stock)" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>

                            <!-- Min Stock -->
                            <div>
                                <x-input-label for="min_stock" :value="__('الحد الأدنى للمخزون')" />
                                <x-text-input id="min_stock" class="block mt-1 w-full" type="number" name="min_stock"
                                    :value="old('min_stock', $product->min_stock)" required />
                                <x-input-error :messages="$errors->get('min_stock')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('الحالة')" />
                                <select id="status" name="status"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>معطل</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Store -->
                            <div>
                                <x-input-label for="store_id" :value="__('المتجر')" />
                                <select id="store_id" name="store_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">اختر المتجر</option>
                                    @foreach($stores as $store)
                                        <option value="{{ $store->id }}" {{ old('store_id', $product->store_id) == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('store_id')" class="mt-2" />
                            </div>

                            <!-- Category -->
                            <div>
                                <x-input-label for="category_id" :value="__('التصنيف')" />
                                <select id="category_id" name="category_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">اختر التصنيف</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <!-- Images -->
                            <div class="col-span-2">
                                <x-input-label for="images" :value="__('صور المنتج')" />

                                <!-- عرض الصور الحالية -->
                                @if($product->images->count() > 0)
                                    <div class="flex flex-wrap gap-4 mb-4 mt-2">
                                        @foreach($product->images as $img)
                                            <div class="relative group">
                                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                                    class="w-24 h-24 object-cover rounded-lg border shadow-sm">
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($product->image)
                                    <div class="mb-4 mt-2">
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            class="w-24 h-24 object-cover rounded-lg border shadow-sm">
                                    </div>
                                @endif
                            </div>

                            <!-- 3D Model -->
                            <div class="col-span-1">
                                <x-input-label for="three_d_model" :value="__('ملف 3D')" />
                                @if($product->three_d_model)
                                    <div class="mb-2 mt-1 text-xs text-indigo-600">
                                        يوجد ملف حالي: <a href="{{ asset('storage/' . $product->three_d_model) }}"
                                            target="_blank" class="underline font-bold">عرض</a>
                                    </div>
                                @else
                                    <p class="text-xs text-gray-500 mt-1">لا يوجد ملف 3D مرفوع</p>
                                @endif
                            </div>

                            <!-- 360 Images -->
                            <div class="col-span-1">
                                <x-input-label for="three_sixty_images" :value="__('صور 360 درجة')" />
                                @if($product->three_sixty_images)
                                    <div class="flex flex-wrap gap-1 mb-2 mt-1">
                                        @foreach($product->three_sixty_images as $path)
                                            <img src="{{ asset('storage/' . $path) }}"
                                                class="w-8 h-8 object-cover rounded border">
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-xs text-gray-500 mt-1">لا توجد صور 360 مرفوعة</p>
                                @endif
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <x-input-label for="description" :value="__('وصف مختصر')" />
                            <textarea id="description" name="description" rows="3"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Full Description -->
                        <div class="mt-6">
                            <x-input-label for="full_description" :value="__('الوصف الكامل')" />
                            <textarea id="full_description" name="full_description" rows="5"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('full_description', $product->full_description) }}</textarea>
                            <x-input-error :messages="$errors->get('full_description')" class="mt-2" />
                        </div>

                        <!-- Notes -->
                        <div class="mt-6">
                            <x-input-label for="notes" :value="__('ملاحظات إقليمية (خاصة بالنظام)')" />
                            <textarea id="notes" name="notes" rows="3"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $product->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.products.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900 ml-4">إلغاء</a>
                            <x-primary-button class="ml-4">
                                {{ __('حفظ التعديلات') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>