<x-vendor-layout>
    <x-slot name="title">
        إدارة الخصومات
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-black">قائمة خصوماتي</h2>
                        <a href="{{ route('vendor.discounts.create') }}"
                            class="px-4 py-2 bg-gray-800 text-white font-semibold rounded-lg shadow-md hover:bg-gray-900">
                            + إضافة خصم جديد
                        </a>
                    </div>

                    <!-- Search and Filter Form -->
                    <div class="mb-6">
                        <form action="{{ route('vendor.discounts.index') }}" method="GET"
                            class="flex items-center space-x-4 space-x-reverse">
                            <div class="flex-1 md:w-1/3">
                                <input type="text" name="search" placeholder="ابحث بعنوان الخصم أو الكود..."
                                    class="w-full border-gray-300 rounded-lg shadow-sm" value="{{ request('search') }}">
                            </div>
                            <div>
                                <select name="status" class="border-gray-300 rounded-lg shadow-sm">
                                    <option value="">جميع الحالات</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط
                                    </option>
                                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>معطل
                                    </option>
                                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>منتهي
                                        الصلاحية</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="px-4 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-brand-orange-700">بحث</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto bg-white">
                        <table class="min-w-full">
                            <thead class="bg-brand-orange-50">
                                <tr>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        الخصم</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        الكود</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        النوع</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        القيمة</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        الحالة</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        تاريخ الانتهاء</th>
                                    <th
                                        class="px-5 py-3 text-center text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($discounts as $discount)
                                    <tr class="hover:bg-gray-50 cursor-pointer"
                                        onclick="window.location.href='{{ route('vendor.discounts.show', $discount->id) }}'">
                                        <td class="px-5 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $discount->title }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ Str::limit($discount->description, 30) }}
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-mono">
                                                {{ $discount->code }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            {{ $discount->type_text }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            {{ $discount->value }}
                                            @if($discount->type === 'percentage')% @else ر.ي @endif
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            <span class="px-2 py-1 text-xs rounded-full font-semibold
                                                                            @if($discount->status === 'active')
                                                                                bg-green-100 text-green-800
                                                                            @elseif($discount->status === 'inactive')
                                                                                bg-red-100 text-red-800
                                                                            @else
                                                                                bg-gray-100 text-gray-800
                                                                            @endif">
                                                {{ $discount->status_text }}
                                            </span>
                                            @if($discount->isExpired() && $discount->status === 'active')
                                                <span class="text-red-500 text-xs block">(منتهي الصلاحية)</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            {{ $discount->end_date->format('Y-m-d') }}
                                            @if($discount->days_remaining < 0)
                                                <span class="text-red-500 text-xs">(انتهى)</span>
                                            @elseif($discount->days_remaining <= 7)
                                                <span class="text-orange-500 text-xs">({{ $discount->days_remaining }} يوم
                                                    متبقي)</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-center text-sm font-medium"
                                            onclick="event.stopPropagation()">
                                            <div class="flex items-center justify-center space-x-2 space-x-reverse">
                                                <a href="{{ route('vendor.discounts.show', $discount->id) }}"
                                                    class="px-2 py-1 text-xs rounded-full font-semibold bg-gray-100 text-gray-800 hover:bg-gray-200"
                                                    title="عرض التفاصيل">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                @if($discount->status !== 'expired')
                                                    <form action="{{ route('vendor.discounts.toggleStatus', $discount->id) }}"
                                                        method="POST" class="inline-block"
                                                        data-confirm-title="{{ $discount->status === 'active' ? 'تعطيل الخصم' : 'تفعيل الخصم' }}"
                                                        data-confirm-text="{{ $discount->status === 'active' ? 'سيتم إيقاف هذا الخصم.' : 'سيتم تفعيل هذا الخصم للعملاء.' }}"
                                                        data-confirm-button="نعم، نفذ">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="px-2 py-1 text-xs rounded-full font-semibold
                                                                                                                    {{ $discount->status === 'active' ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }}">
                                                            {{ $discount->status === 'active' ? 'تعطيل' : 'تفعيل' }}
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('vendor.discounts.edit', $discount->id) }}"
                                                    class="px-2 py-1 text-xs rounded-full font-semibold bg-blue-100 text-blue-800 hover:bg-blue-200">تعديل</a>
                                                <form action="{{ route('vendor.discounts.destroy', $discount->id) }}"
                                                    method="POST" class="inline-block" data-confirm-title="حذف الخصم"
                                                    data-confirm-text="هل أنت متأكد من حذف هذا الخصم؟"
                                                    data-confirm-button="حذف">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-2 py-1 text-xs rounded-full font-semibold bg-red-100 text-red-800 hover:bg-red-200">حذف</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">لا توجد خصومات حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-8">
                        {{ $discounts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>