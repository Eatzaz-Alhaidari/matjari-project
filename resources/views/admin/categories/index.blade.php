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
                        <table class="min-w-full text-right">
                            <thead class="bg-brand-blue-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase tracking-wider">التصنيف</th>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase tracking-wider text-center">الصورة</th>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase tracking-wider">التصنيف الفرعي</th>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase tracking-wider text-center">الصورة</th>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase tracking-wider">الماركة</th>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase tracking-wider text-center">الصورة</th>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase tracking-wider text-center">الحالة</th>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase tracking-wider text-center">الإجراءات</th>
                                </tr>
                            </thead>
                            @forelse($categories as $category)
                                @php
                                    $subcategories = $category->children->where('is_brand', false)->values();
                                    $brands = $category->children->where('is_brand', true)->values();
                                    
                                    $flattened = [];
                                    $max = max($subcategories->count(), $brands->count());
                                    
                                    if ($max == 0) {
                                        $flattened = [];
                                    } else {
                                        for($i=0; $i<$max; $i++) {
                                            $flattened[] = [
                                                'sub' => $subcategories->get($i),
                                                'brand' => $brands->get($i)
                                            ];
                                        }
                                    }
                                    $totalRows = count($flattened);
                                @endphp

                                <tbody x-data="{ expanded: false }" class="divide-y divide-gray-100 border-b border-gray-200">
                                    @if($totalRows === 0)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-5 py-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $category->name }}</div>
                                            </td>
                                            <td class="px-5 py-4 text-center">
                                                @if($category->image)
                                                    <img src="{{ Storage::url($category->image) }}" class="w-10 h-10 rounded-full border border-gray-200 shadow-sm mx-auto object-contain bg-white">
                                                @endif
                                            </td>
                                            <td colspan="4" class="px-5 py-4 text-xs text-gray-400 italic text-center">لا توجد أفرع أو ماركات</td>
                                            @include('admin.categories.partials.status-actions', ['item' => $category, 'root' => $category])
                                        </tr>
                                    @else
                                        @foreach($flattened as $index => $row)
                                            @php
                                                $sub = $row['sub'];
                                                $brand = $row['brand'];
                                                $isFirstOverall = ($index === 0);
                                            @endphp
                                            <tr class="hover:bg-gray-50 transition-colors"
                                                x-show="{{ $isFirstOverall ? 'true' : 'expanded' }}"
                                                @if(!$isFirstOverall) x-transition:enter="transition duration-200" x-transition:enter-start="opacity-0 -translate-y-1" @endif>
                                                
                                                @if($isFirstOverall)
                                                    <td class="px-5 py-4 align-top font-bold text-gray-900" rowspan="{{ $totalRows }}" :rowspan="expanded ? {{ $totalRows }} : 1">
                                                        {{ $category->name }}
                                                    </td>
                                                    <td class="px-5 py-4 align-top text-center" rowspan="{{ $totalRows }}" :rowspan="expanded ? {{ $totalRows }} : 1">
                                                        @if($category->image)
                                                            <img src="{{ Storage::url($category->image) }}" class="w-10 h-10 rounded-full shadow-sm mx-auto object-contain border border-gray-200 bg-white">
                                                        @endif
                                                    </td>
                                                @endif

                                                <td class="px-5 py-4">
                                                    <div class="flex items-center gap-2">
                                                        <div class="text-sm font-medium text-gray-900">{{ $sub ? $sub->name : '-' }}</div>
                                                        @if($isFirstOverall && $totalRows > 1)
                                                            <button @click="expanded = !expanded" class="text-[10px] text-brand-blue hover:text-brand-blue-800 font-bold bg-brand-blue-50 px-2 py-0.5 rounded-md flex items-center gap-1 transition-colors border border-brand-blue-100">
                                                                <span x-text="expanded ? 'إخفاء' : '+ {{ $totalRows - 1 }}'"></span>
                                                                <svg class="w-3 h-3 transition-transform" :class="{'rotate-180': expanded}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-5 py-4 text-center">
                                                    @if($sub && $sub->icon)
                                                        <img src="{{ Storage::url($sub->icon) }}" class="w-8 h-8 rounded-lg mx-auto object-contain bg-white border border-gray-100 shadow-sm">
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td class="px-5 py-4">
                                                    <div class="text-sm text-gray-700">{{ $brand ? $brand->name : '-' }}</div>
                                                </td>
                                                <td class="px-5 py-4 text-center">
                                                    @if($brand && ($brand->brand_logo ?? $brand->image))
                                                        <img src="{{ Storage::url($brand->brand_logo ?? $brand->image) }}" class="w-8 h-8 rounded-full mx-auto object-contain bg-white border border-gray-100 shadow-sm">
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                @if($isFirstOverall)
                                                    @include('admin.categories.partials.status-actions', ['item' => $category, 'root' => $category, 'rowspan' => $totalRows])
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            @empty
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="px-6 py-20 text-center text-gray-500 font-medium">لم يتم العثور على أي تصنيفات</td>
                                    </tr>
                                </tbody>
                            @endforelse
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($categories->hasPages())
                        <div class="mt-8 font-sans">
                            {{ $categories->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('admin.categories.partials.modals')

</x-admin-layout>