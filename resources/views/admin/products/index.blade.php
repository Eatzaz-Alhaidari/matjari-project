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

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        صورة المنتج
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        المنتج
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        التصنيف
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الماركة
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        السعر
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        المخزون
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الضمان
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الحالة
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        المتجر
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الإجراءات
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($products as $product)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($product->image)
                                                <div class="flex-shrink-0 h-16 w-16 cursor-pointer"
                                                    onclick="window.location.href='{{ route('admin.products.show', $product->id) }}'">
                                                    <img class="h-16 w-16 rounded-lg object-cover border border-gray-200"
                                                        src="{{ asset('storage/' . $product->image) }}"
                                                        alt="{{ $product->name }}">
                                                </div>
                                            @else
                                                <div
                                                    class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center border border-gray-200">
                                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <div class="text-sm font-bold text-gray-900 cursor-pointer hover:text-brand-blue"
                                                    onclick="window.location.href='{{ route('admin.products.show', $product->id) }}'">
                                                    {{ $product->name }}
                                                </div>
                                                <div class="text-xs text-gray-500 max-w-xs truncate">
                                                    {{ $product->description }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $product->category->name ?? 'غير محدد' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $product->brand ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900">
                                                {{ number_format($product->price, 2) }}
                                                <span class="text-xs text-gray-500">
                                                    {{ $product->currency == 'USD' ? '$' : ($product->currency == 'SAR' ? 'ر.س' : 'ر.ي') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ $product->stock }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $product->warranty ?? 'لا يوجد' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                <span
                                                    class="w-1.5 h-1.5 {{ $product->status === 'active' ? 'bg-green-400' : 'bg-gray-400' }} rounded-full ml-1.5"></span>
                                                {{ $product->status === 'active' ? 'نشط' : 'معطل' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $product->store->name ?? 'غير محدد' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm font-medium"
                                            onclick="event.stopPropagation()">
                                            <div class="flex items-center justify-center space-x-2 space-x-reverse">
                                                <a href="{{ route('admin.products.show', $product->id) }}"
                                                    class="px-2 py-1 text-xs rounded-full font-semibold bg-gray-100 text-gray-800 hover:bg-gray-200"
                                                    title="عرض التفاصيل">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.products.toggleStatus', $product->id) }}"
                                                    method="POST" class="inline-block"
                                                    data-confirm-title="تغيير حالة المنتج"
                                                    data-confirm-text="{{ $product->status === 'active' ? 'سيتم تعطيل المنتج.' : 'سيتم تفعيل المنتج.' }}"
                                                    data-confirm-button="نعم، غير الحالة">
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
                                                    method="POST" class="inline-block" data-confirm-title="حذف المنتج"
                                                    data-confirm-text="هل أنت متأكد من حذف هذا المنتج؟"
                                                    data-confirm-button="حذف">
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
                                        <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                    </path>
                                                </svg>
                                                <p class="text-lg font-medium text-gray-900">لا توجد منتجات حالياً</p>
                                                <p class="text-sm text-gray-500 mb-4">ابدأ بإضافة منتجاتك الأولى إلى المتجر
                                                </p>
                                            </div>
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