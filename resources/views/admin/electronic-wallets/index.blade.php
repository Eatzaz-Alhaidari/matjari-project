<x-admin-layout>
    <x-slot name="title">
        إدارة المحافظ الإلكترونية
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-brand-blue-800">إدارة المحافظ الإلكترونية</h2>
                        <a href="{{ route('admin.electronic-wallets.create') }}"
                            class="bg-brand-blue hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-lg flex items-center shadow-md transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            إضافة محفظة
                        </a>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الشعار
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        اسم المحفظة
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        المزود
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الوضع
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الحالة
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الإجراءات
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($wallets as $wallet)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($wallet->wallet_logo)
                                                <img src="{{ Storage::url($wallet->wallet_logo) }}" alt="logo"
                                                    class="h-12 w-12 rounded-lg object-cover border border-gray-200">
                                            @else
                                                <div
                                                    class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center border border-gray-200 text-gray-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">{{ $wallet->wallet_name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $wallet->provider }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($wallet->payment_mode == 'api')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    API
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    يدوي
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $wallet->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                <span
                                                    class="w-1.5 h-1.5 {{ $wallet->is_active ? 'bg-green-400' : 'bg-red-400' }} rounded-full ml-1.5"></span>
                                                {{ $wallet->is_active ? 'مفعل' : 'معطل' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center space-x-2 space-x-reverse">
                                                <a href="{{ route('admin.electronic-wallets.edit', $wallet->id) }}"
                                                    class="px-2 py-1 text-xs rounded-full font-semibold bg-blue-100 text-blue-800 hover:bg-blue-200">
                                                    تعديل
                                                </a>
                                                <form action="{{ route('admin.electronic-wallets.destroy', $wallet->id) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('هل أنت متأكد من حذف هذه المحفظة؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-2 py-1 text-xs rounded-full font-semibold bg-red-100 text-red-800 hover:bg-red-200">
                                                        حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                </svg>
                                                <p class="text-lg font-medium text-gray-900">لا توجد محافظ مضافة حالياً</p>
                                                <p class="text-sm text-gray-500 mb-4">قم بإضافة محفظة جديدة لتفعيل الدفع
                                                    الإلكتروني</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>