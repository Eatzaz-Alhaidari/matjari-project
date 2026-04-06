<x-admin-layout>
    <x-slot name="title">كوبونات الخصم</x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach([
                    ['label'=>'الإجمالي',  'val'=>$stats['total'],    'color'=>'slate',   'icon'=>'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z'],
                    ['label'=>'نشطة',      'val'=>$stats['active'],   'color'=>'green',   'icon'=>'M5 13l4 4L19 7'],
                    ['label'=>'منتهية',    'val'=>$stats['expired'],  'color'=>'red',     'icon'=>'M6 18L18 6M6 6l12 12'],
                    ['label'=>'معطلة',     'val'=>$stats['inactive'], 'color'=>'gray',    'icon'=>'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636'],
                ] as $stat)
                    <div class="bg-white rounded-xl shadow p-4 flex items-center gap-3">
                        <div class="p-3 bg-{{ $stat['color'] }}-100 rounded-xl">
                            <svg class="w-6 h-6 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">{{ $stat['label'] }}</div>
                            <div class="text-2xl font-extrabold text-{{ $stat['color'] }}-700">{{ $stat['val'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">

                    {{-- Header --}}
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-brand-blue-800">كوبونات الخصم</h2>
                            <p class="text-sm text-gray-500 mt-1">إدارة كوبونات وأكواد الخصم للمنصة</p>
                        </div>
                        <button onclick="document.getElementById('addCouponModal').showModal()"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow hover:bg-brand-blue-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            إضافة كوبون
                        </button>
                    </div>

                    {{-- Filters --}}
                    <form method="GET" action="{{ route('admin.discount-coupons.index') }}"
                        class="flex flex-wrap items-center gap-3 mb-6">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="ابحث بالكود أو العنوان..."
                            class="border-gray-300 rounded-lg shadow-sm w-full md:w-72">
                        <select name="status" class="border-gray-300 rounded-lg shadow-sm">
                            <option value="">كل الحالات</option>
                            <option value="active"   @selected(request('status')=='active')>نشطة</option>
                            <option value="inactive" @selected(request('status')=='inactive')>معطلة</option>
                            <option value="expired"  @selected(request('status')=='expired')>منتهية</option>
                        </select>
                        <button type="submit"
                            class="px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow hover:bg-brand-blue-700 transition">بحث</button>
                    </form>

                    {{-- Table --}}
                    <div class="overflow-x-auto min-h-[400px]">
                        <table class="min-w-full text-right">
                            <thead class="bg-brand-blue-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase">الكود</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase">العنوان</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">النوع</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">القيمة</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">الحد الأدنى</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">صالح من</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">صالح حتى</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">الاستخدام</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">الحالة</th>
                                    <th class="px-4 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($coupons as $coupon)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-4">
                                            <span class="font-mono font-bold text-brand-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-100 text-sm">
                                                {{ $coupon->code }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-800 max-w-xs">
                                            <div class="truncate">{{ $coupon->title }}</div>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            @if($coupon->type === 'percentage')
                                                <span class="text-xs bg-violet-100 text-violet-700 px-2 py-0.5 rounded-full font-semibold">نسبة %</span>
                                            @else
                                                <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-semibold">قيمة ثابتة</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-center font-bold text-fuchsia-700">
                                            {{ $coupon->value }}{{ $coupon->type === 'percentage' ? '%' : ' ر.ي' }}
                                        </td>
                                        <td class="px-4 py-4 text-center text-sm text-gray-600">
                                            {{ number_format($coupon->min_order_amount, 0) }} ر.ي
                                        </td>
                                        <td class="px-4 py-4 text-center text-xs text-gray-500">{{ $coupon->start_date }}</td>
                                        <td class="px-4 py-4 text-center text-xs text-gray-500">{{ $coupon->end_date }}</td>
                                        <td class="px-4 py-4 text-center text-sm">
                                            <span class="font-semibold text-gray-700">{{ $coupon->used_count }}</span>
                                            @if($coupon->usage_limit)
                                                <span class="text-gray-400">/ {{ $coupon->usage_limit }}</span>
                                            @else
                                                <span class="text-gray-400">/ ∞</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            @php
                                                $sMap = [
                                                    'active'   => 'bg-green-100 text-green-700',
                                                    'inactive' => 'bg-gray-100 text-gray-600',
                                                    'expired'  => 'bg-red-100 text-red-700',
                                                ];
                                                $sLabel = ['active'=>'نشط','inactive'=>'معطل','expired'=>'منتهي'];
                                            @endphp
                                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ $sMap[$coupon->status] ?? 'bg-gray-100 text-gray-600' }}">
                                                {{ $sLabel[$coupon->status] ?? $coupon->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <form method="POST" action="{{ route('admin.discount-coupons.toggleStatus', $coupon->id) }}">
                                                    @csrf @method('PATCH')
                                                    <button type="submit"
                                                        class="text-xs px-2 py-1 rounded border transition
                                                        {{ $coupon->status === 'active'
                                                            ? 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100'
                                                            : 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100' }}">
                                                        {{ $coupon->status === 'active' ? 'تعطيل' : 'تفعيل' }}
                                                    </button>
                                                </form>
                                                <button onclick="openEditCoupon({{ json_encode($coupon) }})"
                                                    class="text-xs bg-blue-50 text-blue-700 border border-blue-200 px-2 py-1 rounded hover:bg-blue-100 transition">
                                                    تعديل
                                                </button>
                                                <form method="POST" action="{{ route('admin.discount-coupons.destroy', $coupon->id) }}"
                                                    onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="text-xs bg-red-50 text-red-600 border border-red-200 px-2 py-1 rounded hover:bg-red-100 transition">
                                                        حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="py-16 text-center text-gray-400">
                                            <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                            </svg>
                                            لا توجد كوبونات خصم
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $coupons->withQueryString()->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Coupon Modal --}}
    <dialog id="addCouponModal" class="rounded-2xl shadow-2xl w-full max-w-2xl p-0 backdrop:bg-gray-900/50">
        <div class="bg-white rounded-2xl overflow-hidden">
            <div class="bg-brand-blue px-6 py-4 flex items-center justify-between">
                <h3 class="text-white font-bold text-lg">إضافة كوبون خصم جديد</h3>
                <button onclick="document.getElementById('addCouponModal').close()" class="text-white/70 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.discount-coupons.store') }}" class="p-6 space-y-4">
                @csrf
                @include('admin.discount-coupons._form')
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('addCouponModal').close()"
                        class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">إلغاء</button>
                    <button type="submit"
                        class="px-6 py-2 bg-brand-blue text-white font-bold rounded-lg shadow hover:bg-brand-blue-700 transition">حفظ الكوبون</button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- Edit Coupon Modal --}}
    <dialog id="editCouponModal" class="rounded-2xl shadow-2xl w-full max-w-2xl p-0 backdrop:bg-gray-900/50">
        <div class="bg-white rounded-2xl overflow-hidden">
            <div class="bg-brand-blue px-6 py-4 flex items-center justify-between">
                <h3 class="text-white font-bold text-lg">تعديل الكوبون</h3>
                <button onclick="document.getElementById('editCouponModal').close()" class="text-white/70 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" id="editCouponForm" class="p-6 space-y-4">
                @csrf @method('PUT')
                @include('admin.discount-coupons._form', ['edit' => true])
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('editCouponModal').close()"
                        class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">إلغاء</button>
                    <button type="submit"
                        class="px-6 py-2 bg-brand-blue text-white font-bold rounded-lg shadow hover:bg-brand-blue-700 transition">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        function openEditCoupon(coupon) {
            const form = document.getElementById('editCouponForm');
            form.action = `/admin/discount-coupons/${coupon.id}`;
            Object.keys(coupon).forEach(key => {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) {
                    if (input.tagName === 'SELECT') {
                        input.value = coupon[key];
                    } else {
                        input.value = coupon[key] ?? '';
                    }
                }
            });
            document.getElementById('editCouponModal').showModal();
        }
    </script>
</x-admin-layout>
