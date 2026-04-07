<x-admin-layout>
    <x-slot name="title">إضافة إعلان جديد</x-slot>

    <div class="py-8 min-h-screen bg-slate-50/50" x-data="{ 
        title: '', 
        budget: 0, 
        imagePreview: null,
        handleImage(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => this.imagePreview = e.target.result;
                reader.readAsDataURL(file);
            }
        }
    }">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs / Back -->
            <div class="mb-8 flex items-center justify-between">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.advertisements.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-brand-blue transition-colors">
                                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                                الإعلانات
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400 rotate-180" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="mr-1 text-sm font-bold text-brand-blue md:mr-2">إضافة إعلان جديد</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="relative">
                <!-- Decorative Elements -->
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-brand-blue/5 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-emerald-500/5 rounded-full blur-3xl"></div>

                <div class="bg-white/70 backdrop-blur-xl overflow-hidden shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] sm:rounded-[32px] border border-white/80 relative z-10">
                    <div class="p-6 md:p-10">
                        
                        <div class="max-w-2xl mx-auto">
                            <header class="text-center mb-10">
                                <div class="inline-flex p-3 bg-brand-blue-50 rounded-2xl mb-4 text-brand-blue ring-4 ring-brand-blue/5">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                </div>
                                <h1 class="text-xl font-black text-brand-blue-900 tracking-tight mb-2">إنشاء إعلان متميز</h1>
                                <p class="text-gray-400 text-xs font-medium max-w-sm mx-auto leading-relaxed">املأ البيانات أدناه لإطلاق حملة إعلانية جديدة مخصصة لمتجر شريك.</p>
                            </header>

                            <form action="{{ route('admin.advertisements.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                                @csrf

                                <!-- Section 1: Target -->
                                <section class="space-y-4">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-6 h-6 rounded-full bg-brand-blue text-white flex items-center justify-center text-[10px] font-black">01</div>
                                        <h3 class="text-lg font-black text-gray-800">تخصيص الإعلان</h3>
                                    </div>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-blue transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        </div>
                                        <select name="store_id" id="store_id" class="w-full rounded-2xl border-gray-100 bg-gray-50/50 focus:ring-4 focus:ring-brand-blue/5 focus:border-brand-blue focus:bg-white transition-all py-4 pr-10 pl-6 appearance-none font-bold text-gray-700 text-sm">
                                            <option value="">-- متوفر للبيع (بدون تخصيص فوري) --</option>
                                            @foreach($stores as $store)
                                                <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
                                                    {{ $store->name }} - {{ $store->user->name ?? 'تاجر مجهول' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </section>

                                <!-- Section 2: Info -->
                                <section class="space-y-6">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-6 h-6 rounded-full bg-brand-blue text-white flex items-center justify-center text-[10px] font-black">02</div>
                                        <h3 class="text-lg font-black text-gray-800">بيانات المحتوى</h3>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label for="title" class="text-xs font-black text-gray-400 uppercase tracking-widest mr-2 cursor-pointer">عنوان الإعلان</label>
                                            <input type="text" name="title" id="title" x-model="title" required placeholder="مثلاً: خصومات الجمعة البيضاء!" class="w-full rounded-xl border-gray-100 bg-gray-50/50 focus:ring-4 focus:ring-brand-blue/5 focus:border-brand-blue focus:bg-white transition-all py-4 px-5 font-bold text-sm">
                                        </div>
                                        <div class="space-y-2">
                                            <label for="budget" class="text-xs font-black text-gray-400 uppercase tracking-widest mr-2 cursor-pointer">الميزانية</label>
                                            <div class="relative">
                                                <input type="number" name="budget" id="budget" x-model="budget" required class="w-full rounded-xl border-gray-100 bg-gray-50/50 focus:ring-4 focus:ring-brand-blue/5 focus:border-brand-blue focus:bg-white transition-all py-4 px-5 font-black text-xl text-brand-blue-700">
                                                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-xs">ر.ي</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="description" class="text-xs font-black text-gray-400 uppercase tracking-widest mr-2 cursor-pointer">الوصف التفصيلي</label>
                                        <textarea name="description" id="description" rows="3" placeholder="اكتب وصفاً جذاباً يشجع العملاء على النقر..." class="w-full rounded-2xl border-gray-100 bg-gray-50/50 focus:ring-4 focus:ring-brand-blue/5 focus:border-brand-blue focus:bg-white transition-all py-4 px-6 text-sm leading-relaxed"></textarea>
                                    </div>
                                </section>

                                <!-- Section 3: Media -->
                                <section class="space-y-6">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-6 h-6 rounded-full bg-brand-blue text-white flex items-center justify-center text-[10px] font-black">03</div>
                                        <h3 class="text-lg font-black text-gray-800">الظهور المرئي</h3>
                                    </div>

                                    <div class="relative group h-64">
                                        <input type="file" name="image" id="image" required @change="handleImage" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                        <div class="absolute inset-0 border-2 border-dashed border-gray-200 rounded-[32px] group-hover:border-brand-blue group-hover:border-solid group-hover:bg-brand-blue-50/10 transition-all duration-500 overflow-hidden">
                                            <template x-if="!imagePreview">
                                                <div class="flex flex-col items-center justify-center h-full space-y-4">
                                                    <div class="p-4 bg-white rounded-2xl shadow-lg shadow-gray-200/50 text-brand-blue group-hover:scale-105 transition-all">
                                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    </div>
                                                    <div class="text-center px-4">
                                                        <span class="block text-lg font-black text-gray-700">اضغط لرفع صورة العرض</span>
                                                        <span class="text-gray-400 text-xs font-medium">JPG, PNG, GIF (Max 2MB)</span>
                                                    </div>
                                                </div>
                                            </template>
                                            <template x-if="imagePreview">
                                                <div class="relative w-full h-full">
                                                    <img :src="imagePreview" class="w-full h-full object-cover">
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </section>

                                <!-- Section 4: Schedule -->
                                <section class="space-y-6">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-6 h-6 rounded-full bg-brand-blue text-white flex items-center justify-center text-[10px] font-black">04</div>
                                        <h3 class="text-lg font-black text-gray-800">التوقيت والروابط</h3>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest mr-2">تاريخ البدء</label>
                                            <input type="date" name="start_date" required value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-100 bg-gray-50/50 focus:ring-4 focus:ring-brand-blue/5 focus:border-brand-blue py-4 px-5 font-bold text-sm">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest mr-2">تاريخ الانتهاء</label>
                                            <input type="date" name="end_date" required class="w-full rounded-xl border-gray-100 bg-gray-50/50 focus:ring-4 focus:ring-brand-blue/5 focus:border-brand-blue py-4 px-5 font-bold text-sm">
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest mr-2">الرابط الموجه (URL)</label>
                                        <div class="relative group">
                                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-blue">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.826a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                            </div>
                                            <input type="url" name="target_url" placeholder="https://sakhr.com/discount" class="w-full rounded-xl border-gray-100 bg-gray-50/50 focus:ring-4 focus:ring-brand-blue/5 focus:border-brand-blue py-4 pr-10 pl-5 font-bold text-brand-blue text-sm ltr-dir">
                                        </div>
                                    </div>
                                </section>

                                <!-- Footer Actions -->
                                <footer class="pt-8 border-t border-gray-100 flex gap-4">
                                    <button type="submit" class="flex-[2] bg-brand-blue text-white font-black py-4 rounded-2xl shadow-xl shadow-brand-blue/30 hover:bg-brand-blue-600 hover:-translate-y-1 transition-all duration-300 active:scale-95 text-lg flex items-center justify-center gap-2">
                                        إطلاق الإعلان
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                    <a href="{{ route('admin.advertisements.index') }}" class="flex-1 bg-gray-50 text-gray-500 font-bold py-4 rounded-2xl hover:bg-gray-100 transition-all text-center text-lg">إلغاء</a>
                                </footer>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
