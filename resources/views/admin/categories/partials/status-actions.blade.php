@php
    $itemType = $item->parent_id ? ($item->is_brand ? 'brand' : 'subcategory') : 'category';
    // Preview link: Show products in this category
    $previewUrl = route('admin.products.index', ['category_id' => $item->id]);
@endphp

<td class="px-5 py-4 text-center whitespace-nowrap align-middle" {!! isset($rowspan) ? "rowspan=\"{$rowspan}\" :rowspan=\"expanded ? {$rowspan} : 1\"" : "" !!}>
    <form action="{{ route('admin.categories.toggleStatus', $item) }}" method="POST" class="inline-block">
        @csrf
        @method('PATCH')
        <button type="submit" 
            class="px-4 py-1.5 rounded-xl text-[10px] font-black transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5
            {{ $item->status === 'active' 
                ? 'bg-emerald-50 text-emerald-600 border border-emerald-100 hover:bg-emerald-600 hover:text-white' 
                : 'bg-amber-50 text-amber-600 border border-amber-100 hover:bg-amber-600 hover:text-white' }}">
            {{ $item->status === 'active' ? 'نشط' : 'معطل' }}
        </button>
    </form>
</td>

<td class="px-4 py-4 text-center whitespace-nowrap align-middle" {!! isset($rowspan) ? "rowspan=\"{$rowspan}\" :rowspan=\"expanded ? {$rowspan} : 1\"" : "" !!}>
    <div class="flex items-center justify-center space-x-3 space-x-reverse">

        <!-- Edit -->
        <button onclick="document.getElementById('editModal{{ $root->id }}').showModal()" 
            class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100 hover:bg-blue-600 hover:text-white hover:border-blue-600 shadow-sm transition-all duration-300 group">
            <svg class="w-4 h-4 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
        </button>

        <!-- Delete -->
        <form action="{{ route('admin.categories.destroy', $item) }}" method="POST" class="confirm-delete inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('هل أنت متأكد من الحذف؟')"
                class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center text-red-500 border border-red-100 hover:bg-red-600 hover:text-white hover:border-red-600 shadow-sm transition-all duration-300 group">
                <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </form>
    </div>
</td>
