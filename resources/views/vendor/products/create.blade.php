<x-vendor-layout>
    <x-slot name="title">
        إضافة منتج جديد
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">إضافة منتج جديد</h2>

                    <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Code -->
                            <div>
                                <x-input-label for="product_code" :value="__('رمز المنتج (SKU)')" />
                                <x-text-input id="product_code" class="block mt-1 w-full" type="text"
                                    name="product_code" :value="old('product_code')" placeholder="مثال: PRD-001" />
                                <x-input-error :messages="$errors->get('product_code')" class="mt-2" />
                            </div>

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('اسم المنتج')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name')" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Brand -->
                            <div>
                                <x-input-label for="brand" :value="__('الماركة')" />
                                <select id="brand" name="brand"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">اختر الماركة</option>
                                    @foreach(['Apple', 'HP', 'Dell', 'Lenovo', 'Asus', 'Acer', 'Microsoft (Surface)', 'MSI', 'Razer', 'Samsung'] as $brand)
                                        <option value="{{ $brand }}" {{ old('brand') == $brand ? 'selected' : '' }}>
                                            {{ $brand }}
                                        </option>
                                    @endforeach
                                    <option value="other" {{ old('brand') == 'other' ? 'selected' : '' }}>أخرى</option>
                                </select>
                                <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                            </div>

                            <!-- Price -->
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <x-input-label for="price" :value="__('سعر البيع')" />
                                    <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01"
                                        name="price" :value="old('price')" required />
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>
                                <div class="w-1/3">
                                    <x-input-label for="currency" :value="__('العملة')" />
                                    <select id="currency" name="currency"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="YER" {{ old('currency') == 'YER' ? 'selected' : '' }}>ريال يمني
                                        </option>
                                        <option value="SAR" {{ old('currency') == 'SAR' ? 'selected' : '' }}>ريال سعودي
                                        </option>
                                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>دولار أمريكي
                                        </option>
                                    </select>
                                    <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Price Before Discount -->
                            <div>
                                <x-input-label for="price_before" :value="__('السعر قبل الخصم (اختياري)')" />
                                <x-text-input id="price_before" class="block mt-1 w-full" type="number" step="0.01"
                                    name="price_before" :value="old('price_before')" placeholder="عرض سعر شطبه" />
                                <x-input-error :messages="$errors->get('price_before')" class="mt-2" />
                            </div>

                            <!-- Cost Price -->
                            <div>
                                <x-input-label for="cost_price" :value="__('تكلفة الشراء (سرية)')" />
                                <x-text-input id="cost_price" class="block mt-1 w-full" type="number" step="0.01"
                                    name="cost_price" :value="old('cost_price')" placeholder="تستخدم لحساب الأرباح" />
                                <x-input-error :messages="$errors->get('cost_price')" class="mt-2" />
                            </div>

                            <!-- Stock -->
                            <div>
                                <x-input-label for="stock" :value="__('الكمية الحالية (المخزون)')" />
                                <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock"
                                    :value="old('stock')" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>

                            <!-- Min Stock -->
                            <div>
                                <x-input-label for="min_stock" :value="__('تنبيه عند وصول المخزون لـ')" />
                                <x-text-input id="min_stock" class="block mt-1 w-full" type="number" name="min_stock"
                                    :value="old('min_stock', 5)" required />
                                <x-input-error :messages="$errors->get('min_stock')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="warranty" :value="__('الضمان')" />
                                <x-text-input id="warranty" class="block mt-1 w-full" type="text" name="warranty"
                                    :value="old('warranty')" placeholder="مثال: سنتين" />
                                <x-input-error :messages="$errors->get('warranty')" class="mt-2" />
                            </div>


                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('الحالة')" />
                                <select id="status" name="status"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>نشط
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>معطل
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Category -->
                            <div>
                                <x-input-label for="category_id" :value="__('التصنيف')" />
                                <select id="category_id" name="category_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">اختر التصنيف</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <!-- Images -->
                            <div>
                                <x-input-label for="images" :value="__('صور المنتج (يمكنك اختيار أكثر من صورة)')" />
                                <input type="file" id="images" name="images[]" multiple accept="image/*"
                                    class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"
                                    onchange="document.getElementById('image-preview-container').innerHTML = ''; Array.from(this.files).forEach(file => { if (file.type.startsWith('image/')) { const reader = new FileReader(); reader.onload = (e) => { const img = document.createElement('img'); img.src = e.target.result; img.className = 'h-20 w-20 object-cover rounded-md border border-gray-200'; document.getElementById('image-preview-container').appendChild(img); }; reader.readAsDataURL(file); } });" />
                                <x-input-error :messages="$errors->get('images')" class="mt-2" />
                                <x-input-error :messages="$errors->get('images.*')" class="mt-2" />

                                <!-- Image Preview Container -->
                                <div id="image-preview-container" class="mt-4 flex flex-wrap gap-4"></div>
                            </div>

                            <!-- 3D Model -->
                            <div>
                                <x-input-label for="three_d_model" :value="__('ملف 3D (glb, gltf, obj, stl)')" />
                                <input type="file" id="three_d_model" name="three_d_model" accept=".glb,.gltf,.obj,.stl"
                                    class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                <p class="text-xs text-gray-500 mt-1">يُدعم ملفات glb, gltf, obj, stl بحد أقصى 20 ميجا
                                    بايت</p>
                                <x-input-error :messages="$errors->get('three_d_model')" class="mt-2" />
                            </div>

                            <!-- 360 Images -->
                            <div>
                                <x-input-label for="three_sixty_images" :value="__('صور 360 (ارفع مجموعة من الصور للعرض الدوار)')" />
                                <input type="file" id="three_sixty_images" name="three_sixty_images[]" multiple
                                    accept="image/*"
                                    class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" />
                                <p class="text-xs text-gray-500 mt-1">يُشترط رفع صور متتالية لتكوين العرض 360 درجة</p>
                                <x-input-error :messages="$errors->get('three_sixty_images')" class="mt-2" />
                                <x-input-error :messages="$errors->get('three_sixty_images.*')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <x-input-label for="description" :value="__('وصف مختصر')" />
                            <textarea id="description" name="description" rows="3"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Full Description -->
                        <div class="mt-6">
                            <x-input-label for="full_description" :value="__('الوصف الكامل')" />
                            <textarea id="full_description" name="full_description" rows="5"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('full_description') }}</textarea>
                            <x-input-error :messages="$errors->get('full_description')" class="mt-2" />
                        </div>

                        <!-- Notes -->
                        <div class="mt-6">
                            <x-input-label for="notes" :value="__('ملاحظات إضافية (خاصة بالبائع)')" />
                            <textarea id="notes" name="notes" rows="3"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="أي ملاحظات تود حفظها عن هذا المنتج">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('vendor.products.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900 ml-4">إلغاء</a>
                            <x-primary-button class="ml-4">
                                {{ __('حفظ المنتج') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>