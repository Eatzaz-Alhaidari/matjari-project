<x-admin-layout>
    <x-slot name="title">
        إضافة منتج جديد
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-brand-blue-800 mb-6">إضافة منتج جديد</h2>

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('اسم المنتج')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Brand -->
                            <div>
                                <x-input-label for="brand" :value="__('الماركة')" />
                                <x-text-input id="brand" class="block mt-1 w-full" type="text" name="brand"
                                    :value="old('brand')" />
                                <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                            </div>

                            <!-- Price -->
                            <div>
                                <x-input-label for="price" :value="__('السعر')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01"
                                    name="price" :value="old('price')" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Stock -->
                            <div>
                                <x-input-label for="stock" :value="__('الكمية (المخزون)')" />
                                <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock"
                                    :value="old('stock')" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('الحالة')" />
                                <select id="status" name="status"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>نشط
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>معطل
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Store -->
                            <div>
                                <x-input-label for="store_id" :value="__('المتجر')" />
                                <select id="store_id" name="store_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">اختر المتجر</option>
                                    @foreach($stores as $store)
                                        <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('store_id')" class="mt-2" />
                            </div>

                            <!-- Category -->
                            <div>
                                <x-input-label for="category_id" :value="__('التصنيف')" />
                                <select id="category_id" name="category_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">اختر التصنيف</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <!-- Images -->
                            <div>
                                <x-input-label for="images" :value="__('صور المنتج (يمكنك اختيار أكثر من صورة)')" />
                                <input type="file" id="images" name="images[]" multiple
                                    class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                <x-input-error :messages="$errors->get('images')" class="mt-2" />
                                <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <x-input-label for="description" :value="__('وصف مختصر')" />
                            <textarea id="description" name="description" rows="3"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Full Description -->
                        <div class="mt-6">
                            <x-input-label for="full_description" :value="__('الوصف الكامل')" />
                            <textarea id="full_description" name="full_description" rows="5"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('full_description') }}</textarea>
                            <x-input-error :messages="$errors->get('full_description')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.products.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900 ml-4">إلغاء</a>
                            <x-primary-button class="ml-4">
                                {{ __('حفظ المنتج') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>