<x-vendor-layout>
    <x-slot name="title">
        إضافة منتج جديد
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-brand-orange-800 mb-6">إضافة منتج جديد</h2>

                    <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if(session('error'))
                            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg shadow-sm animate-pulse">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <div class="mr-4">
                                        <h3 class="text-lg font-bold text-red-800">تنبيه من الذكاء الاصطناعي</h3>
                                        <div class="mt-1 text-sm text-red-700">
                                            {{ session('error') }}
                                        </div>
                                        @if(session('ai_suggestions'))
                                            <div class="mt-3 p-3 bg-white/50 rounded-lg border border-red-100">
                                                <p class="text-xs font-bold text-red-600 mb-1">خطوات مقترحة للإصلاح:</p>
                                                <p class="text-xs text-red-800">{{ session('ai_suggestions') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Code -->
                            <div>
                                <x-input-label for="product_code" :value="__('رمز المنتج (SKU)')" />
                                <x-text-input id="product_code" class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm" type="text"
                                    name="product_code" :value="old('product_code')" placeholder="مثال: PRD-001" />
                                <x-input-error :messages="$errors->get('product_code')" class="mt-2" />
                            </div>

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('اسم المنتج')" />
                                <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm" type="text" name="name"
                                    :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Brand -->
                            <div>
                                <x-input-label for="brand_id" :value="__('الماركة')" />
                                <select id="brand_id" name="brand_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm">
                                    <option value="">اختر الماركة</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('brand_id')" class="mt-2" />
                            </div>

                            <!-- Dynamic Sizes / Specifications -->
                            <div class="col-span-1 md:col-span-2 bg-gray-50 p-4 rounded-xl border border-dashed border-gray-300">
                                <label class="block text-sm font-bold text-gray-700 mb-2">المواصفات / الأحجام (مثال: RAM 8GB, 1TB SSD, XL)</label>
                                <div id="sizes-container" class="space-y-2">
                                    <div class="flex gap-2">
                                        <input type="text" name="sizes[]" class="block w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm" placeholder="أدخل اسم المواصفة أو الحجم">
                                        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" onclick="addSizeRow()" class="mt-2 inline-flex items-center text-sm text-brand-orange-600 font-bold hover:text-brand-orange-800">
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                                    إضافة مواصفة/حجم آخر
                                </button>
                            </div>

                            <!-- Dynamic Colors -->
                            <div class="col-span-1 md:col-span-2 bg-gray-50 p-4 rounded-xl border border-dashed border-gray-300">
                                <label class="block text-sm font-bold text-gray-700 mb-2">الألوان المتاحة مع الصور التوضيحية</label>
                                <div id="colors-container" class="space-y-4">
                                    <div class="color-row flex flex-wrap md:flex-nowrap gap-4 items-end bg-white p-3 rounded-lg border border-gray-200">
                                        <div class="flex-1">
                                            <label class="block font-medium text-sm text-gray-700">اسم اللون</label>
                                            <input type="text" name="colors[0][name]" class="block w-full mt-1 border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm" placeholder="مثال: أسود مطفي">
                                        </div>
                                        <div class="flex-1">
                                            <label class="block font-medium text-sm text-gray-700">صورة اللون</label>
                                            <input type="file" name="colors[0][image]" class="block w-full text-xs mt-2" accept="image/*">
                                        </div>
                                        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 mb-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" onclick="addColorRow()" class="mt-2 inline-flex items-center text-sm text-brand-orange-600 font-bold hover:text-brand-orange-800">
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                                    إضافة لون آخر
                                </button>
                            </div>

                            <!-- Region -->
                            <div>
                                <x-input-label for="region" :value="__('المنطقة (المحافظة)')" />
                                <select id="region" name="region" class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm">
                                    <option value="">اختر المحافظة</option>
                                    @php
                                        $governorates = [
                                            'أمانة العاصمة', 'صنعاء', 'عدن', 'تعز', 'الحديدة', 'حضرموت', 'إب', 'ذمار', 'حجة', 
                                            'البيضاء', 'عمران', 'صعدة', 'المحويت', 'مأرب', 'لحج', 'أبين', 'المهرة', 'شبوة', 
                                            'سقطرى', 'ريمة', 'الضالع', 'الجوف'
                                        ];
                                    @endphp
                                    @foreach($governorates as $gov)
                                        <option value="{{ $gov }}" {{ old('region') == $gov ? 'selected' : '' }}>{{ $gov }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('region')" class="mt-2" />
                            </div>

                            <!-- Price -->
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <x-input-label for="price" :value="__('سعر البيع')" />
                                    <x-text-input id="price" class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm" type="number" step="0.01"
                                        name="price" :value="old('price')" required />
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>
                                <div class="w-1/3">
                                    <x-input-label for="currency" :value="__('العملة')" />
                                    <select id="currency" name="currency"
                                        class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm">
                                        <option value="YER" {{ old('currency') == 'YER' ? 'selected' : '' }}>ريال يمني (YER)</option>
                                        <option value="SAR" {{ old('currency') == 'SAR' ? 'selected' : '' }}>ريال سعودي (SAR)</option>
                                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>دولار أمريكي (USD)</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Price Before Discount -->
                            <div>
                                <x-input-label for="price_before" :value="__('السعر قبل الخصم')" />
                                <x-text-input id="price_before" class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm" type="number" step="0.01"
                                    name="price_before" :value="old('price_before')" />
                                <x-input-error :messages="$errors->get('price_before')" class="mt-2" />
                            </div>

                            <!-- Cost Price -->
                            <div>
                                <x-input-label for="cost_price" :value="__('تكلفة الشراء')" />
                                <x-text-input id="cost_price" class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm" type="number" step="0.01"
                                    name="cost_price" :value="old('cost_price')" />
                                <x-input-error :messages="$errors->get('cost_price')" class="mt-2" />
                            </div>

                            <!-- Stock -->
                            <div>
                                <x-input-label for="stock" :value="__('الكمية (المخزون)')" />
                                <x-text-input id="stock" class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm" type="number" name="stock"
                                    :value="old('stock')" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>

                            <!-- Min Stock -->
                            <div>
                                <x-input-label for="min_stock" :value="__('الحد الأدنى للمخزون')" />
                                <x-text-input id="min_stock" class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm" type="number" name="min_stock"
                                    :value="old('min_stock', 5)" required />
                                <x-input-error :messages="$errors->get('min_stock')" class="mt-2" />
                            </div>

                            <!-- Warranty -->
                            <div>
                                <x-input-label for="warranty_duration" :value="__('الضمان (بالأيام)')" />
                                <x-text-input id="warranty_duration" class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm" type="number" name="warranty_duration"
                                    :value="old('warranty_duration')" placeholder="أدخل عدد الأيام (مثال: 365 لسنة كاملة)" min="0" />
                                <p class="mt-1 text-[10px] text-amber-600 font-bold">بناءً على الرقم سيتم حساب (يوم، شهر، سنة) تلقائياً.</p>
                                <x-input-error :messages="$errors->get('warranty_duration')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('الحالة')" />
                                <select id="status" name="status"
                                    class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm">
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>معطل</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Category Management -->
                            <div class="col-span-1 md:col-span-2 bg-gray-50 p-6 rounded-2xl border border-gray-100 shadow-sm">
                                <h4 class="text-sm font-bold text-brand-orange-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                    تصنيف المنتج
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Main Category -->
                                    <div>
                                        <x-input-label for="main_category" :value="__('القسم الرئيسي')" />
                                        <select id="main_category" class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-xl shadow-sm py-3 transition-all" onchange="filterSubCategories(this.value)">
                                            <option value="">اختر القسم الرئيسي</option>
                                            @foreach($categories as $parent)
                                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Sub Category -->
                                    <div>
                                        <x-input-label for="category_id" :value="__('القسم الفرعي')" />
                                        <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-xl shadow-sm py-3 transition-all" disabled>
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

                            <!-- Media Section -->
                            <div class="col-span-1 md:col-span-2 bg-brand-orange-50/30 p-6 rounded-2xl border border-brand-orange-100 shadow-sm mt-4">
                                <h4 class="text-sm font-bold text-brand-orange-800 mb-6 flex items-center">
                                    <svg class="w-5 h-5 ml-2 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    معرض الصور والمحتوى التفاعلي
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <!-- Main Image -->
                                    <div class="bg-white p-4 rounded-xl border border-gray-100">
                                        <x-input-label for="image" :value="__('صورة المنتج الأساسية')" class="font-bold text-gray-700 mb-2" />
                                        <input type="file" id="image" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-orange file:text-white hover:file:bg-brand-orange-600 transition-all" accept="image/*" required />
                                        <p class="mt-2 text-[10px] text-gray-400 italic">هذه الصورة هي التي ستظهر في قوائم المنتجات.</p>
                                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                    </div>

                                    <!-- Gallery -->
                                    <div class="bg-white p-4 rounded-xl border border-gray-100">
                                        <x-input-label for="gallery" :value="__('معرض الصور الإضافية')" class="font-bold text-gray-700 mb-2" />
                                        <input type="file" id="gallery" name="images[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition-all" accept="image/*" />
                                        <p class="mt-2 text-[10px] text-gray-400 italic">يمكنك اختيار عدة صور لإظهار تفاصيل المنتج.</p>
                                    </div>

                                    <!-- 3D Model -->
                                    <div class="bg-white p-4 rounded-xl border border-gray-100">
                                        <x-input-label for="three_d_model" :value="__('ملف المنتج 3D (الواقع المعزز)')" class="font-bold text-gray-700 mb-2" />
                                        <div class="flex items-center space-x-2 space-x-reverse">
                                            <input type="file" id="three_d_model" name="three_d_model" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200 transition-all" accept=".glb,.gltf" />
                                            <span class="px-2 py-1 bg-amber-50 text-amber-600 border border-amber-100 rounded text-[10px] font-bold">GLB / GLTF</span>
                                        </div>
                                        <p class="mt-2 text-[10px] text-gray-400 italic">يدعم النظام ملفات الواقع المعزز لتجربة تسوق أفضل.</p>
                                        <x-input-error :messages="$errors->get('three_d_model')" class="mt-2" />
                                    </div>

                                    <!-- 360 Images -->
                                    <div class="bg-white p-4 rounded-xl border border-gray-100">
                                        <x-input-label for="three_sixty_images" :value="__('صور العرض 360 درجة')" class="font-bold text-gray-700 mb-2" />
                                        <input type="file" id="three_sixty_images" name="three_sixty_images[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all" accept="image/*" />
                                        <p class="mt-2 text-[10px] text-gray-400 italic">ارفع مجموعة صور متسلسلة للمنتج ليتم عرضها بزاوية 360 درجة.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <x-input-label for="description" :value="__('وصف مختصر')" />
                            <textarea id="description" name="description" rows="3"
                                class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm"
                                required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Full Description -->
                        <div class="mt-6">
                            <x-input-label for="full_description" :value="__('الوصف الكامل')" />
                            <textarea id="full_description" name="full_description" rows="5"
                                class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm">{{ old('full_description') }}</textarea>
                            <x-input-error :messages="$errors->get('full_description')" class="mt-2" />
                        </div>

                        <!-- Notes -->
                        <div class="mt-6">
                            <x-input-label for="notes" :value="__('ملاحظات إقليمية (خاصة بالنظام)')" />
                            <textarea id="notes" name="notes" rows="3"
                                class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm">{{ old('notes') }}</textarea>
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
    
    <script>
        let colorIndex = 1;

        function addSizeRow() {
            const container = document.getElementById('sizes-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2 mt-2';
            div.innerHTML = `
                <input type="text" name="sizes[]" class="block w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm" placeholder="أدخل اسم المواصفة أو الحجم">
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </button>
            `;
            container.appendChild(div);
        }

        function addColorRow() {
            const container = document.getElementById('colors-container');
            const div = document.createElement('div');
            div.className = 'color-row flex flex-wrap md:flex-nowrap gap-4 items-end bg-white p-3 rounded-lg border border-gray-200 mt-2';
            div.innerHTML = `
                <div class="flex-1">
                    <label class="block font-medium text-sm text-gray-700">اسم اللون</label>
                    <input type="text" name="colors[${colorIndex}][name]" class="block w-full mt-1 border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm" placeholder="مثال: أسود مطفي">
                </div>
                <div class="flex-1">
                    <label class="block font-medium text-sm text-gray-700">صورة اللون</label>
                    <input type="file" name="colors[${colorIndex}][image]" class="block w-full text-xs mt-2" accept="image/*">
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </button>
            `;
            container.appendChild(div);
            colorIndex++;
        }
    </script>
</x-vendor-layout>