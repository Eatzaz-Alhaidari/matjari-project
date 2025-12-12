<x-admin-layout>
    <x-slot name="title">
        التقارير المالية
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">

                <!-- Total Balances Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs shadow-md">
                    <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                            <path fill-rule="evenodd"
                                d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600">
                            إجمالي الأرصدة الحالية
                        </p>
                        <p class="text-lg font-semibold text-gray-700">
                            {{ number_format($totalBalances, 2) }} ر.س
                        </p>
                    </div>
                </div>

                <!-- Total Earnings Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs shadow-md">
                    <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600">
                            إجمالي أرباح التجار
                        </p>
                        <p class="text-lg font-semibold text-gray-700">
                            {{ number_format($totalEarnings, 2) }} ر.س
                        </p>
                    </div>
                </div>

                <!-- Total Withdrawals Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs shadow-md">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600">
                            إجمالي المبالغ المسحوبة
                        </p>
                        <p class="text-lg font-semibold text-gray-700">
                            {{ number_format($totalWithdrawals, 2) }} ر.س
                        </p>
                    </div>
                </div>

            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-xl font-bold text-gray-700 mb-4">تفاصيل إضافية</h3>
                <p class="text-gray-500">هنا يمكن إضافة رسوم بيانية أو تفاصيل أكثر دقة حول الحركات المالية في المستقبل.
                </p>
            </div>

        </div>
    </div>
</x-admin-layout>