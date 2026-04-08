<x-admin-layout>
    <x-slot name="title">سجل عمليات المحافظ</x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
                    <div class="p-4 bg-emerald-100 rounded-xl">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">إجمالي المبالغ</div>
                        <div class="text-xl font-extrabold text-emerald-700">{{ number_format($totalAmount, 0) }} ر.ي</div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
                    <div class="p-4 bg-amber-100 rounded-xl">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">إجمالي العمولات</div>
                        <div class="text-xl font-extrabold text-amber-700">{{ number_format($totalFees, 0) }} ر.ي</div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
                    <div class="p-4 bg-blue-100 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">عمليات اليوم</div>
                        <div class="text-xl font-extrabold text-blue-700">{{ $countToday }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Header --}}
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-brand-blue-800">سجل عمليات المحافظ</h2>
                            <p class="text-sm text-gray-500 mt-1">تسجيل وتتبع حوالات المحافظ الإلكترونية</p>
                        </div>
                        <button onclick="document.getElementById('addTxModal').showModal()"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow hover:bg-brand-blue-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            تسجيل عملية جديدة
                        </button>
                    </div>

                    {{-- Search --}}
                    <form method="GET" action="{{ route('admin.wallet-transactions.index') }}"
                        class="flex flex-wrap items-center gap-3 mb-6">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="بحث برقم المرجع أو الاسم أو الهاتف..."
                            class="border-gray-300 rounded-lg shadow-sm w-full md:w-80">
                        <select name="status" class="border-gray-300 rounded-lg shadow-sm">
                            <option value="">كل الحالات</option>
                            <option value="completed" @selected(request('status')=='completed')>مكتملة</option>
                            <option value="pending"   @selected(request('status')=='pending')>معلقة</option>
                            <option value="failed"    @selected(request('status')=='failed')>فاشلة</option>
                        </select>
                        <button type="submit"
                            class="px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow hover:bg-brand-blue-700 transition">بحث</button>
                    </form>

                    {{-- Table --}}
                    <div class="overflow-x-auto min-h-[400px]">
                        <table class="min-w-full text-right">
                            <thead class="bg-brand-blue-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase">رقم المرجع</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase">المحفظة</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase">العملية</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase">المرسل</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase">المستفيد</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">المبلغ</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">العمولة</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">الإجمالي</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">الحالة</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">التاريخ</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">إجراء</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($transactions as $tx)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-4">
                                            <div class="text-xs font-mono text-gray-700 font-bold">{{ $tx->reference_number ?? '-' }}</div>
                                            @if($tx->network_transfer_number)
                                                <div class="text-xs text-gray-400 mt-0.5">حوالة: {{ $tx->network_transfer_number }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-sm font-bold text-purple-700 bg-purple-50 px-2 py-0.5 rounded inline-block">
                                                {{ $tx->wallet->wallet_name ?? 'غير محدد' }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-sm text-gray-700">{{ $tx->operation ?? '-' }}</div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-sm font-semibold text-gray-800">{{ $tx->sender_name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $tx->sender_phone ?? '' }}</div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-sm font-semibold text-gray-800">{{ $tx->beneficiary_name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $tx->beneficiary_phone ?? '' }}</div>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <span class="font-bold text-gray-800">{{ number_format($tx->amount, 0) }}</span>
                                            <span class="text-xs text-gray-500"> ر.ي</span>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <span class="text-amber-700 font-semibold text-sm">{{ number_format($tx->fee, 0) }}</span>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <span class="font-extrabold text-emerald-700">{{ number_format($tx->total, 0) }}</span>
                                            <span class="text-xs text-gray-500"> ر.ي</span>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            @php
                                                $statusMap = [
                                                    'completed' => ['text'=>'مكتملة','class'=>'bg-green-100 text-green-700'],
                                                    'pending'   => ['text'=>'معلقة',  'class'=>'bg-amber-100 text-amber-700'],
                                                    'failed'    => ['text'=>'فاشلة',  'class'=>'bg-red-100 text-red-700'],
                                                ];
                                                $s = $statusMap[$tx->status] ?? ['text'=>$tx->status,'class'=>'bg-gray-100 text-gray-600'];
                                            @endphp
                                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ $s['class'] }}">{{ $s['text'] }}</span>
                                        </td>
                                        <td class="px-4 py-4 text-center text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($tx->created_at)->format('Y/m/d') }}
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <form method="POST" action="{{ route('admin.wallet-transactions.destroy', $tx->id) }}"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذه العملية؟')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="text-xs text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1 rounded border border-red-100 transition">
                                                    حذف
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="px-5 py-16 text-center text-gray-400">
                                            <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                            لا توجد عمليات مسجلة
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $transactions->withQueryString()->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Transaction Modal --}}
    <dialog id="addTxModal" class="rounded-2xl shadow-2xl w-full max-w-2xl p-0 backdrop:bg-gray-900/50">
        <div class="bg-white rounded-2xl overflow-hidden">
            <div class="bg-brand-blue px-6 py-4 flex items-center justify-between">
                <h3 class="text-white font-bold text-lg">تسجيل عملية محفظة جديدة</h3>
                <button onclick="document.getElementById('addTxModal').close()"
                    class="text-white/70 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.wallet-transactions.store') }}" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">المحفظة الإلكترونية <span class="text-red-500">*</span></label>
                        <select name="electronic_wallet_id" class="w-full border-gray-300 rounded-lg shadow-sm text-sm" required>
                            <option value="">اختر المحفظة</option>
                            @foreach($wallets as $wallet)
                                <option value="{{ $wallet->id }}">{{ $wallet->wallet_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">رقم مرجع العملية</label>
                        <input type="text" name="reference_number" placeholder="مثال: 17751784787335"
                            class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">العملية</label>
                        <input type="text" name="operation" placeholder="مثال: إرسال حوالة شبكة تحويل"
                            class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">تاريخ العملية</label>
                        <input type="datetime-local" name="transaction_date"
                            class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">رقم حوالة شبكة تحويل</label>
                        <input type="text" name="network_transfer_number" placeholder="مثال: 5527385377"
                            class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">المبلغ (ر.ي) <span class="text-red-500">*</span></label>
                        <input type="number" name="amount" step="0.01" min="0" required
                            class="w-full border-gray-300 rounded-lg shadow-sm text-sm" oninput="calcTotal(this.form)">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">العمولة (ر.ي)</label>
                        <input type="number" name="fee" step="0.01" min="0" value="0"
                            class="w-full border-gray-300 rounded-lg shadow-sm text-sm" oninput="calcTotal(this.form)">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">الإجمالي (ر.ي)</label>
                        <input type="number" name="total" id="totalField" step="0.01" min="0"
                            class="w-full border-gray-300 rounded-lg shadow-sm text-sm bg-gray-50" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">الحالة</label>
                        <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                            <option value="completed">مكتملة</option>
                            <option value="pending">معلقة</option>
                            <option value="failed">فاشلة</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">اسم المرسل</label>
                        <input type="text" name="sender_name" placeholder="الاسم"
                            class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">هاتف المرسل</label>
                        <input type="text" name="sender_phone" placeholder="77XXXXXXX"
                            class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">اسم المستفيد</label>
                        <input type="text" name="beneficiary_name" placeholder="الاسم"
                            class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">هاتف المستفيد</label>
                        <input type="text" name="beneficiary_phone" placeholder="77XXXXXXX"
                            class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">ملاحظات</label>
                    <textarea name="notes" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm text-sm"
                        placeholder="ملاحظات إضافية..."></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('addTxModal').close()"
                        class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">إلغاء</button>
                    <button type="submit"
                        class="px-6 py-2 bg-brand-blue text-white font-bold rounded-lg shadow hover:bg-brand-blue-700 transition">حفظ العملية</button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        function calcTotal(form) {
            const amount = parseFloat(form.querySelector('[name=amount]').value) || 0;
            const fee    = parseFloat(form.querySelector('[name=fee]').value)    || 0;
            document.getElementById('totalField').value = (amount + fee).toFixed(2);
        }
    </script>
</x-admin-layout>
