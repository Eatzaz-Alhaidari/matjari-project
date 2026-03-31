<x-admin-layout>
    <x-slot name="title">
        إدارة الماركات
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <!-- Header & Actions -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-brand-blue-800">إدارة الماركات التجارية</h2>
                <button onclick="document.getElementById('addBrandModal').showModal()"
                    class="bg-brand-blue hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-lg flex items-center shadow-md transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    إضافة ماركة جديدة
                </button>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-100 border-r-4 border-green-500 text-green-700 p-4 rounded shadow-sm"
                    role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 ml-4"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path
                                    d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                            </svg></div>
                        <div>
                            <p class="font-bold">تمت العملية بنجاح!</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">الشعار</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">اسم الماركة</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">عدد المنتجات</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($brands as $brand)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($brand->logo)
                                                <img src="{{ Storage::url($brand->logo) }}" alt="{{ $brand->name }}"
                                                    class="h-10 w-10 rounded shadow-sm object-contain border bg-white">
                                            @else
                                                <div class="h-10 w-10 rounded bg-gray-100 flex items-center justify-center border text-gray-400 text-[10px]">No Logo</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $brand->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">{{ $brand->products_count }} منتج</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center items-center space-x-3 space-x-reverse">
                                                <button onclick="document.getElementById('editBrand{{ $brand->id }}').showModal()"
                                                    class="text-brand-blue hover:text-blue-900 font-bold" title="تعديل">تعديل</button>
                                                
                                                <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الماركة ؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold">حذف</button>
                                                </form>
                                            </div>

                                            <!-- Edit Modal -->
                                            <dialog id="editBrand{{ $brand->id }}" class="backdrop:bg-gray-900/50 p-0 rounded-2xl shadow-2xl border-0 w-11/12 max-w-lg mx-auto mt-20">
                                                <div class="bg-white p-6 text-right">
                                                    <div class="flex justify-between items-center mb-4 border-b pb-3">
                                                        <h3 class="font-bold text-lg">تعديل الماركة: {{ $brand->name }}</h3>
                                                        <button onclick="document.getElementById('editBrand{{ $brand->id }}').close()" class="text-gray-400">&times;</button>
                                                    </div>
                                                    <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="space-y-4">
                                                            <div>
                                                                <label class="block text-sm font-bold mb-1">اسم الماركة</label>
                                                                <input type="text" name="name" value="{{ $brand->name }}" class="w-full rounded-lg border-gray-300 py-2" required>
                                                            </div>
                                                            <div>
                                                                <label class="block text-sm font-bold mb-1">الشعار (اختياري)</label>
                                                                <input type="file" name="logo" class="w-full text-xs">
                                                            </div>
                                                        </div>
                                                        <div class="mt-6 flex justify-end gap-2">
                                                            <button type="button" onclick="document.getElementById('editBrand{{ $brand->id }}').close()" class="bg-gray-100 px-4 py-2 rounded-lg">إلغاء</button>
                                                            <button type="submit" class="bg-brand-blue text-white px-6 py-2 rounded-lg shadow-md">حفظ</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </dialog>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-6 py-10 text-center text-gray-500">لا توجد ماركات حالياً</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <dialog id="addBrandModal" class="backdrop:bg-gray-900/50 p-0 rounded-2xl shadow-2xl border-0 w-11/12 max-w-lg mx-auto mt-20">
        <div class="bg-white p-6 text-right">
            <div class="flex justify-between items-center mb-4 border-b pb-3">
                <h3 class="font-bold text-lg">إضافة ماركة جديدة</h3>
                <button onclick="document.getElementById('addBrandModal').close()" class="text-gray-400">&times;</button>
            </div>
            <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold mb-1">اسم الماركة</label>
                        <input type="text" name="name" class="w-full rounded-lg border-gray-300 py-2" placeholder="مثال: Apple" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">الشعار</label>
                        <input type="file" name="logo" class="w-full text-xs">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('addBrandModal').close()" class="bg-gray-100 px-4 py-2 rounded-lg">إلغاء</button>
                    <button type="submit" class="bg-brand-blue text-white px-6 py-2 rounded-lg shadow-md">إضافة</button>
                </div>
            </form>
        </div>
    </dialog>
</x-admin-layout>
