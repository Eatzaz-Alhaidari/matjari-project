<!-- Main Add Category Modal -->
<dialog id="addCategoryModal" class="p-0 rounded-[2rem] shadow-2xl border-0 w-full max-w-lg overflow-hidden backdrop:bg-brand-blue/20 backdrop:backdrop-blur-sm"
    x-data="{ 
        subs: [{name: '', id: Date.now()}],
        brands: [{name: '', id: Date.now()}],
        addSub() { this.subs.push({name: '', id: Date.now()}) },
        removeSub(index) { if(this.subs.length > 1) this.subs.splice(index, 1) },
        addBrand() { this.brands.push({name: '', id: Date.now()}) },
        removeBrand(index) { if(this.brands.length > 1) this.brands.splice(index, 1) }
    }">
    <div class="bg-white text-right font-sans">
        <!-- Compact RTL Header: Title Right, X Left -->
        <div class="px-6 py-4 bg-brand-blue text-white flex items-center justify-between">
            <h3 class="text-lg font-bold order-1">إضافة تصنيف متكامل</h3>
            <button onclick="this.closest('dialog').close()" class="p-2 hover:bg-white/10 rounded-full transition-colors order-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="p-6 max-h-[80vh] overflow-y-auto no-scrollbar">
            @csrf
            
            <div class="space-y-6">
                <!-- Section 1: Root -->
                <div class="bg-brand-blue-50/50 p-5 rounded-[1.5rem] border border-brand-blue-100">
                    <h4 class="text-brand-blue-900 font-black mb-4 border-r-4 border-brand-blue pr-3">1. التصنيف الرئيسي</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">اسم التصنيف</label>
                            <input type="text" name="name" class="w-full px-4 py-3 rounded-xl border-gray-100 shadow-sm focus:ring-brand-blue" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">صورة التصنيف</label>
                            <input type="file" name="image" class="w-full text-[10px] text-gray-400">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Sub-categories -->
                <div class="bg-violet-50/50 p-5 rounded-[1.5rem] border border-violet-100">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-violet-900 font-black border-r-4 border-violet-400 pr-3 order-1">2. التصنيفات الفرعية</h4>
                        <button type="button" @click="addSub()" class="px-3 py-1.5 bg-violet-600 text-white text-[10px] font-bold rounded-lg shadow-md hover:bg-violet-700 transition-all order-2">إضافة فرع +</button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(sub, index) in subs" :key="sub.id">
                            <div class="p-4 bg-white rounded-xl border border-gray-100 shadow-sm relative">
                                <button type="button" @click="removeSub(index)" x-show="subs.length > 1" class="absolute top-2 left-2 w-6 h-6 flex items-center justify-center text-red-300 hover:text-red-500 hover:bg-red-50 rounded-full transition-colors text-lg">×</button>
                                <div class="grid grid-cols-1 gap-3">
                                    <input type="text" name="sub_names[]" x-model="sub.name" class="w-full px-3 py-2 text-sm rounded-lg border-gray-50 bg-gray-50/30" placeholder="اسم الفرع">
                                    <input type="file" :name="'sub_icons['+index+']'" class="text-[9px] text-gray-400">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Section 3: Brands -->
                <div class="bg-gray-50/50 p-5 rounded-[1.5rem] border border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-gray-900 font-black border-r-4 border-gray-400 pr-3 order-1">3. الماركات</h4>
                        <button type="button" @click="addBrand()" class="px-3 py-1.5 bg-gray-600 text-white text-[10px] font-bold rounded-lg shadow-md hover:bg-gray-700 transition-all order-2">إضافة ماركة +</button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(brand, index) in brands" :key="brand.id">
                            <div class="p-4 bg-white rounded-xl border border-gray-100 shadow-sm relative">
                                <button type="button" @click="removeBrand(index)" x-show="brands.length > 1" class="absolute top-2 left-2 w-6 h-6 flex items-center justify-center text-red-200 hover:text-red-500 hover:bg-red-50 rounded-full transition-colors text-lg">×</button>
                                <div class="grid grid-cols-1 gap-3">
                                    <input type="text" name="brand_names[]" x-model="brand.name" class="w-full px-3 py-2 text-sm rounded-lg border-gray-50 bg-gray-50/30" placeholder="اسم الماركة">
                                    <input type="file" :name="'brand_logos['+index+']'" class="text-[9px] text-gray-400">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Status Select Fix -->
                <div class="flex items-center justify-between p-4 bg-brand-blue-50/30 rounded-2xl border border-brand-blue-100">
                    <span class="text-sm font-black text-brand-blue-900 border-r-2 border-brand-blue pr-2">حالة التصنيف</span>
                    <div class="relative min-w-[140px]">
                        <select name="status" class="w-full pl-4 pr-4 py-2 rounded-xl border-gray-200 text-xs font-bold text-gray-700 bg-white shadow-sm focus:ring-brand-blue focus:border-brand-blue transition-all hover:bg-gray-50 cursor-pointer text-center">
                            <option value="active" selected>نشط</option>
                            <option value="inactive">معطل</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 py-3 bg-brand-blue text-white font-black rounded-2xl shadow-xl hover:bg-brand-blue-700 transition-all">حفظ التصنيف</button>
                    <button type="button" onclick="this.closest('dialog').close()" class="px-8 py-3 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200">إلغاء</button>
                </div>
            </div>
        </form>
    </div>
