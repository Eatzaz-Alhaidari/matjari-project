<x-vendor-layout>
    <x-slot name="title">
        إضافة إعلان جديد
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-black mb-6">إضافة إعلان جديد</h2>

                    <form action="{{ route('vendor.advertisements.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div>
                                <x-input-label for="title" :value="__('عنوان الإعلان')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                    :value="old('title')" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('الحالة')" />
                                <select id="status" name="status"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>
                                        في الانتظار</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>معطل
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Start Date -->
                            <div>
                                <x-input-label for="start_date" :value="__('تاريخ البداية')" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date"
                                    :value="old('start_date')" required />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            <!-- End Date -->
                            <div>
                                <x-input-label for="end_date" :value="__('تاريخ النهاية')" />
                                <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date"
                                    :value="old('end_date')" required />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>

                            <!-- Budget -->
                            <div>
                                <x-input-label for="budget" :value="__('الميزانية (                                            ر.ي)')" />
                                <x-text-input id="budget" class="block mt-1 w-full" type="number" step="0.01"
                                    name="budget" :value="old('budget', 0)" required />
                                <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                            </div>

                            <!-- Target URL -->
                            <div>
                                <x-input-label for="target_url" :value="__('رابط الهدف (اختياري)')" />
                                <x-text-input id="target_url" class="block mt-1 w-full" type="url" name="target_url"
                                    :value="old('target_url')" placeholder="https://example.com" />
                                <x-input-error :messages="$errors->get('target_url')" class="mt-2" />
                            </div>

                            <!-- Image -->
                            <div class="md:col-span-2">
                                <x-input-label for="image" :value="__('صورة الإعلان')" />
                                <input type="file" id="image" name="image"
                                    class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100" />
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">الصورة اختيارية، الحد الأقصى للحجم 2 ميجابايت</p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <x-input-label for="description" :value="__('وصف الإعلان')" />
                            <textarea id="description" name="description" rows="4"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="اكتب وصفاً مفصلاً للإعلان...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('vendor.advertisements.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900 ml-4">إلغاء</a>
                            <x-primary-button class="ml-4">
                                {{ __('حفظ الإعلان') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>