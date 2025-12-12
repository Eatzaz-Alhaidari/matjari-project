<x-admin-layout>
    <x-slot name="title">
        إدارة الإشعارات
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-brand-blue-800 mb-6">سجل الإشعارات</h2>

                    <div class="overflow-x-auto bg-white">
                        <table class="min-w-full">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        نوع الإشعار</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        البيانات</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        وقت الإنشاء</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        وقت القراءة</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($notifications as $notification)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4 text-sm font-medium text-gray-900">
                                            {{ class_basename($notification->type) }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-500 max-w-md truncate">
                                            @php
                                                $data = json_decode($notification->data, true);
                                            @endphp
                                            {{ $data['message'] ?? Str::limit($notification->data, 50) }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-500">
                                            {{ $notification->read_at ? \Carbon\Carbon::parse($notification->read_at)->diffForHumans() : 'غير مقروء' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">لا توجد إشعارات حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-8">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>