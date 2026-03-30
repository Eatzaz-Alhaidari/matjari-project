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

                    <!-- قسم الربط البرمجي API -->
                    <div class="mt-12 pt-8 border-t border-gray-200 bg-gray-50 p-6 rounded-lg shadow-inner">
                        <div class="flex items-center space-x-3 space-x-reverse mb-4">
                            <svg class="w-6 h-6 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                            <h3 class="text-xl font-bold text-gray-800">الربط البرمجي للمخزون (API Synchronization)</h3>
                        </div>
                        <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                            استخدم هذا الرمز السري (Token) لربط برنامج المبيعات التابع لك (الديسكتوب) بالمتجر الإلكتروني لتحديث كميات المخزون والمنتجات بشكل مباشر، تلقائي، وآمن.
                        </p>
                        
                        @if (session('api_token'))
                            <div class="mb-6 p-5 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-md rounded-l-md shadow-sm" dir="ltr">
                                <p class="text-sm font-bold text-yellow-800 text-right mb-3">⚠️ يرجى نسخ هذا الرمز والاحتفاظ به في إعدادات برنامج المبيعات، لأنه لن يتم عرضه مرة أخرى:</p>
                                <div class="relative">
                                    <input type="text" readonly value="{{ session('api_token') }}" class="w-full bg-white border border-yellow-300 rounded-md py-3 px-4 text-sm font-mono text-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-400" onclick="this.select();">
                                </div>
                            </div>
                        @else
                            <div class="mb-6 p-4 bg-white border border-gray-200 rounded-md">
                                <p class="text-sm text-gray-500 text-center">الرمز السري مخفي لدواعي أمنية. إذا لم يكن لديك الرمز أو فقدته، اضغط على رز "إصدار مفتاح جديد".</p>
                            </div>
                        @endif

                        <form action="{{ route('vendor.store.generate-token') }}" method="POST" class="flex flex-col items-start">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gray-800 text-white font-semibold rounded-lg shadow-md hover:bg-gray-900 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                إصدار مفتاح ربط جديد (Generate Token)
                            </button>
                            <p class="mt-3 text-xs text-red-500 font-medium">ملاحظة تحذيرية: إصدار مفتاح جديد سيتسبب في إبطال عمل أي مفاتيح سابقة تستخدمها في تطبيقك حالياً.</p>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>