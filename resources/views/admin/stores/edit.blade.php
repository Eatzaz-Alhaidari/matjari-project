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
                            <a href="{{ route('admin.vendors.edit', $store->user_id) }}" class="font-semibold text-brand-blue hover:underline">
                                {{ $store->user->name }}
                            </a>
                        </p>
                    </div>

                    <form action="{{ route('admin.stores.update', $store->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">اسم المتجر</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $store->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="commercial_registration" class="block font-medium text-sm text-gray-700">رقم السجل التجاري</label>
                                <input id="commercial_registration" type="text" name="commercial_registration" value="{{ old('commercial_registration', $store->commercial_registration) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <x-input-error :messages="$errors->get('commercial_registration')" class="mt-2" />
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="address" class="block font-medium text-sm text-gray-700">عنوان المتجر</label>
                                <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('address', $store->address) }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="block font-medium text-sm text-gray-700">وصف المتجر</label>
                                <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $store->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 border-t pt-6">
                            <a href="{{ route('admin.stores.index') }}" class="px-5 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-200">إلغاء</a>
                            <button type="submit" class="mr-4 px-6 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-opacity-90">حفظ التغييرات</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>