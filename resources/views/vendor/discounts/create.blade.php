<x-vendor-layout>
    <x-slot name="title">
        إضافة خصم جديد
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center mb-6">
                        <a href="{{ route('vendor.discounts.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h2 class="text-2xl font-bold text-black">إضافة خصم جديد</h2>
                    </div>

                    <form action="{{ route('vendor.discounts.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                عنوان الخصم <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-orange focus:border-brand-orange @error('title') border-red-500 @enderror"
                                placeholder="مثال: خصم عيد الأم">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                وصف الخصم
                            </label>
                            <textarea id="description" name="description" rows="3"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-orange focus:border-brand-orange @error('description') border-red-500 @enderror"
                                placeholder="وصف تفصيلي للخصم">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Code -->
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                كود الخصم <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="code" name="code" value="{{ old('code') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-orange focus:border-brand-orange @error('code') border-red-500 @enderror"
                                placeholder="مثال: MOTHERSDAY2024">
                            @error('code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type and Value -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                    نوع الخصم <span class="text-red-500">*</span>
                                </label>
                                <select id="type" name="type"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-orange focus:border-brand-orange @error('type') border-red-500 @enderror">
                                    <option value="">اختر نوع الخصم</option>
                                    <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>نسبة
                                        مئوية (%)</option>
                                    <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>مبلغ ثابت ( ريال
                                        يمني)</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="value" class="block text-sm font-medium text-gray-700 mb-2">
                                    قيمة الخصم <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="value" name="value" step="0.01" min="0"
                                    value="{{ old('value') }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-orange focus:border-brand-orange @error('value') border-red-500 @enderror"
                                    placeholder="مثال: 10">
                                @error('value')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Min Order Amount and Max Discount Amount -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="min_order_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                    الحد الأدنى للطلب ( ر.ي)
                                </label>
                                <input type="number" id="min_order_amount" name="min_order_amount" step="0.01" min="0"
                                    value="{{ old('min_order_amount') }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-orange focus:border-brand-orange @error('min_order_amount') border-red-500 @enderror"
                                    placeholder="مثال: 100">
                                @error('min_order_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="max_discount_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                    الحد الأقصى للخصم (ر.ي)
                                </label>
                                <input type="number" id="max_discount_amount" name="max_discount_amount" step="0.01"
                                    min="0" value="{{ old('max_discount_amount') }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-orange focus:border-brand-orange @error('max_discount_amount') border-red-500 @enderror"
                                    placeholder="مثال: 50">
                                @error('max_discount_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Start Date and End Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    تاريخ البداية <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" id="start_date" name="start_date"
                                    value="{{ old('start_date') }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-orange focus:border-brand-orange @error('start_date') border-red-500 @enderror">
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    تاريخ النهاية <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" id="end_date" name="end_date" value="{{ old('end_date') }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-orange focus:border-brand-orange @error('end_date') border-red-500 @enderror">
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Usage Limit -->
                        <div>
                            <label for="usage_limit" class="block text-sm font-medium text-gray-700 mb-2">
                                عدد مرات الاستخدام المسموح بها
                            </label>
                            <input type="number" id="usage_limit" name="usage_limit" min="0"
                                value="{{ old('usage_limit') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-orange focus:border-brand-orange @error('usage_limit') border-red-500 @enderror"
                                placeholder="اتركه فارغاً لعدد غير محدود">
                            @error('usage_limit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Applicable Products -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                المنتجات المطبق عليها الخصم
                            </label>
                            <div class="text-sm text-gray-500 mb-3">
                                اتركه فارغاً لتطبيق الخصم على جميع المنتجات
                            </div>
                            <select id="applicable_products" name="applicable_products[]" multiple
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-orange focus:border-brand-orange @error('applicable_products') border-red-500 @enderror">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ in_array($product->id, old('applicable_products', [])) ? 'selected' : '' }}>
                                        {{ $product->name }} ({{ $product->price }} ر.ي)
                                    </option>
                                @endforeach
                            </select>
                            @error('applicable_products')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-4 space-x-reverse pt-6">
                            <a href="{{ route('vendor.discounts.index') }}"
                                class="px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg shadow-md hover:bg-gray-400">
                                إلغاء
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-brand-orange-700">
                                حفظ الخصم
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-generate discount code
        document.getElementById('title').addEventListener('input', function () {
            const title = this.value;
            const codeInput = document.getElementById('code');
            if (!codeInput.value) {
                codeInput.value = title.replace(/\s+/g, '').toUpperCase().substring(0, 10);
            }
        });

        // Initialize Select2 for products
        $(document).ready(function () {
            $('#applicable_products').select2({
                placeholder: 'اختر المنتجات المطبق عليها الخصم',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
</x-vendor-layout>