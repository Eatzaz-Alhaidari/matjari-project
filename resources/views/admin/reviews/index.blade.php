<x-admin-layout>
    <x-slot name="title">
        إدارة التقييمات
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <!-- إحصائيات التقييمات (استخدم نفس تخطيط البائع لكن بألوان الأدمن) -->
            <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-4">
                <div class="p-4 bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">إجمالي التقييمات</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">متوسط التقييم</p>
                            <p class="text-2xl font-bold text-yellow-600">
                                {{ number_format($stats['average_rating'], 1) }} ⭐</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-full">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">قيد المراجعة</p>
                            <p class="text-2xl font-bold text-yellow-700">{{ $stats['pending'] }}</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-full">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">مقبولة</p>
                            <p class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-brand-blue-800 mb-6">قائمة التقييمات</h2>

                    <!-- فلاتر البحث -->
                    <form action="{{ route('admin.reviews.index') }}" method="GET" class="mb-6">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">حالة التقييم</label>
                                <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm">
                                    <option value="">الكل</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد
                                        المراجعة</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>مقبول
                                    </option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوض
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">المتجر</label>
                                <select name="store_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                                    <option value="">الكل</option>
                                    @foreach($stores as $store)
                                        <option value="{{ $store->id }}" {{ request('store_id') == $store->id ? 'selected' : '' }}>
                                            {{ $store->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">التقييم</label>
                                <select name="rating" class="w-full border-gray-300 rounded-lg shadow-sm">
                                    <option value="">الكل</option>
                                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 نجوم</option>
                                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 نجوم</option>
                                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 نجوم</option>
                                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 نجوم</option>
                                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 نجمة</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow-md hover:bg-brand-blue-700">
                                    بحث
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="overflow-x-auto bg-white">
                        <table class="min-w-full">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        المتجر</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        المنتج المقيم</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        اسم العميل</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        التقييم</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        التعليق</th>
                                    <th
                                        class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الحالة</th>
                                    <th
                                        class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        التاريخ</th>
                                    <th
                                        class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($reviews as $review)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4">
                                            <div class="flex items-center">
                                                @if($review->product && $review->product->store && $review->product->store->logo_path)
                                                    <div class="flex-shrink-0 w-10 h-10 ml-3">
                                                        <img class="w-10 h-10 rounded-full object-cover"
                                                            src="{{ asset('storage/' . $review->product->store->logo_path) }}"
                                                            alt="{{ $review->product->store->name }}">
                                                    </div>
                                                @else
                                                    <div
                                                        class="flex-shrink-0 w-10 h-10 ml-3 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 text-xs">
                                                        {{ substr($review->product->store->name ?? 'S', 0, 1) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $review->product->store->name ?? 'متجر غير معروف' }}</div>
                                                    <a href="{{ route('admin.stores.edit', $review->product->store->id ?? 0) }}"
                                                        class="text-xs text-brand-blue hover:underline">عرض المتجر</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="text-sm text-gray-500">{{ $review->product->name ?? 'منتج محذوف' }}
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $review->user->name ?? 'غير معروف' }}</div>
                                            <div class="text-xs text-gray-500">{{ $review->user->email ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="text-yellow-500 font-bold text-lg">
                                                {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                            </div>
                                            <div class="text-xs text-gray-500">({{ $review->rating }}/5)</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="text-sm text-gray-500 max-w-xs">
                                                @if($review->comment)
                                                    <p class="truncate" title="{{ $review->comment }}">
                                                        {{ Str::limit($review->comment, 50) }}</p>
                                                @else
                                                    <span class="text-gray-400">لا يوجد تعليق</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            @if ($review->status == 'approved')
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">مقبول</span>
                                            @elseif ($review->status == 'pending')
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">قيد
                                                    المراجعة</span>
                                            @else
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">مرفوض</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-center text-sm text-gray-500">
                                            {{ $review->created_at->format('Y-m-d') }}
                                            <div class="text-xs text-gray-400">{{ $review->created_at->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-center text-sm font-medium">
                                            <div class="flex items-center justify-center space-x-2 space-x-reverse">
                                                <a href="{{ route('admin.reviews.show', $review->id) }}"
                                                    class="px-2 py-1 text-xs rounded-full font-semibold bg-blue-100 text-blue-800 hover:bg-blue-200"
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
                                                @if($review->status !== 'approved')
                                                    <form action="{{ route('admin.reviews.updateStatus', $review->id) }}"
                                                        method="POST" class="inline-block" data-confirm-title="قبول التقييم"
                                                        data-confirm-text="هل تريد نشر هذا التقييم في صفحة المنتج؟"
                                                        data-confirm-button="نعم، انشر التقييم" data-confirm-icon="question">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit"
                                                            class="px-2 py-1 text-xs rounded-full font-semibold bg-green-100 text-green-800 hover:bg-green-200"
                                                            title="قبول التقييم">✓</button>
                                                    </form>
                                                @endif
                                                @if($review->status !== 'rejected')
                                                    <form action="{{ route('admin.reviews.updateStatus', $review->id) }}"
                                                        method="POST" class="inline-block" data-confirm-title="رفض التقييم"
                                                        data-confirm-text="هل تريد رفض هذا التقييم؟ لن يظهر للعملاء."
                                                        data-confirm-button="نعم، ارفض التقييم" data-confirm-icon="warning">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit"
                                                            class="px-2 py-1 text-xs rounded-full font-semibold bg-red-100 text-red-800 hover:bg-red-200"
                                                            title="رفض التقييم">✗</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">لا توجد تقييمات حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-8">{{ $reviews->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>