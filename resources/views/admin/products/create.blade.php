<x-admin-layout>
    <x-slot name="title">
        إضافة منتج جديد
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-brand-blue-800 mb-6">إضافة منتج جديد</h2>

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
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
                                    :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Brand -->
                            <div>
                                <x-input-label for="brand_id" :value="__('الماركة')" />
                                <select id="brand_id" name="brand_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">اختر الماركة</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('brand_id')" class="mt-2" />
                            </div>

                            <!-- Size -->
                            <div>
                                <x-input-label for="size" :value="__('الحجم')" />
                                <x-text-input id="size" class="block mt-1 w-full" type="text" name="size"
                                    :value="old('size')" />
                                <x-input-error :messages="$errors->get('size')" class="mt-2" />
                            </div>

                            <!-- Color -->
                            <div>
                                <x-input-label for="color" :value="__('اللون')" />
                                <x-text-input id="color" class="block mt-1 w-full" type="text" name="color"
                                    :value="old('color')" />
                                <x-input-error :messages="$errors->get('color')" class="mt-2" />
                            </div>

                            <!-- Region -->
                            <div>
                                <x-input-label for="region" :value="__('المنطقة')" />
                                <x-text-input id="region" class="block mt-1 w-full" type="text" name="region"
                                    :value="old('region')" />
                                <x-input-error :messages="$errors->get('region')" class="mt-2" />
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
                                            (YER)</option>
                                        <option value="SAR" {{ old('currency') == 'SAR' ? 'selected' : '' }}>ريال سعودي
                                            (SAR)</option>
                                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>دولار أمريكي
                                            (USD)</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Price Before Discount -->
                            <div>
                                <x-input-label for="price_before" :value="__('السعر قبل الخصم')" />
                                <x-text-input id="price_before" class="block mt-1 w-full" type="number" step="0.01"
                                    name="price_before" :value="old('price_before')" />
                                <x-input-error :messages="$errors->get('price_before')" class="mt-2" />
                            </div>

                            <!-- Cost Price -->
                            <div>
                                <x-input-label for="cost_price" :value="__('تكلفة الشراء')" />
                                <x-text-input id="cost_price" class="block mt-1 w-full" type="number" step="0.01"
                                    name="cost_price" :value="old('cost_price')" />
                                <x-input-error :messages="$errors->get('cost_price')" class="mt-2" />
                            </div>

                            <!-- Stock -->
                            <div>
                                <x-input-label for="stock" :value="__('الكمية (المخزون)')" />
                                <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock"
                                    :value="old('stock')" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>

                            <!-- Min Stock -->
                            <div>
                                <x-input-label for="min_stock" :value="__('الحد الأدنى للمخزون')" />
                                <x-text-input id="min_stock" class="block mt-1 w-full" type="number" name="min_stock"
                                    :value="old('min_stock', 5)" required />
                                <x-input-error :messages="$errors->get('min_stock')" class="mt-2" />
                            </div>

                            <!-- Warranty -->
                            <div>
                                <x-input-label for="warranty_duration" :value="__('الضمان')" />
                                <div class="flex gap-2">
                                    <x-text-input id="warranty_duration" class="block mt-1 w-2/3" type="number" name="warranty_duration"
                                        :value="old('warranty_duration')" placeholder="مثال: 2" min="1" />
                                    <select id="warranty_unit" name="warranty_unit" class="block mt-1 w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="" {{ old('warranty_unit') == '' ? 'selected' : '' }}>أختر الوحدة</option>
                                        <option value="days" {{ old('warranty_unit') == 'days' ? 'selected' : '' }}>يوم</option>
                                        <option value="months" {{ old('warranty_unit') == 'months' ? 'selected' : '' }}>شهر</option>
                                        <option value="years" {{ old('warranty_unit') == 'years' ? 'selected' : '' }}>سنة</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('warranty_duration')" class="mt-2" />
                                <x-input-error :messages="$errors->get('warranty_unit')" class="mt-2" />
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

                            <!-- Store -->
                            <div>
                                <x-input-label for="store_id" :value="__('المتجر')" />
                                <select id="store_id" name="store_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">اختر المتجر</option>
                                    @foreach($stores as $store)
                                        <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('store_id')" class="mt-2" />
                            </div>

                            <!-- Category Management -->
                            <div class="col-span-1 md:col-span-2 bg-gray-50 p-6 rounded-2xl border border-gray-100 shadow-sm">
                                <h4 class="text-sm font-bold text-brand-blue-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                    تصنيف المنتج
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Main Category -->
                                    <div>
                                        <x-input-label for="main_category" :value="__('القسم الرئيسي')" />
                                        <select id="main_category" class="block mt-1 w-full border-gray-300 focus:border-brand-blue focus:ring-brand-blue rounded-xl shadow-sm py-3 transition-all" onchange="filterSubCategories(this.value)">
                                            <option value="">اختر القسم الرئيسي</option>
                                            @foreach($categories as $parent)
                                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Sub Category -->
                                    <div>
                                        <x-input-label for="category_id" :value="__('القسم الفرعي')" />
                                        <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 focus:border-brand-blue focus:ring-brand-blue rounded-xl shadow-sm py-3 transition-all" disabled>
                                            <option value="">اختر القسم الرئيسي أولاً</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                    </div>
                                </div>

                                <script>
                                    const categoriesData = @json($categories);

                                    function filterSubCategories(parentId) {
                                        const subSelect = document.getElementById('category_id');
                                        subSelect.innerHTML = '';
                                        
                                        if (!parentId) {
                                            subSelect.innerHTML = '<option value="">اختر القسم الرئيسي أولاً</option>';
                                            subSelect.disabled = true;
                                            return;
                                        }

                                        const parent = categoriesData.find(c => c.id == parentId);
                                        if (parent && parent.children && parent.children.length > 0) {
                                            subSelect.disabled = false;
                                            subSelect.innerHTML = '<option value="">اختر القسم الفرعي</option>';
                                            parent.children.forEach(child => {
                                                const opt = document.createElement('option');
                                                opt.value = child.id;
                                                opt.textContent = child.name;
                                                subSelect.appendChild(opt);
                                            });
                                        } else {
                                            // If no children, use the parent ID itself as the category_id
                                            subSelect.disabled = false;
                                            subSelect.innerHTML = `<option value="${parentId}">هذا القسم لا يحتوي على أقسام فرعية (استخدمه كقسم وحيد)</option>`;
                                        }
                                    }
                                </script>
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
                            <x-input-label for="notes" :value="__('ملاحظات إقليمية (خاصة بالنظام)')" />
                            <textarea id="notes" name="notes" rows="3"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.products.index') }}"
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
</x-admin-layout>