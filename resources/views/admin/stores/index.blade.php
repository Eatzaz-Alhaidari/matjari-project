<x-admin-layout>
    <x-slot name="title">
        إدارة المتاجر
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-brand-blue-800 mb-6">قائمة المتاجر</h2>

                    <!-- Search Form -->
                    <div class="mb-6">
                        <form action="{{ route('admin.stores.index') }}" method="GET" class="flex items-center">
                            <input type="text" name="search" placeholder="ابحث باسم المتجر أو اسم المالك..."
                                class="w-full md:w-1/3 border-gray-300 rounded-lg shadow-sm"
                                value="{{ request('search') }}">
                            <button type="submit"
                                class="mr-3 px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow-md hover:bg-brand-blue-700">بحث</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto bg-white">
                        <table class="min-w-full">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الشعار</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        اسم المتجر</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        صورة الغلاف</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        المالك (البائع)</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        السجل التجاري</th>
                                    <th
                                        class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الحالة</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        تاريخ الإنشاء</th>
                                    <th
                                        class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($stores as $store)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4">
                                            @if ($store->logo_path)
                                                <img src="{{ asset('storage/' . $store->logo_path) }}" alt="{{ $store->name }}"
                                                    class="h-10 w-10 rounded-lg object-cover border border-gray-200">
                                            @else
                                                <div
                                                    class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                                    <i class="fas fa-store"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $store->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $store->address ?? 'لا يوجد عنوان' }}
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            @if ($store->cover_image_path)
                                                <img src="{{ asset('storage/' . $store->cover_image_path) }}"
                                                    alt="{{ $store->name }} Cover"
                                                    class="h-10 w-20 rounded-lg object-cover border border-gray-200 shadow-sm">
                                            @else
                                                <div
                                                    class="h-10 w-20 rounded-lg bg-gray-50 flex items-center justify-center text-gray-300 border border-dashed border-gray-200">
                                                    <span class="text-[10px]">لا غلاف</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $store->user?->name ?? 'غير معروف' }}</div>
                                            <div class="text-xs text-gray-500">{{ $store->user?->email }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-500">
                                            {{ $store->commercial_registration ?? 'لا يوجد' }}
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            @if ($store->is_active)
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">نشط</span>
                                            @else
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">غير
                                                    نشط</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-500">
                                            {{ $store->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-5 py-4 text-center text-sm font-medium">
                                            <div class="flex items-center justify-center space-x-2 space-x-reverse">
                                                <form action="{{ route('admin.stores.toggleStatus', $store->id) }}"
                                                    method="POST" class="inline-block"
                                                    data-confirm-title="{{ $store->is_active ? 'تعطيل المتجر' : 'تفعيل المتجر' }}"
                                                    data-confirm-text="{{ $store->is_active ? 'سيتم تعطيل المتجر وإخفاء منتجاته.' : 'سيتم تفعيل المتجر.' }}"
                                                    data-confirm-button="نعم، نفذ">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-2 py-1 text-xs rounded-full font-semibold {{ $store->is_active ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }}">
                                                        {{ $store->is_active ? 'تعطيل' : 'تفعيل' }}
                                                    </button>
                                                </form>
                                                <a href="{{ route('admin.stores.edit', $store->id) }}"
                                                    class="px-2 py-1 text-xs rounded-full font-semibold bg-blue-100 text-blue-800 hover:bg-blue-200">تعديل</a>
                                                <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST"
                                                    class="inline-block" data-confirm-title="حذف المتجر"
                                                    data-confirm-text="تحذير: سيتم حذف المتجر وجميع المنتجات المرتبطة به."
                                                    data-confirm-button="حذف المتجر" data-confirm-icon="warning">
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
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">لا توجد متاجر حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-8">
                        {{ $stores->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>