<x-vendor-layout>
    <x-slot name="title">
        إدارة الإعلانات
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-black">قائمة إعلاناتي</h2>
                        <a href="{{ route('vendor.advertisements.create') }}"
                            class="px-4 py-2 bg-gray-800 text-white font-semibold rounded-lg shadow-md hover:bg-gray-900">
                            + إضافة إعلان جديد
                        </a>
                    </div>

                    <!-- Search and Filter Form -->
                    <div class="mb-6">
                        <form action="{{ route('vendor.advertisements.index') }}" method="GET"
                            class="flex flex-col md:flex-row items-center gap-4">
                            <div class="flex-1 w-full md:w-auto">
                                <input type="text" name="search" placeholder="ابحث بعنوان الإعلان أو التاريخ..."
                                    class="w-full border-gray-300 rounded-lg shadow-sm" value="{{ request('search') }}">
                            </div>
                            <div class="w-full md:w-1/4">
                                <input type="date" name="search_date"
                                    class="w-full border-gray-300 rounded-lg shadow-sm"
                                    value="{{ request('search_date') }}" title="تاريخ البداية">
                            </div>
                            <div class="w-full md:w-auto">
                                <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm">
                                    <option value="">جميع الحالات</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط
                                    </option>
                                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>معطل
                                    </option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>في
                                        الانتظار</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="w-full md:w-auto px-6 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-brand-orange-700">بحث</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto bg-white">
                        <table class="min-w-full">
                            <thead class="bg-brand-orange-50">
                                <tr>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        الإعلان</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        الحالة</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        تاريخ البداية</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        تاريخ النهاية</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        الميزانية</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        المشاهدات</th>
                                    <th
                                        class="px-5 py-3 text-center text-xs font-bold text-brand-orange-800 uppercase tracking-wider">
                                        الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($advertisements as $advertisement)
                                    <tr class="hover:bg-gray-50 cursor-pointer"
                                        onclick="window.location.href='{{ route('vendor.advertisements.show', $advertisement->id) }}'">
                                        <td class="px-5 py-4">
                                            <div class="flex items-center">
                                                @if($advertisement->image)
                                                    <div class="flex-shrink-0 w-10 h-10 ml-3">
                                                        <img class="w-10 h-10 rounded-full object-cover"
                                                            src="{{ asset('storage/' . $advertisement->image) }}"
                                                            alt="{{ $advertisement->title }}">
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $advertisement->title }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ Str::limit($advertisement->description, 30) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            @php
                                                $statusClasses = [
                                                    0 => 'bg-yellow-100 text-yellow-800', // Pending
                                                    1 => 'bg-green-100 text-green-800',  // Active
                                                    2 => 'bg-red-100 text-red-800',    // Rejected
                                                    3 => 'bg-gray-100 text-gray-800',   // Paused
                                                ];
                                            @endphp
                                            <span class="px-2 py-1 text-xs rounded-full font-semibold {{ $statusClasses[$advertisement->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $advertisement->status_text }}
                                            </span>
                                            @if($advertisement->status === 2 && $advertisement->rejection_reason)
                                                <div class="text-[10px] text-red-600 mt-1 max-w-[150px] italic">
                                                    السبب: {{ Str::limit($advertisement->rejection_reason, 50) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            {{ $advertisement->start_date->format('Y-m-d') }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            {{ $advertisement->end_date->format('Y-m-d') }}
                                            @if($advertisement->days_remaining < 0)
                                                <span class="text-red-500 text-xs">(انتهى)</span>
                                            @elseif($advertisement->days_remaining <= 7)
                                                <span class="text-orange-500 text-xs">({{ $advertisement->days_remaining }} يوم
                                                    متبقي)</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            {{ number_format($advertisement->budget, 2) }} ر.ي
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            <div class="text-center">
                                                <div>{{ number_format($advertisement->views) }}</div>
                                                <div class="text-xs text-gray-500">
                                                    النقرات: {{ number_format($advertisement->clicks) }}
                                                    @if($advertisement->click_through_rate > 0)
                                                        ({{ number_format($advertisement->click_through_rate, 1) }}%)
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-center text-sm font-medium"
                                            onclick="event.stopPropagation()">
                                            <div class="flex items-center justify-center space-x-2 space-x-reverse">
                                                <a href="{{ route('vendor.advertisements.show', $advertisement->id) }}"
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
                                                @if($advertisement->status === 1 || $advertisement->status === 3)
                                                    <form
                                                        action="{{ route('vendor.advertisements.toggleStatus', $advertisement->id) }}"
                                                        method="POST" class="inline-block"
                                                        data-confirm-title="{{ $advertisement->status === 1 ? 'تعطيل الإعلان' : 'تفعيل الإعلان' }}"
                                                        data-confirm-text="{{ $advertisement->status === 1 ? 'سيتم إيقاف عرض الإعلان مؤقتاً.' : 'سيتم إعادة تنشيط الإعلان.' }}"
                                                        data-confirm-button="نعم، نفذ">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="px-2 py-1 text-xs rounded-full font-semibold
                                                                                                                    {{ $advertisement->status === 1 ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }}">
                                                            {{ $advertisement->status === 1 ? 'تعطيل' : 'تفعيل' }}
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('vendor.advertisements.edit', $advertisement->id) }}"
                                                    class="px-2 py-1 text-xs rounded-full font-semibold bg-blue-100 text-blue-800 hover:bg-blue-200">تعديل</a>
                                                <form
                                                    action="{{ route('vendor.advertisements.destroy', $advertisement->id) }}"
                                                    method="POST" class="inline-block" data-confirm-title="حذف الإعلان"
                                                    data-confirm-text="هل أنت متأكد من حذف هذا الإعلان؟"
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
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">لا توجد إعلانات حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-8">
                        {{ $advertisements->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>