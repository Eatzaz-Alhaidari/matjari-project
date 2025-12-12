<x-admin-layout>
    <x-slot name="title">
        إدارة المحافظ
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-brand-blue-800 mb-6">قائمة المحافظ</h2>

                    <div class="overflow-x-auto bg-white">
                        <table class="min-w-full">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        اسم التاجر</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الرصيد الحالي</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        إجمالي الأرباح</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        المبلغ المسحوب</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($wallets as $wallet)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $wallet->vendor?->name ?? 'غير معروف' }}</div>
                                            <div class="text-xs text-gray-500">{{ $wallet->vendor?->email }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            {{ number_format($wallet->balance, 2) }} ر.س
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            {{ number_format($wallet->total_earnings, 2) }} ر.س
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            {{ number_format($wallet->withdrawn_amount, 2) }} ر.س
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">لا توجد محافظ حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-8">
                        {{ $wallets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>