<x-vendor-layout>
    <x-slot name="title">رسائل العملاء</x-slot>

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 px-2">
        <div>
            <h1 class="text-3xl font-black text-gray-800 tracking-tight">رسائل العملاء</h1>
            <p class="text-gray-500 mt-2 font-medium">متابعة رسائل واستفسارات العملاء والتفاعل معهم بحرية.</p>
        </div>
    </div>

    <!-- Messages Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
        <div class="absolute top-0 right-0 w-2 h-full bg-brand-orange"></div>
        
        <div class="p-6">
            <div class="space-y-4">
                @forelse($messages as $message)
                    <div class="p-5 rounded-xl border border-slate-100 hover:border-brand-orange/30 hover:bg-orange-50/20 transition-all duration-300 relative group">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-orange-100 text-brand-orange flex items-center justify-center font-bold text-lg">
                                    {{ mb_substr($message->customer_name ?? 'ع', 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-gray-800">{{ $message->customer_name ?? 'عميل' }}</h4>
                                    <span class="text-xs font-semibold text-gray-500 flex items-center gap-1 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $message->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="pr-14">
                            <p class="text-sm font-medium text-gray-700 leading-relaxed bg-slate-50 p-4 rounded-lg rounded-tr-none border border-slate-100">
                                {{ $message->message }}
                            </p>
                        </div>
                        
                        @if(!$message->is_read)
                            <span class="absolute top-5 left-5 w-3 h-3 bg-brand-orange rounded-full shadow-sm shadow-orange-200"></span>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-20">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-dashed border-slate-200">
                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">لا توجد رسائل رسائل حالياً</h3>
                        <p class="text-gray-500 font-medium">الرسائل الجديدة من العملاء ستظهر هنا</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $messages->links() }}
            </div>
        </div>
    </div>
</x-vendor-layout>
