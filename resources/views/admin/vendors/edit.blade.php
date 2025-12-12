<x-admin-layout>
    <x-slot name="title">
        تعديل بيانات البائع: {{ $vendor->name }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">
                    
                    <form action="{{ route('admin.vendors.update', $vendor->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- User Details -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-bold text-brand-blue-800 border-b pb-2 mb-4">معلومات البائع الشخصية</h3>
                            </div>

                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">اسم البائع</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $vendor->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                             <div>
                                <label for="email" class="block font-medium text-sm text-gray-700">البريد الإلكتروني</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $vendor->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <label for="phone" class="block font-medium text-sm text-gray-700">رقم الهاتف</label>
                                <input id="phone" type="text" name="phone" value="{{ old('phone', $vendor->phone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="block font-medium text-sm text-gray-700">صورة الملف الشخصي</label>
                                <div class="mt-2 flex items-center space-x-6 space-x-reverse">
                                    <div class="shrink-0">
                                        <img class="h-16 w-16 object-cover rounded-full" 
                                             src="{{ $vendor->profile_photo_path ? asset('storage/' . $vendor->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode($vendor->name) }}" 
                                             alt="{{ $vendor->name }}" />
                                    </div>
                                    <label class="block">
                                        <span class="sr-only">اختر صورة الملف الشخصي</span>
                                        <input type="file" name="profile_photo" class="block w-full text-sm text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100
                                        "/>
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                            </div>
                            
                             <!-- Store Details -->
                            <div class="md:col-span-2 mt-6">
                                <h3 class="text-lg font-bold text-brand-blue-800 border-b pb-2 mb-4">معلومات المتجر</h3>
                            </div>

                            <div>
                                <label for="store_name" class="block font-medium text-sm text-gray-700">اسم المتجر</label>
                                <input id="store_name" type="text" name="store_name" value="{{ old('store_name', $vendor->store?->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="commercial_registration" class="block font-medium text-sm text-gray-700">رقم السجل التجاري</label>
                                <input id="commercial_registration" type="text" name="commercial_registration" value="{{ old('commercial_registration', $vendor->store?->commercial_registration) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <x-input-error :messages="$errors->get('commercial_registration')" class="mt-2" />
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="address" class="block font-medium text-sm text-gray-700">عنوان المتجر</label>
                                <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('address', $vendor->store?->address) }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="block font-medium text-sm text-gray-700">وصف المتجر</label>
                                <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description', $vendor->store?->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                            
                        </div>

                        <div class="flex items-center justify-end mt-8 border-t pt-6">
                            <a href="{{ route('admin.vendors.index') }}" class="px-5 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                                إلغاء
                            </a>

                            <button type="submit" class="mr-4 px-6 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2">
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>