<x-admin-layout>
    <x-slot name="title">
        تعديل بيانات المتجر: {{ $store->name }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">

                    <div class="mb-6">
                        <p class="text-sm text-gray-500">المالك:
                            <a href="{{ route('admin.vendors.edit', $store->user_id) }}"
                                class="font-semibold text-brand-blue hover:underline">
                                {{ $store->user->name }}
                            </a>
                        </p>
                    </div>

                    <form action="{{ route('admin.stores.update', $store->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- 1. قسم المعلومات الأساسية -->
                        <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">1. المعلومات الأساسية</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block font-medium text-sm text-gray-700">اسم المتجر</label>
                                    <input id="name" type="text" name="name" value="{{ old('name', $store->name) }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="slogan" class="block font-medium text-sm text-gray-700">شعار المتجر
                                        (Slogan)</label>
                                    <input id="slogan" type="text" name="slogan"
                                        value="{{ old('slogan', $store->slogan) }}"
                                        placeholder="مثال: وجهتك الأولى للإلكترونيات"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <x-input-error :messages="$errors->get('slogan')" class="mt-2" />
                                </div>

                                <div class="md:col-span-2">
                                    <label for="description" class="block font-medium text-sm text-gray-700">وصف
                                        المتجر</label>
                                    <textarea id="description" name="description" rows="4"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $store->description) }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="commercial_registration"
                                        class="block font-medium text-sm text-gray-700">رقم السجل التجاري</label>
                                    <input id="commercial_registration" type="text" name="commercial_registration"
                                        value="{{ old('commercial_registration', $store->commercial_registration) }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <x-input-error :messages="$errors->get('commercial_registration')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- 2. قسم الهوية البصرية -->
                        <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">2. الهوية البصرية</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="logo" class="block font-medium text-sm text-gray-700">شعار المتجر
                                        (Logo)</label>
                                    @if($store->logo_path)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $store->logo_path) }}" alt="Current Logo"
                                                class="h-16 w-16 object-cover rounded-full border">
                                        </div>
                                    @endif
                                    <input id="logo" type="file" name="logo"
                                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-blue-50 file:text-brand-blue-700 hover:file:bg-brand-blue-100">
                                    <p class="text-xs text-gray-500 mt-1">يفضل أن تكون الصورة مربعة.</p>
                                    <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="cover_image" class="block font-medium text-sm text-gray-700">صورة غلاف
                                        المتجر (Banner)</label>
                                    @if($store->cover_image_path)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $store->cover_image_path) }}"
                                                alt="Current Cover" class="h-20 w-full object-cover rounded-md border">
                                        </div>
                                    @endif
                                    <input id="cover_image" type="file" name="cover_image"
                                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-blue-50 file:text-brand-blue-700 hover:file:bg-brand-blue-100">
                                    <p class="text-xs text-gray-500 mt-1">يفضل أن تكون الصورة عريضة (مثلاً 1200x300).
                                    </p>
                                    <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- 3. قسم الموقع ومعلومات التواصل -->
                        <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">3. الموقع ومعلومات التواصل
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label for="address" class="block font-medium text-sm text-gray-700">عنوان المتجر /
                                        موقع المخزون</label>
                                    <input id="address" type="text" name="address"
                                        value="{{ old('address', $store->address) }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="support_phone" class="block font-medium text-sm text-gray-700">رقم هاتف
                                        دعم المتجر</label>
                                    <input id="support_phone" type="text" name="support_phone"
                                        value="{{ old('support_phone', $store->support_phone) }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <x-input-error :messages="$errors->get('support_phone')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="support_email" class="block font-medium text-sm text-gray-700">البريد
                                        الإلكتروني لدعم المتجر</label>
                                    <input id="support_email" type="email" name="support_email"
                                        value="{{ old('support_email', $store->support_email) }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <x-input-error :messages="$errors->get('support_email')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- 4. قسم السياسات والأنظمة -->
                        <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">4. السياسات والأنظمة</h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="shipping_policy" class="block font-medium text-sm text-gray-700">سياسة
                                        الشحن</label>
                                    <textarea id="shipping_policy" name="shipping_policy" rows="3"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('shipping_policy', $store->shipping_policy) }}</textarea>
                                    <x-input-error :messages="$errors->get('shipping_policy')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="return_policy" class="block font-medium text-sm text-gray-700">سياسة
                                        الإرجاع</label>
                                    <textarea id="return_policy" name="return_policy" rows="3"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('return_policy', $store->return_policy) }}</textarea>
                                    <x-input-error :messages="$errors->get('return_policy')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="accounting_system"
                                        class="block font-medium text-sm text-gray-700">النظام المحاسبي
                                        (اختياري)</label>
                                    <input id="accounting_system" type="text" name="accounting_system"
                                        value="{{ old('accounting_system', $store->accounting_system) }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                        placeholder="مثال: قيود، دفترة...">
                                    <x-input-error :messages="$errors->get('accounting_system')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 border-t pt-6">
                            <a href="{{ route('admin.stores.index') }}"
                                class="px-5 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-200">إلغاء</a>
                            <button type="submit"
                                class="mr-4 px-6 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-opacity-90">حفظ
                                التغييرات</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>