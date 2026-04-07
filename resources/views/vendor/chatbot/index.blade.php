<x-vendor-layout>
    <x-slot name="title">إدارة الردود التلقائية</x-slot>

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 px-2">
        <div>
            <h1 class="text-3xl font-black text-gray-800 tracking-tight">إدارة الردود التلقائية</h1>
            <p class="text-gray-500 mt-2 font-medium">إعداد قواعد متقدمة للرد الذكي على أسئلة العملاء المتكررة.</p>
        </div>
        <a href="{{ route('vendor.dashboard') }}" class="flex items-center text-gray-500 hover:text-brand-orange transition-colors font-bold space-x-2 space-x-reverse">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>العودة للرئيسية</span>
        </a>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
        <div class="absolute top-0 right-0 w-2 h-full bg-brand-orange"></div>
        
        <div class="p-6 md:p-8">
            {{-- Form to add new rule --}}
            <div class="mb-10 bg-slate-50 border border-slate-100 p-6 rounded-2xl">
                <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    إضافة قاعدة رد جديدة
                </h3>
                <form action="{{ route('vendor.chatbot-rules.store') }}" method="POST">
                    @csrf
                    <div class="flex flex-col md:flex-row gap-5 items-start md:items-end">
                        <div class="flex-1 w-full">
                            <label class="block text-sm font-bold text-slate-700 mb-2">الكلمة المفتاحية المسببة للتفعيل:</label>
                            <input type="text" name="trigger_keyword" placeholder="مثال: متوفر، سعر، مقاس" class="w-full text-base rounded-xl border-gray-300 focus:border-brand-orange focus:ring-brand-orange shadow-sm py-3 px-4" required>
                        </div>
                        <div class="flex-[2] w-full">
                            <label class="block text-sm font-bold text-slate-700 mb-2">الرسالة التلقائية المرسلة للعميل:</label>
                            <input type="text" name="response_text" placeholder="اكتب رسالتك التلقائية هنا لتصل للعميل فور رسالته الاستفسارية..." class="w-full text-base rounded-xl border-gray-300 focus:border-brand-orange focus:ring-brand-orange shadow-sm py-3 px-4" required>
                        </div>
                        <button type="submit" class="w-full md:w-auto shrink-0 bg-brand-orange hover:bg-brand-orange-700 text-white font-bold py-3 px-8 rounded-xl shadow-md shadow-brand-orange/20 transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            إضافة القاعدة
                        </button>
                    </div>
                </form>
            </div>

            {{-- List of existing rules (TABLE) --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-right font-bold text-gray-500 uppercase tracking-wider">الكلمة المفتاحية</th>
                            <th class="px-6 py-4 text-right font-bold text-gray-500 uppercase tracking-wider">نص الرد التلقائي</th>
                            <th class="px-6 py-4 text-center font-bold text-gray-500 uppercase tracking-wider w-28">إجراء</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($chatbotRules as $rule)
                            <tr class="hover:bg-orange-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold bg-orange-100 text-orange-800 border border-orange-200 shadow-sm">
                                        {{ $rule->trigger_keyword }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-700 text-base font-medium leading-relaxed">
                                    {{ $rule->response_text }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('vendor.chatbot-rules.destroy', $rule) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600 bg-gray-50 hover:bg-red-50 p-2.5 rounded-xl transition-all duration-200 opacity-0 group-hover:opacity-100 focus:opacity-100 border border-transparent hover:border-red-100" onclick="return confirm('هل أنت متأكد من حذف القاعدة بشكل نهائي؟')" title="حذف القاعدة">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-16 text-center text-gray-500 text-base bg-gray-50/50">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm border border-gray-100">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                        </div>
                                        <p class="font-bold text-gray-700">لا توجد قواعد مبرمجة</p>
                                        <p class="text-sm mt-1 text-gray-500">قم بإضافة قاعدة جديدة عبر النموذج في الأعلى!</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</x-vendor-layout>
