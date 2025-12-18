<x-vendor-layout>
    <x-slot name="title">
        إعدادات المتجر
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-black">إعدادات المتجر</h2>
                        <a href="{{ route('vendor.dashboard') }}"
                            class="px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700">
                            العودة للوحة التحكم
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 px-4 py-2 bg-red-100 border border-red-200 text-red-700 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('vendor.store.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- اسم المتجر -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">اسم المتجر</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $store->name) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-orange focus:border-brand-orange"
                                    required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- الوصف -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">وصف
                                    المتجر</label>
                                <textarea name="description" id="description" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-orange focus:border-brand-orange">{{ old('description', $store->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- السجل التجاري -->
                            <div>
                                <label for="commercial_registration"
                                    class="block text-sm font-medium text-gray-700">السجل التجاري</label>
                                <input type="text" name="commercial_registration" id="commercial_registration"
                                    value="{{ old('commercial_registration', $store->commercial_registration) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-orange focus:border-brand-orange">
                                @error('commercial_registration')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- العنوان -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">العنوان</label>
                                <input type="text" name="address" id="address"
                                    value="{{ old('address', $store->address) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-orange focus:border-brand-orange">
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- شعار المتجر -->
                            <div class="md:col-span-2">
                                <label for="logo_path" class="block text-sm font-medium text-gray-700">شعار
                                    المتجر</label>
                                <div class="mt-1 flex items-center">
                                    @if($store->logo_path)
                                        <img src="{{ asset('storage/' . $store->logo_path) }}" alt="شعار المتجر"
                                            class="w-20 h-20 object-cover rounded-lg mr-4">
                                    @endif
                                    <input type="file" name="logo_path" id="logo_path" accept="image/*"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-orange file:text-white hover:file:bg-brand-orange-700">
                                </div>
                                <p class="mt-1 text-sm text-gray-500">PNG, JPG, GIF حتى 2MB</p>
                                @error('logo_path')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- أزرار الإجراءات -->
                        <div class="mt-8 flex justify-end space-x-4 space-x-reverse">
                            <a href="{{ route('vendor.dashboard') }}"
                                class="px-6 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 transition-colors">
                                إلغاء
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-brand-orange-700 transition-colors">
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>