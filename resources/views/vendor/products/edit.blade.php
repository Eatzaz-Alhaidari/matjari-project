<x-vendor-layout>
    <x-slot name="title">
        تعديل المنتج: {{ $product->name }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">تعديل المنتج: {{ $product->name }}</h2>
            </div>

            <form id="edit-product-form" action="{{ route('vendor.products.update', $product->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content (2 Columns on Large Screens) -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Basic Information Card -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg">
                                <h3 class="text-lg font-medium text-gray-900">المعلومات الأساسية</h3>
                            </div>
                            <div class="p-6 space-y-6">
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

                                <!-- Short Description -->
                                <div>
                                    <x-input-label for="description" :value="__('وصف مختصر')" />
                                    <textarea id="description" name="description" rows="3"
                                        class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange round-md shadow-sm rounded-md"
                                        required>{{ old('description', $product->description) }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>

                                <!-- Full Description -->
                                <div>
                                    <x-input-label for="full_description" :value="__('الوصف الكامل')" />
                                    <textarea id="full_description" name="full_description" rows="5"
                                        class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm">{{ old('full_description', $product->full_description) }}</textarea>
                                    <x-input-error :messages="$errors->get('full_description')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Pricing & Inventory Card -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg">
                                <h3 class="text-lg font-medium text-gray-900">الأسعار والمخزون</h3>
                            </div>
                            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Price -->
                                <div>
                                    <x-input-label for="price" :value="__('السعر')" />
                                    <div class="relative mt-1 rounded-md shadow-sm">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-500 sm:text-sm">ر.ي</span>
                                        </div>
                                        <x-text-input id="price" class="block w-full pr-12" type="number" step="0.01"
                                            name="price" :value="old('price', $product->price)" required />
                                    </div>
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>

                                <!-- Stock -->
                                <div>
                                    <x-input-label for="stock" :value="__('الكمية (المخزون)')" />
                                    <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock"
                                        :value="old('stock', $product->stock)" required />
                                    <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                                </div>

                                <!-- Warranty -->
                                <div class="md:col-span-2">
                                    <x-input-label for="warranty" :value="__('الضمان')" />
                                    <x-text-input id="warranty" class="block mt-1 w-full" type="text" name="warranty"
                                        :value="old('warranty', $product->warranty)" placeholder="مثال: سنتين" />
                                    <x-input-error :messages="$errors->get('warranty')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Sidebar (1 Column on Large Screens) -->
                    <div class="space-y-6">

                        <!-- Organization Card -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg">
                                <h3 class="text-lg font-medium text-gray-900">التنظيم</h3>
                            </div>
                            <div class="p-6 space-y-6">
                                <!-- Status -->
                                <div>
                                    <x-input-label for="status" :value="__('الحالة')" />
                                    <select id="status" name="status"
                                        class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm">
                                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>معطل</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </div>

                                <!-- Category -->
                                <div>
                                    <x-input-label for="category_id" :value="__('التصنيف')" />
                                    <select id="category_id" name="category_id"
                                        class="block mt-1 w-full border-gray-300 focus:border-brand-orange focus:ring-brand-orange rounded-md shadow-sm">
                                        <option value="">اختر التصنيف</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Media Card -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg">
                                <h3 class="text-lg font-medium text-gray-900">صور المنتج</h3>
                            </div>
                            <div class="p-6">
                                <!-- عرض الصور الحالية -->
                                @if($product->images->count() > 0)
                                    <div class="grid grid-cols-2 gap-2 mb-4">
                                        @foreach($product->images as $img)
                                            <img src="{{ asset('storage/' . $img->image_path) }}"
                                                class="w-full h-20 object-cover rounded border">
                                        @endforeach
                                    </div>
                                @elseif($product->image)
                                    <div class="mb-4">
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            class="w-full h-32 object-cover rounded border">
                                    </div>
                                @endif

                                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10"
                                    id="image-preview-container">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                                            <label for="images"
                                                class="relative cursor-pointer rounded-md bg-white font-semibold text-brand-orange focus-within:outline-none focus-within:ring-2 focus-within:ring-brand-orange focus-within:ring-offset-2 hover:text-brand-orange-700">
                                                <span>رفع صور إضافية</span>
                                                <input id="images" name="images[]" type="file" class="sr-only"
                                                    accept="image/*" multiple>
                                            </label>
                                        </div>
                                        <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 2MB</p>
                                        <p id="file-name" class="mt-2 text-sm text-gray-500 hidden"></p>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('images')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4 mt-6">
                            <a href="{{ route('vendor.products.index') }}"
                                class="text-sm font-semibold leading-6 text-gray-900 hover:text-red-500">إلغاء</a>
                            <x-primary-button>
                                {{ __('حفظ التعديلات') }}
                            </x-primary-button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Track initial values
        const form = document.getElementById('edit-product-form');
        const initialValues = {};
        const fieldLabels = {
            'name': 'اسم المنتج',
            'brand': 'الماركة',
            'description': 'الوصف المختصر',
            'full_description': 'الوصف الكامل',
            'price': 'السعر',
            'stock': 'الكمية',
            'warranty': 'الضمان',
            'status': 'الحالة',
            'category_id': 'التصنيف'
        };

        const statusLabels = {
            'active': 'نشط',
            'inactive': 'معطل'
        };

        const categoryNames = {
            @foreach($categories as $category)
                '{{ $category->id }}': '{{ $category->name }}',
            @endforeach
        };

        // Initialize values
        document.querySelectorAll('#edit-product-form input, #edit-product-form textarea, #edit-product-form select').forEach(input => {
            if (input.name && input.name !== '_token' && input.name !== '_method') {
                if (input.name === 'images[]') return;
                initialValues[input.name] = input.value;
            }
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const currentValues = {};
            const changes = [];

            document.querySelectorAll('#edit-product-form input, #edit-product-form textarea, #edit-product-form select').forEach(input => {
                if (input.name && input.name !== '_token' && input.name !== '_method') {
                    if (input.name === 'images[]') {
                        if (input.files.length > 0) {
                            changes.push(`<li><strong>صور المنتج:</strong> تم اختيار ${input.files.length} صورة جديدة</li>`);
                        }
                        return;
                    }

                    if (input.value !== initialValues[input.name]) {
                        let oldVal = initialValues[input.name];
                        let newVal = input.value;

                        // Handle status translation
                        if (input.name === 'status') {
                            oldVal = statusLabels[oldVal] || oldVal;
                            newVal = statusLabels[newVal] || newVal;
                        }

                        // Handle category translation
                        if (input.name === 'category_id') {
                            oldVal = categoryNames[oldVal] || oldVal;
                            newVal = categoryNames[newVal] || newVal;
                        }

                        changes.push(`<li><strong>${fieldLabels[input.name] || input.name}:</strong> من "${oldVal}" إلى "${newVal}"</li>`);
                    }
                }
            });

            if (changes.length === 0) {
                Swal.fire({
                    title: 'لا توجد تغييرات',
                    text: 'لم تقم بإجراء أي تعديلات على المنتج.',
                    icon: 'info',
                    confirmButtonText: 'إغلاق',
                    confirmButtonColor: '#f97316',
                });
                return;
            }

            let changesHtml = '<ul style="text-align: right; direction: rtl; list-style-type: disc; padding-right: 20px;">' + changes.join('') + '</ul>';

            Swal.fire({
                title: 'تأكيد التعديلات',
                html: `
                    <div class="text-right" dir="rtl">
                        <p class="mb-3">لقد قمت بتعديل الحقول التالية:</p>
                        ${changesHtml}
                        <p class="mt-4 font-bold text-center">هل أنت متأكد من حفظ هذه التعديلات؟</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'نعم، حفظ',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: '#f97316', // brand-orange
                cancelButtonColor: '#6b7280',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Image preview logic fix
        const imagesInput = document.getElementById('images');
        if (imagesInput) {
            imagesInput.addEventListener('change', function (e) {
                const fileNameElement = document.getElementById('file-name');
                if (this.files.length > 0) {
                    fileNameElement.textContent = 'تم اختيار ' + this.files.length + ' صور';
                    fileNameElement.classList.remove('hidden');
                } else {
                    fileNameElement.classList.add('hidden');
                }
            });
        }
    </script>
</x-vendor-layout>