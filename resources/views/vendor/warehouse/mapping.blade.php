<x-vendor-layout>
    <x-slot name="title">
        استيراد المخزون - الخطوة 2
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl">
                <div class="p-10">
                    <div class="mb-10 text-center">
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">مطابقة الأعمدة</h2>
                        <p class="text-gray-500">اختر الحقل المقابل لكل عمود في ملف الـ CSV الخاص بك</p>
                    </div>

                    <form action="{{ route('vendor.warehouse.process-import') }}" method="POST">
                        @csrf
                        <input type="hidden" name="temp_file" value="{{ $temp_file }}">

                        <div class="overflow-x-auto rounded-2xl border border-gray-100 mb-8">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">عمود CSV</th>
                                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-700">← يتم ربطه بـ →</th>
                                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">حقل قاعدة البيانات</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($headers as $index => $header)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center">
                                                <span class="w-8 h-8 bg-brand-orange/10 text-brand-orange font-bold text-xs rounded-lg flex items-center justify-center ml-3">{{ $index + 1 }}</span>
                                                <span class="font-bold text-gray-900">{{ $header }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <svg class="w-6 h-6 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                            </svg>
                                        </td>
                                        <td class="px-6 py-5">
                                            <select name="mapping[{{ $index }}]" 
                                                    class="w-full border-gray-200 rounded-xl focus:border-brand-orange focus:ring-brand-orange transition-all text-sm font-medium">
                                                <option value="">تجاهل هذا العمود</option>
                                                @foreach($dbFields as $field => $label)
                                                    <option value="{{ $field }}" 
                                                        {{ (str_contains(strtolower($header), strtolower($field)) || str_contains($header, explode(' (', $label)[0])) ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Options Section -->
                        <div class="bg-gray-50 rounded-2xl p-8 mb-10 border border-gray-100">
                            <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 ml-2 text-brand-orange" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                </svg>
                                إعدادات الاستيراد
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-4">في حال عدم وجود المنتج (رمز المنتج غير مطابق):</label>
                                    <div class="space-y-4">
                                        <label class="flex items-center p-4 bg-white rounded-xl border border-gray-200 cursor-pointer hover:border-brand-orange transition-all group">
                                            <input type="radio" name="on_missing" value="skip" checked class="text-brand-orange focus:ring-brand-orange ml-4">
                                            <div>
                                                <span class="block font-bold text-gray-900 group-hover:text-brand-orange">تجاهل السطر</span>
                                                <span class="block text-xs text-gray-500 mt-1">لن يتم استيراد أي منتج غير مسجل مسبقاً بكود المنتج</span>
                                            </div>
                                        </label>
                                        <label class="flex items-center p-4 bg-white rounded-xl border border-gray-200 cursor-pointer hover:border-brand-orange transition-all group">
                                            <input type="radio" name="on_missing" value="create" class="text-brand-orange focus:ring-brand-orange ml-4">
                                            <div>
                                                <span class="block font-bold text-gray-900 group-hover:text-brand-orange">إنشاء منتج جديد</span>
                                                <span class="block text-xs text-gray-500 mt-1">سيتم إنشاء سجل جديد بكافة البيانات المتوفرة</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="bg-amber-50 rounded-2xl p-6 border border-amber-100 self-start">
                                    <h5 class="text-amber-800 font-bold mb-3 flex items-center text-sm">
                                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                        تلميحات هامة
                                    </h5>
                                    <ul class="text-amber-900/70 text-xs space-y-2 leading-relaxed">
                                        <li>• تأكد من ربط <b>رمز المنتج</b> بدقة فهو مفتاح التحديث.</li>
                                        <li>• الحقول غير المحددة ستعتمد القيم الحالية في قاعدة البيانات.</li>
                                        <li>• إنشاء منتج جديد يتطلب وجود "اسم المنتج" في الأعمدة.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center bg-gray-900 p-8 rounded-2xl shadow-xl">
                            <div class="text-white/60 text-sm">
                                سيتم إجراء العملية ضمن جلسة أمنة <br> (Database Transaction)
                            </div>
                            <button type="submit" 
                                    class="px-10 py-4 bg-brand-orange text-white font-bold rounded-xl hover:bg-brand-orange-700 transform transition-all hover:scale-105 shadow-xl shadow-brand-orange/30">
                                بدء عملية الاستيراد الآن
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>
