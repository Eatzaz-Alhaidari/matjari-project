<x-admin-layout>
    <x-slot name="title">تعديل الإعلان: {{ $advertisement->title }}</x-slot>

    <div class="py-10 min-h-screen bg-slate-50/50" x-data="{ 
        status: {{ $advertisement->status }},
        imagePreview: '{{ $advertisement->image ? Storage::url($advertisement->image) : null }}',
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
            <div class="mb-6 flex items-center justify-between">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.advertisements.index') }}" class="inline-flex items-center text-xs font-medium text-gray-500 hover:text-brand-blue transition-colors">
                                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                                الإعلانات
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center text-xs font-bold text-brand-blue">
                                <svg class="w-4 h-4 text-gray-400 rotate-180" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="mr-1">تعديل الإعلان</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="relative">
                <div class="bg-white/70 backdrop-blur-xl overflow-hidden shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] sm:rounded-[32px] border border-white/80 relative z-10">
                    <div class="p-6 md:p-10">
                        
                        <div class="max-w-2xl mx-auto">
                            <header class="text-center mb-10">
                                <div class="inline-flex p-3 bg-brand-blue-50 rounded-2xl mb-4 text-brand-blue ring-4 ring-brand-blue/5">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </div>
                                <h1 class="text-xl font-black text-brand-blue-900 tracking-tight mb-2">تحديث الإعلان</h1>
                                <p class="text-gray-400 text-xs font-medium max-w-sm mx-auto leading-relaxed">تعديل بيانات العرض الجاري ومراجعة حالة النشاط.</p>
                            </header>

                            <form action="{{ route('admin.advertisements.update', $advertisement->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                                @csrf
                                @method('PUT')

                                <!-- Section: Status Control -->
                                <section class="p-6 bg-gray-50/50 rounded-2xl border border-gray-100 space-y-6">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-base font-black text-gray-800">الحالة والتحكم</h3>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-wider
                                            @if($advertisement->status == 1) bg-emerald-50 text-emerald-600 @elseif($advertisement->status == 2) bg-red-50 text-red-600 @else bg-amber-50 text-amber-600 @endif">
                                            الحالي: {{ $advertisement->status_text }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1 block">تغيير الحالة</label>
                                            <select name="status" x-model="status" class="w-full rounded-xl border-gray-100 bg-white focus:ring-4 focus:ring-brand-blue/5 focus:border-brand-blue py-3.5 px-5 font-bold text-gray-700 appearance-none shadow-sm text-sm">
                                                <option value="0">في الانتظار (Pending)</option>
                                                <option value="1">نشط (Active)</option>
                                                <option value="2">مرفوض (Rejected)</option>
                                                <option value="3">معطل مؤقتاً (Paused)</option>
                                            </select>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1 block">المتجر المخصص</label>
                                            <select name="store_id" class="w-full rounded-xl border-gray-100 bg-white focus:ring-4 focus:ring-brand-blue/5 focus:border-brand-blue py-3.5 px-5 font-bold text-gray-700 appearance-none shadow-sm text-sm">
                                                <option value="">-- عام (بدون متجر) --</option>
                                                @foreach($stores as $store)
                                                    <option value="{{ $store->id }}" {{ $advertisement->store_id == $store->id ? 'selected' : '' }}>
                                                        {{ $store->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Rejection Reason (Conditional) -->
                                    <div x-show="status == 2" x-transition.duration.500ms class="space-y-2 pt-4 border-t border-gray-200/50">
                                        <label for="rejection_reason" class="block text-xs font-black text-red-600 uppercase tracking-widest px-2">رسالة الرفض للتاجر:</label>
                                        <textarea name="rejection_reason" placeholder="رسالة الرفض..." class="w-full rounded-xl border-red-50 bg-red-50/20 focus:ring-4 focus:ring-red-500/5 focus:border-red-500 py-3 px-5 text-xs font-medium">{{ $advertisement->rejection_reason }}</textarea>
                                    </div>
                                </section>

                                <!-- Section 2: Info -->
                                <section class="space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest mr-2">عنوان الإعلان</label>
                                            <input type="text" name="title" value="{{ $advertisement->title }}" required class="w-full rounded-xl border-gray-100 bg-gray-50/50 focus:ring-4 focus:ring-brand-blue/5 focus:border-brand-blue py-4 px-5 font-bold text-sm">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest mr-2">الميزانية</label>
                                            <div class="relative">
                                                <input type="number" name="budget" value="{{ $advertisement->budget }}" step="0.01" required class="w-full rounded-xl border-gray-100 bg-gray-50/50 focus:ring-4 focus:ring-brand-blue/5 focus:border-brand-blue py-4 px-5 font-black text-lg text-brand-blue-700">
                                                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-xs">ر.ي</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest mr-2">الوصف</label>
                                        <textarea name="description" rows="3" class="w-full rounded-2xl border-gray-100 bg-gray-50/50 focus:ring-4 focus:ring-brand-blue/5 focus:border-brand-blue py-4 px-6 leading-relaxed text-sm">{{ $advertisement->description }}</textarea>
                                    </div>
                                </section>

                                <!-- Section 3: Media -->
                                <section class="space-y-6">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-black text-gray-800">الصور والوسائط</h3>
                                    </div>

                                    <div class="relative group h-64">
                                        <input type="file" name="image" @change="handleImage" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                        <div class="absolute inset-0 border-2 border-dashed border-gray-200 rounded-2xl group-hover:border-brand-blue group-hover:border-solid transition-all duration-500 overflow-hidden shadow-inner bg-gray-50">
                                            <template x-if="imagePreview">
                                                <div class="relative w-full h-full opacity-90 group-hover:opacity-100 transition-opacity">
                                                    <img :src="imagePreview" class="w-full h-full object-cover">
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </section>

                                <!-- Section 4: Schedule -->
                                <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest mr-2">تاريخ البدء</label>
                                        <input type="date" name="start_date" value="{{ $advertisement->start_date->format('Y-m-d') }}" required class="w-full rounded-xl border-gray-100 bg-gray-50/50 focus:ring-4 focus:ring-brand-blue/5 focus:border-brand-blue py-4 px-5 font-bold text-sm">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest mr-2">تاريخ الانتهاء</label>
                                        <input type="date" name="end_date" value="{{ $advertisement->end_date->format('Y-m-d') }}" required class="w-full rounded-xl border-gray-100 bg-gray-50/50 focus:ring-4 focus:ring-brand-blue/5 focus:border-brand-blue py-4 px-5 font-bold text-sm">
                                    </div>
                                </section>

                                <div class="space-y-2">
                                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest mr-2">الرابط الموجه</label>
                                    <input type="url" name="target_url" value="{{ $advertisement->target_url }}" placeholder="https://..." class="w-full rounded-xl border-gray-100 bg-gray-50/50 focus:ring-4 focus:ring-brand-blue/5 focus:border-brand-blue py-4 px-5 font-bold text-brand-blue text-sm ltr-dir">
                                </div>

                                <!-- Footer Actions -->
                                <footer class="pt-8 border-t border-gray-100 flex gap-4">
                                    <button type="submit" class="flex-[2] bg-brand-blue text-white font-black py-4 rounded-2xl shadow-xl shadow-brand-blue/30 hover:bg-brand-blue-600 hover:-translate-y-1 transition-all duration-300 active:scale-95 text-lg flex items-center justify-center gap-2">
                                        حفظ التعديلات
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
