<x-admin-layout>
    <x-slot name="title">
        إضافة محفظة جديدة
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Header -->
                    <div class="mb-4">
                        <h2 class="text-2xl font-bold text-gray-800">إضافة محفظة جديدة</h2>
                    </div>

                    <form action="{{ route('admin.electronic-wallets.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Info -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">اسم المحفظة</label>
                                <input type="text" name="wallet_name" value="{{ old('wallet_name') }}" required
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">الشركة المزودة
                                    (Provider)</label>
                                <input type="text" name="provider" value="{{ old('provider') }}" required
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">رقم التاجر (Merchant
                                    Number)</label>
                                <input type="text" name="merchant_number" value="{{ old('merchant_number') }}" required
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">الرصيد الافتتاحي
                                    (Balance)</label>
                                <input type="number" step="0.01" name="balance" value="{{ old('balance', 0) }}" required
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">الشعار</label>
                                <input type="file" name="wallet_logo" accept="image/*"
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Address / Transfer Info -->
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">عنوان التحويل (مثال: رقم
                                    الهاتف أو حساب المحفظة)</label>
                                <input type="text" name="address" value="{{ old('address') }}" required
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">تعليمات الدفع (تظهر
                                    للعميل)</label>
                                <textarea name="payment_instructions" rows="3"
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('payment_instructions') }}</textarea>
                            </div>

                            <!-- Settings -->
                            <div class="col-span-1 md:col-span-2 border-t pt-4 mt-2">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">إعدادات الدفع</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">نطاق العمل (Payment
                                    Mode)</label>
                                <select name="payment_mode" id="payment_mode" required
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="manual" {{ old('payment_mode') == 'manual' ? 'selected' : '' }}>يدوي
                                        (Manual)</option>
                                    <option value="api" {{ old('payment_mode') == 'api' ? 'selected' : '' }}>ربط مباشر
                                        (API)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">طريقة التحقق</label>
                                <select name="verification_method" id="verification_method" required
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="manual" {{ old('verification_method') == 'manual' ? 'selected' : '' }}>
                                        يدوي (من الأدمن)</option>
                                    <option value="automatic" {{ old('verification_method') == 'automatic' ? 'selected' : '' }}>تلقائي (Automatic)</option>
                                </select>
                            </div>

                            <!-- API Fields (Hidden by default unless API is selected) -->
                            <div id="api_fields"
                                class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-lg"
                                style="display: none;">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">API Key</label>
                                    <input type="text" name="api_key" value="{{ old('api_key') }}"
                                        class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Verify API URL</label>
                                    <input type="url" name="verify_api_url" value="{{ old('verify_api_url') }}"
                                        class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label class="flex items-center space-x-3 space-x-reverse">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="text-sm font-medium text-gray-700">تفعيل هذه المحفظة</span>
                                </label>
                            </div>

                        </div>

                        <div class="mt-8 flex justify-end gap-3">
                            <a href="{{ route('admin.electronic-wallets.index') }}"
                                class="px-6 py-2 bg-gray-300 text-gray-700 font-bold rounded-lg shadow hover:bg-gray-400 transition">
                                إلغاء
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg shadow hover:bg-blue-700 transition">
                                حفظ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modeSelect = document.getElementById('payment_mode');
            const apiFields = document.getElementById('api_fields');

            function toggleApiFields() {
                if (modeSelect.value === 'api') {
                    apiFields.style.display = 'grid';
                } else {
                    apiFields.style.display = 'none';
                }
            }

            modeSelect.addEventListener('change', toggleApiFields);

            // Initial check
            toggleApiFields();
        });
    </script>
</x-admin-layout>