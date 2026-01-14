<x-vendor-layout>
    <x-slot name="title">
        استيراد المخزون - الخطوة 1
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-6">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900">استيراد المنتجات</h2>
                            <p class="text-gray-500 mt-1 text-sm">قم برفع ملف CSV لتحديث المخزون والأسعار</p>
                        </div>
                        <a href="{{ route('vendor.warehouse.index') }}"
                            class="flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>العودة للمخزن</span>
                        </a>
                    </div>

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 border-r-4 border-red-500 text-red-700 flex items-center">
                            <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Download Template Card -->
                    <div
                        class="mb-10 p-6 bg-brand-orange/5 rounded-2xl border border-brand-orange/10 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center ml-4">
                                <svg class="w-6 h-6 text-brand-orange" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">قالب الاستيراد</h4>
                                <p class="text-sm text-gray-500">حمل الملف التدريبي لتعبئة بياناتك بشكل صحيح</p>
                            </div>
                        </div>
                        <a href="{{ route('vendor.warehouse.download-template') }}"
                            class="px-5 py-2.5 bg-brand-orange text-white text-sm font-bold rounded-xl shadow-lg shadow-brand-orange/20 hover:bg-brand-orange-700 transition-all flex items-center">
                            <span>تحميل القالب</span>
                        </a>
                    </div>

                    <!-- Upload Form -->
                    <form action="{{ route('vendor.warehouse.upload-csv') }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="relative group">
                            <label class="block text-sm font-bold text-gray-700 mb-2">اختر ملف CSV للمتابعة</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-10 pb-10 border-2 border-gray-200 border-dashed rounded-2xl hover:border-brand-orange transition-colors bg-gray-50/50 group-hover:bg-white relative">
                                <div class="space-y-2 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 group-hover:text-brand-orange transition-colors"
                                        stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="csv_file"
                                            class="relative cursor-pointer font-bold text-brand-orange hover:underline focus-within:outline-none">
                                            <span>اضغط لرفع الملف</span>
                                            <input id="csv_file" name="csv_file" type="file" class="sr-only"
                                                accept=".csv" required>
                                        </label>
                                        <p class="pr-1">أو اسحب الملف هنا</p>
                                    </div>
                                    <p class="text-xs text-gray-400">CSV فقط (الحد الأقصى 5MB)</p>
                                </div>
                            </div>
                            @error('csv_file')
                                <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="file-name-display"
                            class="hidden animate-fade-in p-3 bg-green-50 rounded-xl text-green-700 text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span id="selected-file-name"></span>
                        </div>

                        <div class="flex justify-center pt-4">
                            <button type="submit"
                                class="w-full sm:w-64 px-8 py-4 bg-gray-900 text-white font-bold rounded-2xl hover:bg-black transform transition-active active:scale-95 shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                مطابقة الحقول والمتابعة
                            </button>
                        </div>
                    </form>

                    <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100">
                            <h5 class="font-bold text-gray-900 mb-3 flex items-center">
                                <span
                                    class="w-6 h-6 bg-brand-orange/10 text-brand-orange rounded-full flex items-center justify-center text-xs ml-2">1</span>
                                رفع الملف
                            </h5>
                            <p class="text-gray-500 leading-relaxed italic">ارفع ملفك المنسق بشكل صحيح وسنقوم بقرائته
                                تلقائياً.</p>
                        </div>
                        <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100">
                            <h5 class="font-bold text-gray-900 mb-3 flex items-center">
                                <span
                                    class="w-6 h-6 bg-brand-orange/10 text-brand-orange rounded-full flex items-center justify-center text-xs ml-2">2</span>
                                مطابقة الأعمدة
                            </h5>
                            <p class="text-gray-500 leading-relaxed italic">ستقوم بربط كل عمود في ملفك مع الحقل المناسب
                                في متجرك.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('csv_file').addEventListener('change', function (e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : '';
            const display = document.getElementById('file-name-display');
            if (fileName) {
                display.classList.remove('hidden');
                document.getElementById('selected-file-name').textContent = fileName;
            } else {
                display.classList.add('hidden');
            }
        });
    </script>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</x-vendor-layout>