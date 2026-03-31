<x-admin-layout>
    <x-slot name="title">
        إدارة التصنيفات
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <!-- Header & Actions -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <!-- Could add search here later -->
                </div>
                <button onclick="document.getElementById('addCategoryModal').showModal()"
                    class="bg-brand-blue hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-lg flex items-center shadow-md transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    إضافة تصنيف جديد
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

            @if($errors->any())
                <div class="mb-6 bg-red-100 border-r-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <svg class="fill-current h-6 w-6 text-red-500 ml-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">حدث خطأ أثناء المعالجة:</p>
                            <ul class="list-disc list-inside text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
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
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        الصورة
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        اسم التصنيف
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الوصف
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الحالة
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        عدد المنتجات
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">
                                        الإجراءات
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($categories as $category)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($category->image)
                                                <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                                    class="h-12 w-12 rounded-lg object-cover border border-gray-200 shadow-sm">
                                            @else
                                                <div
                                                    class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center border border-gray-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">{{ $category->name }}</div>
                                            @if($category->parent)
                                                <div class="text-[10px] text-brand-blue-600 font-semibold">تابعة لـ: {{ $category->parent->name }}</div>
                                            @endif
                                            @if($category->slug)
                                                <div class="text-[10px] text-gray-400">{{ $category->slug }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-500 max-w-xs truncate"
                                                title="{{ $category->description }}">
                                                {{ $category->description ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $category->status === 'active' ? 'نشط' : 'غير نشط' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                            {{ $category->products_count ?? 0 }} منتج
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center items-center space-x-3 space-x-reverse">
                                                @php
                                                    $currentParent = $category->parent;
                                                    $mainParentId = $currentParent ? ($currentParent->parent_id ?: $currentParent->id) : 'null';
                                                    $subParentId = ($currentParent && $currentParent->parent_id) ? $currentParent->id : 'null';
                                                @endphp
                                                <button onclick="initEditCategoryModal({{ $category->id }}, {{ $subParentId }}); edit{{ $category->id }}.showModal()"
                                                    class="text-brand-blue hover:text-blue-900 group" title="تعديل">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 transform group-hover:scale-110 transition-transform"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <form action="{{ route('admin.categories.destroy', $category) }}"
                                                    method="POST" class="no-confirm" data-confirm-title="حذف التصنيف"
                                                    data-confirm-text="هل أنت متأكد؟ سيتم حذف التصنيف وقد تتأثر المنتجات المرتبطة به."
                                                    data-confirm-button="نعم، احذف">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 group"
                                                        title="حذف">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 transform group-hover:scale-110 transition-transform"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>

                                            <dialog id="edit{{ $category->id }}" class="backdrop:bg-gray-900/50 p-0 rounded-2xl shadow-2xl border-0 w-11/12 max-w-4xl mx-auto mt-20">
                                                <div class="bg-white text-right flex flex-col max-h-[85vh]">
                                                    <!-- Header -->
                                                    <div class="p-6 border-b border-gray-100 flex-shrink-0 bg-gray-50 flex justify-between items-center">
                                                        <h3 class="font-bold text-xl text-brand-blue">تعديل التصنيف: {{ $category->name }}</h3>
                                                        <button type="button" onclick="edit{{ $category->id }}.close()" class="text-gray-400 hover:text-red-500 transition-colors">
                                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </div>

                                                    <!-- Body -->
                                                    <div class="p-8 overflow-y-auto">
                                                        <form id="form-edit-{{ $category->id }}" action="{{ route('admin.categories.update', $category) }}"
                                                            method="POST" enctype="multipart/form-data" class="no-confirm">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                                                <div class="space-y-6">
                                                                    <div>
                                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">اسم التصنيف <span class="text-red-500">*</span></label>
                                                                        <input type="text" name="name" value="{{ $category->name }}"
                                                                            class="w-full rounded-lg border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 py-3" required>
                                                                    </div>

                                                                    <div>
                                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">نوع التصنيف / التبعية</label>
                                                                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                                                            <div class="space-y-4">
                                                                                @php
                                                                                    $currentParent = $category->parent;
                                                                                    $mainParentId = $currentParent ? ($currentParent->parent_id ?: $currentParent->id) : null;
                                                                                    $subParentId = ($currentParent && $currentParent->parent_id) ? $currentParent->id : null;
                                                                                @endphp
                                                                                <!-- القسم الرئيسي -->
                                                                                <div>
                                                                                    <span class="text-[11px] text-gray-400 block mb-1">القسم الرئيسي</span>
                                                                                    <select id="main_parent_select_{{ $category->id }}" class="w-full rounded-lg border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 py-3 transition-all" onchange="handleMainParentChangeEdit(this, {{ $category->id }})">
                                                                                        <option value="">-- تصنيف رئيسي --</option>
                                                                                        @foreach($allCategories as $parent)
                                                                                            @if($parent->id != $category->id)
                                                                                                <option value="{{ $parent->id }}" data-children='@json($parent->children)' {{ $mainParentId == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>

                                                                                <!-- القسم الفرعي -->
                                                                                <div id="sub_parent_container_{{ $category->id }}" class="{{ $subParentId ? '' : 'hidden' }} animate-fade-in">
                                                                                    <span class="text-[11px] text-gray-400 block mb-1">القسم الفرعي الأوسط</span>
                                                                                    <select id="sub_parent_select_{{ $category->id }}" class="w-full rounded-lg border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 py-3" onchange="updateFinalParentIdEdit(this, {{ $category->id }})">
                                                                                        <option value="">-- لا يوجد (تابع للرئيسي) --</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="parent_id" id="final_parent_id_{{ $category->id }}" value="{{ $category->parent_id }}">
                                                                    </div>

                                                                    <div>
                                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">الحالة</label>
                                                                        <select name="status" class="w-full rounded-lg border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 py-3">
                                                                            <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>نشط</option>
                                                                            <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="space-y-6">
                                                                    <div>
                                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">الماركات المرتبطة</label>
                                                                        <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto p-3 border rounded-lg bg-gray-50">
                                                                            @foreach($brands as $brand)
                                                                                <label class="flex items-center space-x-2 space-x-reverse cursor-pointer hover:bg-white p-1 rounded transition">
                                                                                    <input type="checkbox" name="brand_ids[]" value="{{ $brand->id }}" 
                                                                                        {{ $category->brands->contains($brand->id) ? 'checked' : '' }}
                                                                                        class="rounded border-gray-300 text-brand-blue focus:ring-brand-blue">
                                                                                    <span class="text-xs text-gray-700">{{ $brand->name }}</span>
                                                                                </label>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>

                                                                <div class="space-y-6">
                                                                    <div>
                                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">الوصف</label>
                                                                        <textarea name="description" rows="5" class="w-full rounded-lg border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50" placeholder="اكتب وصفاً قصيراً للنظام...">{{ $category->description }}</textarea>
                                                                    </div>

                                                                    <div>
                                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">صورة التصنيف</label>
                                                                        <div class="flex items-center gap-4">
                                                                            @if($category->image)
                                                                                <div class="shrink-0">
                                                                                    <img src="{{ Storage::url($category->image) }}" class="h-16 w-16 object-cover rounded-lg border shadow-sm">
                                                                                </div>
                                                                            @endif
                                                                            <div class="w-full">
                                                                                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-brand-blue hover:file:bg-blue-100 border border-gray-200 rounded-lg p-1 transition-all">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <!-- Footer -->
                                                    <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 flex-shrink-0">
                                                        <button type="button" onclick="edit{{ $category->id }}.close()" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-2.5 px-6 rounded-lg transition-colors shadow-sm">إلغاء</button>
                                                        <button type="submit" form="form-edit-{{ $category->id }}" class="bg-brand-blue hover:bg-blue-800 text-white font-bold py-2.5 px-8 rounded-lg shadow-md transition-colors">حفظ التعديلات</button>
                                                    </div>
                                                </div>
                                            </dialog>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                                <p class="text-lg font-medium mb-1">لا توجد تصنيفات مضافة حتى الآن</p>
                                                <p class="text-sm">ابدأ بإضافة تصنيفات لمنتجات متجرك</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 px-4 py-2">
                        {{ $categories->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <dialog id="addCategoryModal" class="backdrop:bg-gray-900/50 p-0 rounded-2xl shadow-2xl border-0 w-11/12 max-w-4xl mx-auto mt-20">
        <div class="bg-white text-right flex flex-col max-h-[85vh]">
            <!-- Header -->
            <div class="p-6 border-b border-gray-100 flex-shrink-0 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-xl text-brand-blue">إضافة تصنيف جديد</h3>
                <button type="button" onclick="document.getElementById('addCategoryModal').close()" class="text-gray-400 hover:text-red-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Body -->
            <div class="p-8 overflow-y-auto">
                <form id="form-add-category" action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">اسم التصنيف <span class="text-red-500">*</span></label>
                                <input type="text" name="name" class="w-full rounded-lg border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 py-3" placeholder="مثال: لابتوبات" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">نوع التصنيف / التبعية</label>
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                    <div class="space-y-4">
                                        <!-- القسم الرئيسي -->
                                        <div>
                                            <span class="text-[11px] text-gray-400 block mb-1">القسم الرئيسي (اتركه إذا كان هذا قسماً رئيسياً جديداً)</span>
                                            <select id="main_parent_select" class="w-full rounded-lg border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 py-3 transition-all" onchange="handleMainParentChange(this)">
                                                <option value="">-- اختر القسم الأب (اختياري) --</option>
                                                @foreach($allCategories as $parent)
                                                    <option value="{{ $parent->id }}" data-children='@json($parent->children)'>{{ $parent->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- القسم الفرعي (يظهر ديناميكياً) -->
                                        <div id="sub_parent_container" class="hidden animate-fade-in">
                                            <span class="text-[11px] text-gray-400 block mb-1">القسم الفرعي الأوسط (اختياري)</span>
                                            <select id="sub_parent_select" class="w-full rounded-lg border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 py-3" onchange="updateFinalParentId(this)">
                                                <option value="">-- لا يوجد (اجعله تابعاً للرئيسي مباشرة) --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="parent_id" id="final_parent_id" value="">
                                
                                <script>
                                    function handleMainParentChange(select) {
                                        const subContainer = document.getElementById('sub_parent_container');
                                        const subSelect = document.getElementById('sub_parent_select');
                                        const finalInput = document.getElementById('final_parent_id');
                                        
                                        finalInput.value = select.value;
                                        
                                        const selectedOption = select.options[select.selectedIndex];
                                        if (select.value && selectedOption.dataset.children) {
                                            const children = JSON.parse(selectedOption.dataset.children);
                                            if (children.length > 0) {
                                                subSelect.innerHTML = '<option value="">-- لا يوجد (اجعله تابعاً للرئيسي مباشرة) --</option>';
                                                children.forEach(child => {
                                                    const opt = document.createElement('option');
                                                    opt.value = child.id;
                                                    opt.textContent = child.name;
                                                    subSelect.appendChild(opt);
                                                });
                                                subContainer.classList.remove('hidden');
                                            } else {
                                                subContainer.classList.add('hidden');
                                            }
                                        } else {
                                            subContainer.classList.add('hidden');
                                        }
                                    }

                                    function updateFinalParentId(select) {
                                        const mainSelect = document.getElementById('main_parent_select');
                                        const finalInput = document.getElementById('final_parent_id');
                                        
                                        if (select.value) {
                                            finalInput.value = select.value;
                                        } else {
                                            finalInput.value = mainSelect.value;
                                        }
                                    }
                                </script>
                            </div>

                            <script>
                                function handleMainParentChangeEdit(select, id) {
                                    const subContainer = document.getElementById('sub_parent_container_' + id);
                                    const subSelect = document.getElementById('sub_parent_select_' + id);
                                    const finalInput = document.getElementById('final_parent_id_' + id);
                                    
                                    finalInput.value = select.value;
                                    
                                    const selectedOption = select.options[select.selectedIndex];
                                    if (select.value && selectedOption.dataset.children) {
                                        const children = JSON.parse(selectedOption.dataset.children);
                                        if (children.length > 0) {
                                            subSelect.innerHTML = '<option value="">-- لا يوجد (تابع للرئيسي) --</option>';
                                            children.forEach(child => {
                                                const opt = document.createElement('option');
                                                opt.value = child.id;
                                                opt.textContent = child.name;
                                                subSelect.appendChild(opt);
                                            });
                                            subContainer.classList.remove('hidden');
                                        } else {
                                            subContainer.classList.add('hidden');
                                        }
                                    } else {
                                        subContainer.classList.add('hidden');
                                    }
                                }

                                function updateFinalParentIdEdit(select, id) {
                                    const mainSelect = document.getElementById('main_parent_select_' + id);
                                    const finalInput = document.getElementById('final_parent_id_' + id);
                                    
                                    if (select.value) {
                                        finalInput.value = select.value;
                                    } else {
                                        finalInput.value = mainSelect.value;
                                    }
                                }

                                function initEditCategoryModal(id, subParentId) {
                                    const mainSelect = document.getElementById('main_parent_select_' + id);
                                    const subSelect = document.getElementById('sub_parent_select_' + id);
                                    const subContainer = document.getElementById('sub_parent_container_' + id);

                                    if (mainSelect.value) {
                                        const selectedOption = mainSelect.options[mainSelect.selectedIndex];
                                        if (selectedOption.dataset.children) {
                                            const children = JSON.parse(selectedOption.dataset.children);
                                            if (children.length > 0) {
                                                subSelect.innerHTML = '<option value="">-- لا يوجد (تابع للرئيسي) --</option>';
                                                children.forEach(child => {
                                                    const opt = document.createElement('option');
                                                    opt.value = child.id;
                                                    opt.textContent = child.name;
                                                    if (child.id == subParentId) opt.selected = true;
                                                    subSelect.appendChild(opt);
                                                });
                                                subContainer.classList.remove('hidden');
                                            }
                                        }
                                    }
                                }
                            </script>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">الماركات المرتبطة</label>
                                <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto p-3 border rounded-lg bg-gray-50">
                                    @foreach($brands as $brand)
                                        <label class="flex items-center space-x-2 space-x-reverse cursor-pointer hover:bg-white p-1 rounded transition">
                                            <input type="checkbox" name="brand_ids[]" value="{{ $brand->id }}" class="rounded border-gray-300 text-brand-blue focus:ring-brand-blue">
                                            <span class="text-xs text-gray-700">{{ $brand->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">الحالة</label>
                                <select name="status" class="w-full rounded-lg border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 py-3">
                                    <option value="active">نشط</option>
                                    <option value="inactive">غير نشط</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">الوصف</label>
                                <textarea name="description" rows="5" class="w-full rounded-lg border-gray-300 focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50" placeholder="اكتب وصفاً قصيراً للتصنيف..."></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">صورة التصنيف</label>
                                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-brand-blue hover:file:bg-blue-100 border border-gray-200 rounded-lg p-1 transition-all">
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 flex-shrink-0">
                <button type="button" onclick="document.getElementById('addCategoryModal').close()" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-2.5 px-6 rounded-lg transition-colors shadow-sm">إلغاء</button>
                <button type="submit" form="form-add-category" class="bg-brand-blue hover:bg-blue-800 text-white font-bold py-2.5 px-8 rounded-lg shadow-md transition-colors">حفظ وإضافة</button>
            </div>
        </div>
    </dialog>
</x-admin-layout>