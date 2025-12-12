<x-admin-layout>
    <x-slot name="title">
        إدارة الشكاوى
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-brand-blue-800 mb-6">قائمة الشكاوى</h2>

                    <div class="overflow-x-auto bg-white">
                        <table class="min-w-full">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        اسم العميل</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        عنوان الشكوى</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        نص الشكوى</th>
                                    <th
                                        class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الحالة</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        تاريخ التقديم</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($complaints as $complaint)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4 text-sm font-medium text-gray-900">
                                            {{ $complaint->user?->name ?? 'مستخدم محذوف' }}
                                            <div class="text-xs text-gray-400">{{ $complaint->user?->email }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900 font-semibold">
                                            {{ $complaint->subject }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-500 max-w-xs truncate">
                                            {{ $complaint->message }}
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            @if ($complaint->status == 'open')
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">مفتوحة</span>
                                            @elseif ($complaint->status == 'in_progress')
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">قيد
                                                    المعالجة</span>
                                            @else
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">مغلقة</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-500">
                                            {{ $complaint->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">لا توجد شكاوى حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-8">
                        {{ $complaints->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>