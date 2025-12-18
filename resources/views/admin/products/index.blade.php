<x-admin-layout>
    <x-slot name="title">
        إدارة المنتجات
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 px-4 py-2 bg-red-100 border border-red-200 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-brand-blue-800">قائمة المنتجات</h2>
                        <a href="{{ route('admin.products.create') }}"
                            class="px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow-md hover:bg-brand-blue-700">
                            + إضافة منتج جديد
                        </a>
                    </div>

                    <!-- Search Form -->
                    <div class="mb-6">
                        <form action="{{ route('admin.products.index') }}" method="GET" class="flex items-center">
                            <input type="text" name="search" placeholder="ابحث باسم المنتج أو الوصف..."
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
                                        المنتج</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الماركة</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        السعر</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        المخزون</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الحالة</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        المتجر</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        التصنيف</th>
                                    <th
                                        class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($products as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4">
                                            <div class="flex items-center">
                                                @if($product->image)
                                                    <div class="flex-shrink-0 w-10 h-10 ml-3">
                                                        <img class="w-10 h-10 rounded-full object-cover"
                                                            src="{{ asset('storage/' . $product->image) }}"
                                                            alt="{{ $product->name }}">
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ Str::limit($product->description, 30) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            {{ $product->brand ?? 'غير محدد' }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            {{ number_format($product->price, 2) }} ر.س
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            {{ $product->stock }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-900">
                                            <span class="px-2 py-1 text-xs rounded-full font-semibold 
                                                {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $product->status === 'active' ? 'نشط' : 'معطل' }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-500">
                                            {{ $product->store->name ?? 'غير محدد' }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-500">
                                            {{ $product->category->name ?? 'غير محدد' }}
                                        </td>
                                        <td class="px-5 py-4 text-center text-sm font-medium">
                                            <div class="flex items-center justify-center space-x-2 space-x-reverse">
                                                <a href="{{ route('admin.products.show', $product->id) }}"
                                                    class="px-2 py-1 text-xs rounded-full font-semibold bg-gray-100 text-gray-800 hover:bg-gray-200"
                                                    title="عرض التفاصيل">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.products.toggleStatus', $product->id) }}"
                                                    method="POST"
                                                    class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="px-2 py-1 text-xs rounded-full font-semibold 
                                                        {{ $product->status === 'active' ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }}">
                                                        {{ $product->status === 'active' ? 'تعطيل' : 'تفعيل' }}
                                                    </button>
                                                </form>
                                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                                    class="px-2 py-1 text-xs rounded-full font-semibold bg-blue-100 text-blue-800 hover:bg-blue-200">تعديل</a>
                                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');"
                                                    class="inline-block">
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
                                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">لا توجد منتجات حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>