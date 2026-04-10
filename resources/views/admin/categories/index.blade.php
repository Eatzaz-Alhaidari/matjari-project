<x-admin-layout>
    <x-slot name="title">
        إدارة التصنيفات
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-brand-blue-800">قائمة التصنيفات</h2>
                        <button onclick="document.getElementById('addCategoryModal').showModal()"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow-md hover:bg-brand-blue-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span>إضافة تصنيف</span>
                        </button>
                    </div>

                    <div class="mb-6">
                        <form action="{{ route('admin.categories.index') }}" method="GET" class="flex items-center">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="ابحث باسم التصنيف..."
                                class="w-full md:w-1/3 border-gray-300 rounded-lg shadow-sm">
                            <button type="submit" class="mr-3 px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow-md hover:bg-brand-blue-700 transition-all">بحث</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto bg-white min-h-[400px]">
                        <table class="min-w-full text-right divide-y divide-gray-200">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th class="px-5 py-4 text-xs font-bold text-brand-blue-800 uppercase tracking-wider w-1/4">قسم السوبر (الرئيسي)</th>
                                    <th class="px-5 py-4 text-xs font-bold text-brand-blue-800 uppercase tracking-wider w-1/3 text-right">الأقسام الفرعية</th>
                                    <th class="px-5 py-4 text-xs font-bold text-brand-blue-800 uppercase tracking-wider w-1/4 text-right">الماركات الشائعة</th>
                                    <th class="px-5 py-4 text-xs font-bold text-brand-blue-800 uppercase tracking-wider text-center">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($categories as $category)
                                    @php
                                        $subcategories = $category->children->where('is_brand', false);
                                        $brands = $category->children->where('is_brand', true);
                                    @endphp
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <!-- القسم الرئيسي -->
                                        <td class="px-5 py-6 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0 w-12 h-12 bg-white rounded-xl border border-gray-100 shadow-sm flex items-center justify-center p-1.5 overflow-hidden">
                                                    @if($category->image)
                                                        <img src="{{ Storage::url($category->image) }}" class="w-full h-full object-contain">
                                                    @else
                                                        <div class="text-gray-300">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-brand-blue-900">{{ $category->name }}</div>
                                                    <div class="text-[10px] text-gray-400">ID: #{{ $category->id }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- الأقسام الفرعية -->
                                        <td class="px-5 py-6">
                                            <div class="flex flex-wrap gap-2">
                                                @forelse($subcategories as $sub)
                                                    <div class="inline-flex items-center bg-blue-50 text-brand-blue-700 px-2.5 py-1 rounded-lg border border-blue-100 shadow-sm hover:bg-blue-100 transition-colors cursor-default">
                                                        <span class="text-xs font-bold">{{ $sub->name }}</span>
                                                    </div>
                                                @empty
                                                    <span class="text-xs text-gray-300 italic">لا توجد أقسام فرعية</span>
                                                @endforelse
                                            </div>
                                        </td>

                                        <!-- الماركات -->
                                        <td class="px-5 py-6">
                                            <div class="flex flex-wrap gap-1.5">
                                                @forelse($brands as $brand)
                                                    <div class="inline-flex items-center bg-gray-50 text-gray-600 px-2 py-1 rounded-md border border-gray-100 hover:border-brand-blue-200 transition-all group cursor-default">
                                                        <span class="text-[10px] font-medium group-hover:text-brand-blue">{{ $brand->name }}</span>
                                                    </div>
                                                @empty
                                                    <span class="text-xs text-gray-300 italic">لا توجد ماركات</span>
                                                @endforelse
                                            </div>
                                        </td>

                                        <!-- الإجراءات -->
                                        <td class="px-5 py-6 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <!-- زر الحالة -->
                                                <form action="{{ route('admin.categories.toggleStatus', $category->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 text-[10px] font-bold rounded-full {{ $category->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                                        {{ $category->status === 'active' ? 'نشط' : 'معطل' }}
                                                    </button>
                                                </form>

                                                <!-- تعديل -->
                                                <button onclick="editCategory({{ $category->id }})" class="p-2 text-brand-blue hover:bg-brand-blue-50 rounded-lg transition-colors shadow-sm bg-white border border-gray-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>

                                                <!-- حذف -->
                                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('حذف هذا القسم سيؤدي لحذف كافة توابعه، هل أنت متاكد؟')" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors shadow-sm bg-white border border-gray-100">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-20 text-center text-gray-400 italic">لم يتم العثور على أي تصنيفات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($categories->hasPages())
                        <div class="mt-8">
                            {{ $categories->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('admin.categories.partials.modals')

    @push('scripts')
    <script>
        function editCategory(id) {
            const modal = document.getElementById('editModal' + id);
            if (modal) {
                modal.showModal();
            } else {
                console.error('Modal not found for category ID: ' + id);
            }
        }
    </script>
    @endpush

</x-admin-layout>