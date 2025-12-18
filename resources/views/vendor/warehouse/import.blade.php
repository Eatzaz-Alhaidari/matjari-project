<x-vendor-layout>
    <x-slot name="title">
        استيراد المخزون
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">استيراد المخزون من ملف CSV</h2>
                        <a href="{{ route('vendor.warehouse.index') }}"
                            class="px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700">
                            العودة
                        </a>
                    </div>

                    <div class="mb-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4" role="alert">
                        <p class="font-bold">تعليمات الاستيراد</p>
                        <p>يجب أن يكون الملف بصيغة CSV ويحتوي على عمودين فقط بالترتيب التالي:</p>
                        <ul class="list-disc list-inside mt-2">
                            <li>العمود الأول: رقم المنتج (Product ID)</li>
                            <li>العمود الثاني: الكمية الجديدة (Stock Quantity)</li>
                        </ul>
                        <p class="mt-2 text-sm text-gray-600">مثال: 101,50</p>
                    </div>

                    <form action="{{ route('vendor.warehouse.process-import') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="file">
                                اختر ملف CSV
                            </label>
                            <input type="file" name="file" id="file" accept=".csv, .txt" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('file')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit"
                                class="bg-brand-orange hover:bg-brand-orange-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                استيراد وتحديث
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>