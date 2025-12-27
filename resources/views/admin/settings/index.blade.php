<x-admin-layout>
    <x-slot name="title">
        إعدادات المنصة
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <!-- 1. General Settings -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">الإعدادات العامة</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">اسم المنصة</label>
                                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">وصف المنصة</label>
                                <input type="text" name="site_description"
                                    value="{{ $settings['site_description'] ?? '' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">شعار الموقع (Logo)</label>
                                @if(isset($settings['site_logo']))
                                    <div class="mt-2 mb-2">
                                        <img src="{{ asset('storage/' . $settings['site_logo']) }}"
                                            class="h-16 w-auto object-contain border p-1 rounded">
                                    </div>
                                @endif
                                <input type="file" name="site_logo"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">أيقونة الموقع (Favicon)</label>
                                @if(isset($settings['site_icon']))
                                    <div class="mt-2 mb-2">
                                        <img src="{{ asset('storage/' . $settings['site_icon']) }}"
                                            class="h-8 w-8 object-contain border p-1 rounded">
                                    </div>
                                @endif
                                <input type="file" name="site_icon"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            <div class="flex items-center mt-4 md:col-span-2">
                                <input type="hidden" name="maintenance_mode" value="0">
                                <input type="checkbox" name="maintenance_mode" value="1" id="maintenance_mode" {{ isset($settings['maintenance_mode']) && $settings['maintenance_mode'] == '1' ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-brand-blue shadow-sm focus:ring-brand-blue">
                                <label for="maintenance_mode" class="mr-2 block text-sm text-gray-900">تفعيل وضع
                                    الصيانة</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Market & Commission Settings -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">إعدادات السوق والعمولة</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">نسبة عمولة المنصة (%)</label>
                                <input type="number" name="commission_rate"
                                    value="{{ $settings['commission_rate'] ?? '0' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">سيتم خصم هذه النسبة من كل عملية بيع للبائع.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Approval Settings -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">إعدادات الموافقة والقبول</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex items-center">
                                <input type="hidden" name="auto_approve_vendors" value="0">
                                <input type="checkbox" name="auto_approve_vendors" value="1" id="auto_approve_vendors"
                                    {{ isset($settings['auto_approve_vendors']) && $settings['auto_approve_vendors'] == '1' ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-brand-blue shadow-sm focus:ring-brand-blue">
                                <label for="auto_approve_vendors" class="mr-2 block text-sm text-gray-900">الموافقة
                                    التلقائية على تسجيل البائعين الجدد</label>
                            </div>
                            <div class="flex items-center">
                                <input type="hidden" name="auto_approve_products" value="0">
                                <input type="checkbox" name="auto_approve_products" value="1" id="auto_approve_products"
                                    {{ isset($settings['auto_approve_products']) && $settings['auto_approve_products'] == '1' ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-brand-blue shadow-sm focus:ring-brand-blue">
                                <label for="auto_approve_products" class="mr-2 block text-sm text-gray-900">الموافقة
                                    التلقائية على المنتجات الجديدة</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Contact Info -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">معلومات التواصل والدعم</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">البريد الإلكتروني للدعم</label>
                                <input type="email" name="support_email" value="{{ $settings['support_email'] ?? '' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">رقم الهاتف</label>
                                <input type="text" name="support_phone" value="{{ $settings['support_phone'] ?? '' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pb-8">
                    <button type="submit"
                        class="px-6 py-3 bg-brand-blue text-white font-bold rounded-lg shadow-md hover:bg-brand-blue-700 transition duration-150">
                        حفظ كافة الإعدادات
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-admin-layout>