</dialog>

<!-- Unified Comprehensive Edit Modal (Root-Level Only) -->
@foreach($categories->getCollection() as $root)
<dialog id="editModal{{ $root->id }}" class="p-0 rounded-[2rem] shadow-2xl border-0 w-full max-w-lg overflow-hidden backdrop:bg-brand-blue/20 backdrop:backdrop-blur-sm text-right font-sans"
    x-data="{ 
        subs: {{ json_encode($root->children()->where('is_brand', false)->get()->map(fn($s) => ['id' => $s->id, 'name' => $s->name, 'icon' => $s->icon])) }},
        brands: {{ json_encode($root->children()->where('is_brand', true)->get()->map(fn($b) => ['id' => $b->id, 'name' => $b->name, 'logo' => $b->brand_logo])) }},
        addSub() { this.subs.push({id: null, name: '', icon: null}) },
        removeSub(index) { if(this.subs.length > 0) this.subs.splice(index, 1) },
        addBrand() { this.brands.push({id: null, name: '', logo: null}) },
        removeBrand(index) { if(this.brands.length > 0) this.brands.splice(index, 1) }
    }">
    <div class="bg-white">
        <!-- Compact RTL Header -->
        <div class="px-6 py-4 bg-brand-blue text-white flex items-center justify-between">
            <h3 class="text-lg font-bold order-1">تعديل التصنيف: {{ $root->name }}</h3>
            <button onclick="this.closest('dialog').close()" class="p-2 hover:bg-white/10 rounded-full transition-colors order-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="{{ route('admin.categories.update', $root) }}" method="POST" enctype="multipart/form-data" class="p-6 max-h-[80vh] overflow-y-auto no-scrollbar">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Root Section -->
                <div class="bg-brand-blue-50/50 p-5 rounded-[1.5rem] border border-brand-blue-100">
                    <h4 class="text-brand-blue-900 font-bold mb-3 border-r-4 border-brand-blue pr-3 text-sm">1. التصنيف الرئيسي</h4>
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" name="name" value="{{ $root->name }}" class="w-full px-4 py-2.5 rounded-xl border-gray-100 bg-white text-sm focus:ring-brand-blue" required>
                        <div class="flex items-center gap-4">
                            @if($root->image)
                                <img src="{{ Storage::url($root->image) }}" class="w-12 h-12 rounded-lg object-contain bg-white border">
                            @endif
                            <input type="file" name="image" class="text-[10px] text-gray-400">
                        </div>
                    </div>
                </div>

                <!-- Sub-categories Section (Repeater) -->
                <div class="bg-violet-50/50 p-5 rounded-[1.5rem] border border-violet-100">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-violet-900 font-black border-r-4 border-violet-400 pr-3 order-1 text-sm">2. التصنيفات الفرعية</h4>
                        <button type="button" @click="addSub()" class="px-3 py-1.5 bg-violet-600 text-white text-[10px] font-bold rounded-lg shadow-md hover:bg-violet-700 transition-all order-2">إضافة فرع +</button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(sub, index) in subs" :key="index">
                            <div class="p-4 bg-white rounded-xl border border-gray-100 shadow-sm relative">
                                <button type="button" @click="removeSub(index)" class="absolute top-2 left-2 w-6 h-6 flex items-center justify-center text-red-300 hover:text-red-500 hover:bg-red-50 rounded-full transition-colors text-lg">×</button>
                                <input type="hidden" name="sub_ids[]" :value="sub.id">
                                <div class="grid grid-cols-1 gap-3">
                                    <input type="text" name="sub_names[]" x-model="sub.name" class="w-full px-3 py-2 text-sm rounded-lg border-gray-50 bg-gray-50/30" placeholder="اسم الفرع">
                                    <div class="flex items-center gap-3">
                                        <template x-if="sub.icon">
                                            <img :src="'/storage/' + sub.icon" class="w-8 h-8 rounded-lg object-contain bg-gray-50">
                                        </template>
                                        <input type="file" :name="'sub_icons['+index+']'" class="text-[9px] text-gray-400">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Brands Section (Repeater) -->
                <div class="bg-gray-50/50 p-5 rounded-[1.5rem] border border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-gray-900 font-black border-r-4 border-gray-400 pr-3 order-1 text-sm">3. الماركات</h4>
                        <button type="button" @click="addBrand()" class="px-3 py-1.5 bg-gray-600 text-white text-[10px] font-bold rounded-lg shadow-md hover:bg-gray-700 transition-all order-2">ماركة جديدة +</button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(brand, index) in brands" :key="index">
                            <div class="p-4 bg-white rounded-xl border border-gray-100 shadow-sm relative">
                                <button type="button" @click="removeBrand(index)" class="absolute top-2 left-2 w-6 h-6 flex items-center justify-center text-red-200 hover:text-red-500 hover:bg-red-50 rounded-full transition-colors text-lg">×</button>
                                <input type="hidden" name="brand_ids[]" :value="brand.id">
                                <div class="grid grid-cols-1 gap-3">
                                    <input type="text" name="brand_names[]" x-model="brand.name" class="w-full px-3 py-2 text-sm rounded-lg border-gray-50 bg-gray-50/30" placeholder="اسم الماركة">
                                    <div class="flex items-center gap-3">
                                        <template x-if="brand.logo">
                                            <img :src="'/storage/' + brand.logo" class="w-8 h-8 rounded-lg object-contain bg-gray-50">
                                        </template>
                                        <input type="file" :name="'brand_logos['+index+']'" class="text-[9px] text-gray-400">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Status Select Fix -->
                <div class="flex items-center justify-between p-4 bg-brand-blue-50/30 rounded-2xl border border-brand-blue-100">
                    <span class="text-sm font-black text-brand-blue-900 border-r-2 border-brand-blue pr-2">حالة التصنيف</span>
                    <div class="relative min-w-[140px]">
                        <select name="status" class="w-full pl-4 pr-4 py-2 rounded-xl border-gray-200 text-xs font-bold text-gray-700 bg-white shadow-sm focus:ring-brand-blue focus:border-brand-blue transition-all hover:bg-gray-50 cursor-pointer text-center">
                            <option value="active" {{ $root->status == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="inactive" {{ $root->status == 'inactive' ? 'selected' : '' }}>معطل</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 py-3 bg-brand-blue text-white font-black rounded-2xl shadow-xl hover:bg-brand-blue-700 transition-all">حفظ التغييرات</button>
                    <button type="button" onclick="this.closest('dialog').close()" class="px-8 py-3 bg-gray-100 text-gray-500 font-bold rounded-2xl hover:bg-gray-200">إلغاء</button>
                </div>
            </div>
        </form>
    </div>
</dialog>
@endforeach
