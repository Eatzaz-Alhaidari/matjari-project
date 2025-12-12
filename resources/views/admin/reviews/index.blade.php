<x-admin-layout>
    <x-slot name="title">
        إدارة التقييمات
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-brand-blue-800 mb-6">قائمة التقييمات</h2>

                    <div class="overflow-x-auto bg-white">
                        <table class="min-w-full">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        اسم المنتج</th>
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
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($reviews as $review)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4 text-sm font-medium text-gray-900">
                                            {{ $review->product?->name_ar ?? 'منتج محذوف' }}
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $review->user?->name ?? 'غير معروف' }}</div>
                                            <div class="text-xs text-gray-500">{{ $review->user?->email }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-yellow-500 font-bold">
                                            {{ str_repeat('★', $review->rating) }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-500 max-w-xs truncate">
                                            {{ $review->comment ?? 'لا يوجد تعليق' }}
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">لا توجد تقييمات حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-8">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>