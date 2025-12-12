<x-admin-layout>
    <x-slot name="title">
        إضافة بائع جديد
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">
                    
                    <form action="{{ route('admin.vendors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-bold text-brand-blue-800 border-b pb-2 mb-4">معلومات البائع الشخصية</h3>
                            </div>

                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">اسم البائع</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                             <div>
                                <label for="email" class="block font-medium text-sm text-gray-700">البريد الإلكتروني</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                             <div>
                                <label for="phone" class="block font-medium text-sm text-gray-700">رقم الهاتف</label>
                                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                             <div>
                                <label class="block font-medium text-sm text-gray-700">صورة الملف الشخصي</label>
                                <input type="file" name="profile_photo" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                                <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="password" class="block font-medium text-sm text-gray-700">كلمة المرور</label>
                                <input id="password" type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                             <div class="md:col-span-2">
                                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">تأكيد كلمة المرور</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                             <div class="md:col-span-2 mt-6">
                                <h3 class="text-lg font-bold text-brand-blue-800 border-b pb-2 mb-4">معلومات المتجر</h3>
                            </div>

                            <div>
                                <label for="store_name" class="block font-medium text-sm text-gray-700">اسم المتجر</label>
                                <input id="store_name" type="text" name="store_name" value="{{ old('store_name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="commercial_registration" class="block font-medium text-sm text-gray-700">رقم السجل التجاري</label>
                                <input id="commercial_registration" type="text" name="commercial_registration" value="{{ old('commercial_registration') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <x-input-error :messages="$errors->get('commercial_registration')" class="mt-2" />
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="address" class="block font-medium text-sm text-gray-700">عنوان المتجر</label>
                                <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('address') }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                            
                        </div>

                        <div class="flex items-center justify-end mt-8 border-t pt-6">
                            <a href="{{ route('admin.vendors.index') }}" class="px-5 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-200">إلغاء</a>
                            <button type="submit" class="mr-4 px-6 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-opacity-90">إنشاء بائع</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>