<x-admin-layout>
    <x-slot name="title">
        إعدادات الدعم الفني
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Header -->
                    <div class="mb-8 flex justify-between items-center border-b border-gray-100 pb-4">
                        <div>
                            <h2 class="text-2xl font-bold text-brand-blue-800">إعدادات الدعم الفني</h2>
                            <p class="text-gray-600 mt-2">تهيئة قنوات التواصل المباشر مع العملاء</p>
                        </div>
                    </div>


                    <!-- Configuration Form -->
                    <form action="{{ route('admin.support.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- WhatsApp Configuration Section -->
                        <div class="bg-brand-blue-50 p-6 rounded-xl border border-brand-blue-100">
                            <h3 class="text-lg font-bold text-brand-blue-800 mb-4 flex items-center gap-2">
                                <span class="p-1.5 bg-white rounded-md text-brand-blue-600 shadow-sm border border-brand-blue-100">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118 571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                </span>
                                إعدادات واتساب
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="support_whatsapp" class="block text-sm font-bold text-gray-700 mb-2">رقم الهاتف (واتساب)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">
                                                 <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                 </svg>
                                            </span>
                                        </div>
                                        <input type="text" name="support_whatsapp" id="support_whatsapp" 
                                           value="{{ $settings['support_whatsapp'] ?? '778119982' }}"
                                           class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue sm:text-sm text-left"
                                           dir="ltr"
                                           placeholder="Ex: 967778119982">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">يُفضل إدخال الرقم مع مفتاح الدولة (مثال: 967778119982)</p>
                                </div>
                                <div class="flex items-center justify-start md:pt-6">
                                    <div class="bg-white border border-brand-blue-100 text-brand-blue-800 p-4 rounded-lg text-sm w-full shadow-sm">
                                        <p class="font-bold mb-1 flex items-center gap-1">
                                            <svg class="w-4 h-4 text-brand-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            ملاحظة هامة:
                                        </p>
                                        سيتم استخدام هذا الرقم لزر "تواصل معنا" في التطبيق. تأكد من صحة الرقم وأنه يحتوي على حساب واتساب فعال.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="px-6 py-2.5 bg-brand-blue text-white font-bold rounded-lg shadow-md hover:bg-brand-blue-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue">
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>

                    <!-- Related Links -->
                    <div class="mt-10 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-6">روابط سريعة</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <a href="{{ route('admin.complaints.index') }}" class="group block p-4 bg-white border border-gray-200 rounded-lg hover:border-brand-blue-300 hover:shadow-md transition-all">
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-2 text-gray-700 group-hover:text-brand-blue-700 font-medium">
                                        <div class="p-2 bg-gray-100 rounded-full group-hover:bg-brand-blue-50 transition-colors">
                                            <svg class="w-5 h-5 text-gray-500 group-hover:text-brand-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        </div>
                                        <span>إدارة الشكاوى</span>
                                    </span>
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-brand-blue-500 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>