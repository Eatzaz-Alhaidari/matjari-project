<x-admin-layout>
    <x-slot name="title">
        إدارة المرتجعات
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-brand-blue-900">طلبات الإرجاع والتعويض</h2>
                        <div class="flex gap-2">
                             <div class="bg-blue-50 text-blue-700 px-4 py-2 rounded-lg text-sm font-semibold border border-blue-100">
                                إجمالي المرتجعات: {{ $returns->total() }}
                             </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        المعلومات
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        العميل
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        المنتج والكمية
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        سبب الإرجاع
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الحالة
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        المخزون
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الإجراءات
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($returns as $return)
                                    <tr class="hover:bg-gray-50 transition border-b border-gray-100">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-brand-blue">#{{ $return->order->id ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-400">{{ $return->created_at->format('Y-m-d') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $return->user->name ?? 'غير معروف' }}</div>
                                            <div class="text-xs text-gray-500">{{ $return->user->email ?? '' }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($return->product)
                                                <div class="text-sm text-gray-900">{{ $return->product->name }}</div>
                                                <div class="text-xs text-blue-600 font-bold">الكمية: {{ $return->quantity }}</div>
                                            @else
                                                <span class="text-gray-400 text-xs">غير محدد</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600 max-w-xs" title="{{ $return->reason }}">
                                                {{Str::limit($return->reason, 40)}}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $colors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                                    'approved' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                                    'rejected' => 'bg-red-100 text-red-800 border border-red-200',
                                                    'refunded' => 'bg-green-100 text-green-800 border border-green-200',
                                                ];
                                                $labels = [
                                                    'pending' => 'قيد الانتظار',
                                                    'approved' => 'مقبول',
                                                    'rejected' => 'مرفوض',
                                                    'refunded' => 'تم الاسترداد',
                                                ];
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $colors[$return->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $labels[$return->status] ?? $return->status }}
                                            </span>
                                            @if($return->refund_amount > 0)
                                                <div class="text-[10px] text-green-600 font-bold mt-1">مسترد: {{ number_format($return->refund_amount, 2) }} ر.ي</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            @if($return->is_restocked)
                                                <span class="text-green-600 flex items-center gap-1 text-xs font-bold">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    تمت الإعادة
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">بانتظار الإجراء</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center gap-3">
                                                <button onclick="document.getElementById('editReturn{{ $return->id }}').showModal()"
                                                    class="text-brand-blue hover:text-blue-900 flex flex-col items-center transition" title="تحديث الحالة">
                                                    <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    <span class="text-[10px]">تعديل</span>
                                                </button>

                                                @if($return->status == 'approved' && !$return->is_restocked && $return->product_id)
                                                    <form action="{{ route('admin.returns.restock', $return) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-orange-600 hover:text-orange-800 flex flex-col items-center transition" 
                                                            onclick="return confirm('هل أنت متأكد من إعادة المنتج للمخزون؟')" title="إعادة للمخزون">
                                                            <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                            <span class="text-[10px]">إعادة مخزون</span>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>

                                            <!-- Update Modal -->
                                            <dialog id="editReturn{{ $return->id }}" class="modal">
                                                <div class="modal-box bg-white text-right max-w-md">
                                                    <h3 class="font-bold text-xl mb-6 text-brand-blue border-b pb-3 flex items-center gap-2">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                                        إجراءات المرتجع #{{ $return->id }}
                                                    </h3>
                                                    <form action="{{ route('admin.returns.updateStatus', $return) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        
                                                        <div class="space-y-5">
                                                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 mb-4">
                                                                <div class="text-xs text-gray-500 mb-1">سبب العميل:</div>
                                                                <div class="text-sm italic text-gray-700">"{{ $return->reason }}"</div>
                                                            </div>

                                                            <div>
                                                                <label class="block text-sm font-bold text-gray-700 mb-2">تحديث الحالة</label>
                                                                <select name="status" class="w-full rounded-xl border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 transition-all text-sm">
                                                                    <option value="pending" {{ $return->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                                                    <option value="approved" {{ $return->status == 'approved' ? 'selected' : '' }}>مقبول - بانتظار الإرجاع/الاسترداد</option>
                                                                    <option value="refunded" {{ $return->status == 'refunded' ? 'selected' : '' }}>تم التعويض واسترجاع المبلغ</option>
                                                                    <option value="rejected" {{ $return->status == 'rejected' ? 'selected' : '' }}>مرفوض - الطلب غير صالح</option>
                                                                </select>
                                                            </div>
                                                            
                                                            <div>
                                                                <label class="block text-sm font-bold text-gray-700 mb-2">المبلغ المراد استرداده (إن وجد)</label>
                                                                <div class="relative">
                                                                    <input type="number" step="0.01" name="refund_amount" value="{{ $return->refund_amount }}" 
                                                                        class="w-full rounded-xl border-gray-300 focus:border-brand-blue pl-12 text-sm" placeholder="0.00">
                                                                    <span class="absolute left-3 top-2 text-gray-400 text-xs">ر.ي</span>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <label class="block text-sm font-bold text-gray-700 mb-2">ملاحظات الإدارة للعميل</label>
                                                                <textarea name="admin_response" rows="3" 
                                                                    class="w-full rounded-xl border-gray-300 focus:border-brand-blue text-sm" 
                                                                    placeholder="اكتب سبب الرفض أو تعليمات الإرجاع...">{{ $return->admin_response }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="modal-action mt-8 flex gap-2">
                                                            <button type="submit" class="bg-brand-blue hover:bg-blue-800 text-white font-bold py-2.5 px-8 rounded-xl shadow-lg transition-all flex-1">حفظ البيانات</button>
                                                            <button type="button" onclick="document.getElementById('editReturn{{ $return->id }}').close()" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-2.5 px-6 rounded-xl transition-all">إغلاق</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <form method="dialog" class="modal-backdrop bg-black/50">
                                                    <button>close</button>
                                                </form>
                                            </dialog>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                                                <p class="text-gray-500 text-lg">لا توجد طلبات إرجاع حالياً.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-8 border-t pt-6">
                        {{ $returns->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
