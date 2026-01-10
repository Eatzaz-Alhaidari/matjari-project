<x-admin-layout>
    <x-slot name="title">
        إدارة طرق الدفع
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Header -->
                    <div class="mb-8 flex justify-between items-center border-b border-gray-100 pb-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">إدارة طرق الدفع</h2>
                            <p class="text-gray-600 mt-2">تفعيل وتعطيل خيارات الدفع المتاحة في التطبيق</p>
                        </div>
                    </div>

                    @if (session('success'))
                        <div
                            class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.payment-gateways.store') }}" method="POST">
                        @csrf
                        <div class="space-y-8">

                            <!-- 1. الدفع عند الاستلام -->
                            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-blue-100 rounded-lg text-blue-600">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-800">الدفع عند الاستلام (COD)</h3>
                                            <p class="text-sm text-gray-500">يتيح للعميل الدفع نقدًا عند استلام الطلب من المندوب.</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="payment_cod_enabled" value="1" class="sr-only peer" 
                                            {{ ($settings['payment_cod_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- 2. المحفظة (جيب) -->
                            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-purple-100 rounded-lg text-purple-600">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-800">المحفظة الإلكترونية (جـيب)</h3>
                                            <p class="text-sm text-gray-500">يتيح للعميل الدفع باستخدام رصيده الحالي في التطبيق.</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="payment_jeeb_enabled" value="1" class="sr-only peer"
                                            {{ ($settings['payment_jeeb_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- 3. التحويل البنكي -->
                            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-green-100 rounded-lg text-green-600">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-800">التحويل البنكي / الإيداع</h3>
                                            <p class="text-sm text-gray-500">يتيح للعميل إرفاق صورة الحوالة، ويتم تأكيد الطلب يدويًا من قبل الإدارة.</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="payment_transfer_enabled" value="1" class="sr-only peer"
                                            id="toggle-transfer"
                                            {{ ($settings['payment_transfer_enabled'] ?? '0') == '1' ? 'checked' : '' }}
                                            onchange="document.getElementById('bank-details').style.display = this.checked ? 'block' : 'none'">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                    </label>
                                </div>

                                <!-- Bank Details Form -->
                                <div id="bank-details" class="border-t border-gray-200 mt-6 pt-6" style="{{ ($settings['payment_transfer_enabled'] ?? '0') == '1' ? '' : 'display: none;' }}">
                                    <h4 class="font-bold text-gray-700 mb-4">بيانات الحساب البنكي (تظهر للعميل):</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">اسم البنك / المصرف</label>
                                            <input type="text" name="bank_name" value="{{ $settings['bank_name'] ?? '' }}" placeholder="مثال: بنك الكريمي / بنك اليمن الدولي"
                                                class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">اسم صاحب الحساب</label>
                                            <input type="text" name="bank_account_name" value="{{ $settings['bank_account_name'] ?? '' }}" placeholder="الاسم الظاهر في الحساب"
                                                class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">رقم الحساب</label>
                                            <input type="text" name="bank_account_number" value="{{ $settings['bank_account_number'] ?? '' }}" 
                                                class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" dir="ltr">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">IBAN / ملاحظات إضافية</label>
                                            <input type="text" name="bank_iban" value="{{ $settings['bank_iban'] ?? '' }}" 
                                                class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500" dir="ltr">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                class="px-6 py-3 bg-gray-800 text-white font-bold rounded-lg shadow hover:bg-gray-700 transition-colors">
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
