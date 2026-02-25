<x-admin-layout>
    <x-slot name="title">
        إدارة العروض والإعلانات
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 rounded-md shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100 font-cairo">
                <div class="p-6 bg-white border-b border-gray-100">
                    
                    <!-- Filters & Header -->
                    <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
                        <h2 class="text-2xl font-black text-brand-blue-800">
                            {{ $status == 'pending' ? 'طلبات العروض المعلقة' : 'قائمة العروض والإعلانات' }}
                        </h2>
                        
                        <div class="inline-flex p-1 bg-gray-100 rounded-xl shadow-inner">
                            <a href="{{ route('admin.advertisements.index', ['status' => 'all']) }}" 
                               class="px-5 py-2 rounded-lg text-sm font-bold transition-all duration-200 {{ $status == 'all' ? 'bg-brand-blue text-white shadow-md' : 'text-gray-600 hover:text-brand-blue hover:bg-white/50' }}">
                                الكل
                            </a>
                            <a href="{{ route('admin.advertisements.index', ['status' => 'pending']) }}" 
                               class="px-5 py-2 rounded-lg text-sm font-bold transition-all duration-200 flex items-center gap-2 {{ $status == 'pending' ? 'bg-amber-500 text-white shadow-md' : 'text-gray-600 hover:text-amber-600 hover:bg-white/50' }}">
                                <span>طلبات الانتظار</span>
                                @php $pendingCount = \App\Models\Advertisement::where('status', 0)->count(); @endphp
                                @if($pendingCount > 0)
                                    <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full ring-2 ring-white shadow-sm">{{ $pendingCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('admin.advertisements.index', ['status' => 'active']) }}" 
                               class="px-5 py-2 rounded-lg text-sm font-bold transition-all duration-200 {{ $status == 'active' ? 'bg-emerald-600 text-white shadow-md' : 'text-gray-600 hover:text-emerald-600 hover:bg-white/50' }}">
                                النشطة حالياً
                            </a>
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
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-black shadow-sm ring-1 ring-inset {{ $ad->status === 1 ? 'bg-emerald-50 text-emerald-700 ring-emerald-500/30' : 'bg-amber-50 text-amber-700 ring-amber-500/30' }}">
                                                <span class="w-2 h-2 rounded-full ml-2 {{ $ad->status === 1 ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.5)]' }}"></span>
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
                                                        <button type="submit" class="p-2.5 text-white bg-emerald-600 rounded-xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:scale-110 active:scale-95 transition-all duration-200">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                <form action="{{ route('admin.advertisements.destroy', $ad->id) }}" method="POST" class="inline-block"
                                                    data-confirm-title="حذف هذا الإعلان؟"
                                                    data-confirm-text="سيتم إزالة هذا العرض نهائياً من قاعدة البيانات ولا يمكن استرجاعه."
                                                    data-confirm-button="نعم، حذف">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2.5 text-white bg-rose-500 rounded-xl shadow-lg shadow-rose-100 hover:bg-rose-600 hover:scale-110 active:scale-95 transition-all duration-200">
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
    </div>
</x-admin-layout>