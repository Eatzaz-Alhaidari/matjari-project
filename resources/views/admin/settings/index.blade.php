<x-admin-layout>
    <x-slot name="title">
        إعدادات المنصة
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- 1. General Settings -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">الإعدادات العامة</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">اسم المنصة</label>
                                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">البريد الإلكتروني للدعم</label>
                                <input type="email" name="support_email" value="{{ $settings['support_email'] ?? '' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">رقم الهاتف للتواصل</label>
                                <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">وصف مختصر للمنصة (ميتا
                                    تاج)</label>
                                <textarea name="site_description" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50">{{ $settings['site_description'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Financial Settings -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">الإعدادات المالية</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">نسبة عمولة المنصة (%)</label>
                                <input type="number" step="0.01" name="commission_rate"
                                    value="{{ $settings['commission_rate'] ?? '0' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">الحد الأدنى للسحب (ر.ي)</label>
                                <input type="number" step="0.01" name="min_withdrawal_amount"
                                    value="{{ $settings['min_withdrawal_amount'] ?? '0' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Social Media Links -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">روابط التواصل الاجتماعي</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Facebook</label>
                                <input type="url" name="social_facebook"
                                    value="{{ $settings['social_facebook'] ?? '' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Twitter (X)</label>
                                <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Instagram</label>
                                <input type="url" name="social_instagram"
                                    value="{{ $settings['social_instagram'] ?? '' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-3 bg-brand-blue text-white font-bold rounded-lg shadow-md hover:bg-brand-blue-700 transition">
                        حفظ الإعدادات
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>