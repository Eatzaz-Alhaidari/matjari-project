<x-admin-layout>
    <x-slot name="title">
        إدارة البائعين
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 px-4 py-2 bg-red-100 border border-red-200 text-red-700 rounded-md">{{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-brand-blue-800">قائمة البائعين</h2>
                        <a href="{{ route('admin.vendors.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-brand-blue text-white font-bold rounded-xl shadow-lg hover:bg-brand-blue-600 hover:-translate-y-0.5 transition-all duration-300 group">
                            <svg class="w-5 h-5 ml-2 group-hover:rotate-90 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            إضافة بائع جديد
                        </a>
                    </div>

                    <!-- ##### بداية نموذج البحث ##### -->
                    <div class="mb-6">
                        <form action="{{ route('admin.vendors.index') }}" method="GET" class="flex items-center">
                            <input type="text" name="search" placeholder="ابحث بالاسم أو البريد الإلكتروني..."
                                class="w-full md:w-1/3 border-gray-300 rounded-lg shadow-sm"
                                value="{{ request('search') }}">
                            <button type="submit"
                                class="mr-3 px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow-md hover:bg-brand-blue-700">بحث</button>
                        </form>
                    </div>
                    <!-- ##### نهاية نموذج البحث ##### -->
                    <div class="overflow-x-auto bg-white">
                        <table class="min-w-full">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        البائع</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        المتجر</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        السجل التجاري</th>
                                    <th
                                        class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        حالة البائع</th>
                                    <th
                                        class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        حالة المتجر</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        تاريخ التسجيل</th>
                                    <th
                                        class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($vendors as $vendor)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ $vendor->profile_photo_path ? asset('storage/' . $vendor->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($vendor->name) }}"
                                                        alt="{{ $vendor->name }}">
                                                </div>
                                                <div class="mr-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $vendor->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $vendor->email }}</div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $vendor->phone ?? 'لا يوجد هاتف' }}
                                                    </div>
                                                    @if($vendor->status === 'banned')
                                                        <div
                                                            class="mt-1 text-xs text-red-600 bg-red-50 p-1 rounded border border-red-100 max-w-xs whitespace-normal">
                                                            <strong>سبب الحظر:</strong> {{ $vendor->ban_reason }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $vendor->store?->name ?? 'لا يوجد' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $vendor->store?->address ?? 'لا يوجد عنوان' }}
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $vendor->store?->commercial_registration ?? 'لا يوجد' }}
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-center">
                                            @if ($vendor->status === 'banned')
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">محظور</span>
                                            @else
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">نشط</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-center">
                                            @if ($vendor->store?->is_active)
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">نشط</span>
                                            @else
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">غير
                                                    نشط</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $vendor->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-left text-sm font-medium">
                                            <div class="flex items-center justify-center space-x-2 space-x-reverse">

                                                {{-- زر الحظر/إلغاء الحظر --}}
                                                @if($vendor->status === 'banned')
                                                    <form action="{{ route('admin.vendors.activate', $vendor->id) }}"
                                                        method="POST" class="inline-block"
                                                        data-confirm-title="إلغاء الحظر"
                                                        data-confirm-text="هل أنت متأكد من إلغاء حظر هذا البائع؟ سيتمكن من الدخول للمنصة مجدداً."
                                                        data-confirm-button="نعم، إلغاء الحظر"
                                                        data-confirm-icon="question">
                                                        @csrf
                                                        <button type="submit"
                                                            class="p-2 text-green-600 hover:text-green-900 bg-green-100 hover:bg-green-200 rounded-full transition-colors duration-200"
                                                            title="إلغاء الحظر">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button type="button"
                                                        onclick="openBanModal('{{ $vendor->id }}', '{{ $vendor->name }}')"
                                                        class="p-2 text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 rounded-full transition-colors duration-200"
                                                        title="حظر المستخدم">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                        </svg>
                                                    </button>
                                                @endif

                                                {{-- أزرار تحكم المتجر --}}
                                                @if($vendor->store)
                                                    <form action="{{ route('admin.vendors.toggleStatus', $vendor->id) }}"
                                                        method="POST" class="inline-block"
                                                        data-confirm-title="{{ $vendor->store->is_active ? 'تعطيل المتجر' : 'تفعيل المتجر' }}"
                                                        data-confirm-text="{{ $vendor->store->is_active ? 'سيتم تعطيل متجر هذا البائع ولن تظهر منتجاته للعملاء.' : 'سيتم تفعيل المتجر وعرض منتجاته.' }}"
                                                        data-confirm-button="نعم، نفذ الإجراء">
                                                        @csrf
                                                        <button type="submit"
                                                            class="px-2 py-1 text-xs rounded-full font-semibold {{ $vendor->store->is_active ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-blue-100 text-blue-800 hover:bg-blue-200' }}"
                                                            title="{{ $vendor->store->is_active ? 'تعطيل المتجر' : 'تفعيل المتجر' }}">
                                                            {{ $vendor->store->is_active ? 'تعطيل المتجر' : 'تفعيل المتجر' }}
                                                        </button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('admin.vendors.edit', $vendor->id) }}"
                                                    class="p-2 text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 rounded-full transition-colors duration-200"
                                                    title="تعديل">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>

                                                <form action="{{ route('admin.vendors.destroy', $vendor->id) }}"
                                                    method="POST" class="inline-block"
                                                    data-confirm-title="حذف البائع نهائياً"
                                                    data-confirm-text="تحذير: سيتم حذف البائع وكافة بيانات متجره ومنتجاته. هذا الإجراء لا يمكن التراجع عنه!"
                                                    data-confirm-button="نعم، احذف البائع"
                                                    data-confirm-icon="warning">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 text-gray-600 hover:text-red-900 bg-gray-100 hover:bg-gray-200 rounded-full transition-colors duration-200"
                                                        title="حذف">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">لا يوجد بائعين حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-8">
                        {{ $vendors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ban Modal -->
    <div id="banModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeBanModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="banForm" method="POST" action="">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:mr-4 sm:text-right w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    تأكيد حظر البائع
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">
                                        أنت على وشك حظر البائع <span id="vendorName"
                                            class="font-bold text-gray-800"></span>.
                                    </p>
                                    <label for="ban_reason" class="block text-sm font-medium text-gray-700 mb-1">سبب
                                        الحظر (سيتم إرساله للبائع)</label>
                                    <textarea name="ban_reason" id="ban_reason" rows="3"
                                        class="shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        required placeholder="يرجى كتابة سبب الحظر هنا..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            تأكيد الحظر
                        </button>
                        <button type="button" onclick="closeBanModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            إلغاء
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openBanModal(vendorId, vendorName) {
            document.getElementById('banModal').classList.remove('hidden');
            document.getElementById('vendorName').innerText = vendorName;

            // Set the form action dynamically
            let form = document.getElementById('banForm');
            form.action = "/admin/vendors/" + vendorId + "/ban";
        }

        function closeBanModal() {
            document.getElementById('banModal').classList.add('hidden');
        }
    </script>

</x-admin-layout>