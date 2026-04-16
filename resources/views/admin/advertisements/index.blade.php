<x-admin-layout>
    <x-slot name="title">
        إدارة العروض والإعلانات
    </x-slot>

    <div class="py-6" x-data="{ rejectAdId: null, rejectAdTitle: '', rejectionReason: '' }">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100 font-cairo">
                <div class="p-6 bg-white border-b border-gray-100">
                    
                    <!-- Filters & Header -->
                    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <h2 class="text-2xl font-black text-brand-blue-900">
                            {{ $status == 'pending' ? 'طلبات العروض المعلقة' : 'قائمة العروض والإعلانات' }}
                        </h2>
                        
                        <div class="flex flex-col items-end gap-3 w-full md:w-auto">
                            <!-- Add Button (Now Above) -->
                            <a href="{{ route('admin.advertisements.create') }}" class="px-5 py-2.5 bg-brand-blue text-white font-black rounded-xl shadow-lg shadow-brand-blue/20 hover:bg-brand-blue-600 hover:-translate-y-0.5 active:scale-95 transition-all duration-300 flex items-center gap-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                إضافة إعلان جديد
                            </a>

                            <!-- Filters (Now Below) -->
                            <div class="inline-flex p-1 bg-gray-100/80 backdrop-blur-sm rounded-xl shadow-inner border border-gray-200/50">
                                <a href="{{ route('admin.advertisements.index', ['status' => 'all']) }}" 
                                   class="px-4 py-1.5 rounded-lg text-[13px] font-black transition-all duration-300 {{ $status == 'all' ? 'bg-brand-blue text-white shadow-md' : 'text-gray-500 hover:text-brand-blue' }}">
                                    الكل
                                </a>
                                <a href="{{ route('admin.advertisements.index', ['status' => 'pending']) }}" 
                                   class="px-4 py-1.5 rounded-lg text-[13px] font-black transition-all duration-300 flex items-center gap-2 {{ $status == 'pending' ? 'bg-amber-500 text-white shadow-md' : 'text-gray-500 hover:text-amber-600' }}">
                                    <span>طلبات الانتظار</span>
                                    @php $pendingCount = \App\Models\Advertisement::where('status', 0)->count(); @endphp
                                    @if($pendingCount > 0)
                                        <span class="bg-red-500 text-white text-[9px] px-1.5 py-0.5 rounded-full ring-1 ring-white animate-pulse">{{ $pendingCount }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('admin.advertisements.index', ['status' => 'active']) }}" 
                                   class="px-4 py-1.5 rounded-lg text-[13px] font-black transition-all duration-300 {{ $status == 'active' ? 'bg-emerald-600 text-white shadow-md' : 'text-gray-500 hover:text-emerald-600' }}">
                                    النشطة حالياً
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm transition-all duration-300">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-brand-blue-50/50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-black text-brand-blue-800 uppercase tracking-wider">
                                        معلومات الإعلان
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-black text-brand-blue-800 uppercase tracking-wider">
                                        المتجر / التاجر
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-black text-brand-blue-800 uppercase tracking-wider">
                                        الفترة الزمنية
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-black text-brand-blue-800 uppercase tracking-wider">
                                        الميزانية
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-black text-brand-blue-800 uppercase tracking-wider">
                                        الحالة
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-black text-brand-blue-800 uppercase tracking-wider">
                                        الإجراءات
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($advertisements as $ad)
                                    <tr class="hover:bg-slate-50 transition-all duration-200 group">
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($ad->image)
                                                    <div class="flex-shrink-0 h-16 w-24 relative overflow-hidden rounded-xl group-hover:shadow-md transition-shadow duration-300">
                                                        <img class="h-16 w-24 object-cover border border-gray-100 shadow-sm transform group-hover:scale-105 transition-transform duration-500" src="{{ Storage::url($ad->image) }}" alt="">
                                                    </div>
                                                @else
                                                    <div class="h-16 w-24 rounded-xl bg-gray-50 flex items-center justify-center border border-dashed border-gray-200 text-gray-300">
                                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div class="mr-4">
                                                    <div class="text-sm font-black text-gray-900 leading-tight group-hover:text-brand-blue transition-colors">
                                                        {{ $ad->title }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-1 max-w-[220px] truncate italic">
                                                        {{ $ad->description }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-right">
                                            <div class="text-sm font-black text-gray-800">{{ $ad->store->name ?? 'بدون متجر' }}</div>
                                            <div class="text-[11px] text-brand-blue-600 mt-1.5 inline-flex items-center gap-1.5 px-2 py-0.5 bg-brand-blue-50 rounded-md">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2.5"/></svg>
                                                {{ $ad->vendor->name ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-right">
                                            <div class="flex flex-col gap-2">
                                                <span class="text-[11px] font-bold text-gray-700 bg-blue-50 px-2 py-1 rounded-lg flex items-center gap-2 border border-blue-100">
                                                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                                                    بدأ: {{ $ad->start_date->format('Y-m-d') }}
                                                </span>
                                                <span class="text-[11px] font-bold text-gray-500 bg-red-50 px-2 py-1 rounded-lg flex items-center gap-2 border border-red-50">
                                                    <span class="w-2 h-2 rounded-full bg-red-400"></span>
                                                    ينتهي: {{ $ad->end_date->format('Y-m-d') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm font-black text-brand-blue-900">
                                            {{ number_format($ad->budget, 2) }} <span class="text-[10px] text-gray-400 font-normal mr-1">ر.ي</span>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-right">
                                            @php
                                                $statusClasses = [
                                                    0 => 'bg-amber-50 text-amber-700 ring-amber-500/30',
                                                    1 => 'bg-emerald-50 text-emerald-700 ring-emerald-500/30',
                                                    2 => 'bg-rose-50 text-rose-700 ring-rose-500/30',
                                                ];
                                                $statusDots = [
                                                    0 => 'bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.5)]',
                                                    1 => 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]',
                                                    2 => 'bg-rose-500 shadow-[0_0_8px_rgba(244,63,94,0.5)]',
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-black shadow-sm ring-1 ring-inset {{ $statusClasses[$ad->status] ?? 'bg-gray-50 text-gray-700 ring-gray-500/30' }}" 
                                                  title="{{ $ad->status === 2 ? 'سبب الرفض: ' . $ad->rejection_reason : '' }}">
                                                <span class="w-2 h-2 rounded-full ml-2 {{ $statusDots[$ad->status] ?? 'bg-gray-500' }}"></span>
                                                {{ $ad->status_text }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center gap-3">
                                                @if($ad->status === 0)
                                                    <form action="{{ route('admin.advertisements.approve', $ad->id) }}" method="POST" class="inline-block"
                                                        data-confirm-title="تفعيل الإعلان"
                                                        data-confirm-text="هل أنت متأكد من مراجعة والموافقة على هذا الإعلان ليكون ظاهراً للعامة؟"
                                                        data-confirm-button="نعم، تفعيل الآن">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="p-2.5 text-white bg-emerald-600 rounded-xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:scale-110 active:scale-95 transition-all duration-200" title="قبول ونشر">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    <button type="button" @click="rejectAdId = {{ $ad->id }}; rejectAdTitle = '{{ $ad->title }}'" 
                                                        class="p-2.5 text-white bg-amber-500 rounded-xl shadow-lg shadow-amber-100 hover:bg-amber-600 hover:scale-110 active:scale-95 transition-all duration-200" title="رفض الإعلان">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                @endif
                                                
                                                <a href="{{ route('admin.advertisements.edit', $ad->id) }}" class="p-2.5 text-brand-blue bg-white border border-gray-100 rounded-xl shadow-sm hover:bg-brand-blue hover:text-white hover:scale-110 active:scale-95 transition-all duration-200" title="تعديل البيانات">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>

                                                <form action="{{ route('admin.advertisements.destroy', $ad->id) }}" method="POST" class="inline-block"
                                                    data-confirm-title="حذف هذا الإعلان؟"
                                                    data-confirm-text="سيتم إزالة هذا العرض نهائياً من قاعدة البيانات ولا يمكن استرجاعه."
                                                    data-confirm-button="نعم، حذف">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2.5 text-white bg-rose-500 rounded-xl shadow-lg shadow-rose-100 hover:bg-rose-600 hover:scale-110 active:scale-95 transition-all duration-200" title="حذف نهائي">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-24 text-center text-gray-500 bg-gray-50/20">
                                            <div class="flex flex-col items-center justify-center animate-fade-in">
                                                <div class="p-5 bg-white rounded-2xl shadow-sm border border-gray-100 mb-5 text-gray-200">
                                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                                    </svg>
                                                </div>
                                                <h3 class="text-2xl font-black text-gray-800">لا توجد بيانات متاحة</h3>
                                                <p class="text-gray-400 mt-2 max-w-sm">لم يتم العثور على أي عروض أو إعلانات في هذا القسم حالياً.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="px-6 py-6 border-t border-gray-50 bg-slate-50/40">
                    <div class="admin-pagination">
                        {{ $advertisements->appends(['status' => $status])->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Rejection Modal -->
        <template x-if="rejectAdId">
            <div class="fixed inset-0 z-[1000] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-md">
                <div @click.away="rejectAdId = null" class="bg-white rounded-[32px] w-full max-w-md shadow-2xl overflow-hidden p-10 animate-in zoom-in duration-300 ring-1 ring-black/5">
                    <div class="flex justify-between items-center mb-8">
                        <div class="bg-amber-50 p-3 rounded-2xl text-amber-600">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <button @click="rejectAdId = null" class="w-10 h-10 flex items-center justify-center bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-500 rounded-full transition-all"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                    <h3 class="text-2xl font-black text-brand-blue-900 mb-2">رفض الإعلان</h3>
                    <p class="text-sm text-gray-500 mb-10 leading-relaxed font-medium">يرجى كتابة سبب الرفض ليتم إرساله للتاجر لصاحب إعلان: <span class="font-black text-brand-blue" x-text="rejectAdTitle"></span>.</p>
                    
                    <form :action="`/admin/advertisements/${rejectAdId}/reject`" method="POST" class="space-y-8">
                        @csrf
                        @method('PATCH')
                        <div class="space-y-3">
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-widest mr-1">سبب الرفض:</label>
                            <textarea name="rejection_reason" required placeholder="مثلاً: الصورة غير مناسبة، أو الرابط لا يعمل..." class="w-full rounded-2xl border-gray-100 bg-gray-50 focus:ring-4 focus:ring-brand-blue/10 focus:border-brand-blue focus:bg-white transition-all py-4 px-6 min-h-[120px]"></textarea>
                        </div>
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="flex-[2] bg-rose-500 text-white font-black py-5 rounded-2xl shadow-xl shadow-rose-100 hover:bg-rose-600 hover:-translate-y-1 transition-all active:scale-95 text-lg">تأكيد الرفض</button>
                            <button type="button" @click="rejectAdId = null" class="flex-1 bg-gray-100 text-gray-600 font-bold py-5 rounded-2xl hover:bg-gray-200 transition-all text-lg">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
</x-admin-layout>