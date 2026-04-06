<x-admin-layout>
    <x-slot name="title">تعديل بيانات العميل: {{ $user->name }}</x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">

                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-brand-blue-800">تعديل بيانات العميل</h2>
                        <a href="{{ route('admin.users.index') }}"
                            class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            العودة للقائمة
                        </a>
                    </div>

                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Section: البيانات الأساسية --}}
                        <div class="mb-6">
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                البيانات الأساسية
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block font-semibold text-sm text-gray-700 mb-1">الاسم الكامل</label>
                                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
                                        required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-brand-blue focus:border-brand-blue">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="email" class="block font-semibold text-sm text-gray-700 mb-1">البريد الإلكتروني
                                        <span class="text-xs text-gray-400">(غير قابل للتعديل)</span></label>
                                    <input id="email" type="email" value="{{ $user->email }}" disabled
                                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm bg-gray-100 text-gray-500">
                                </div>
                            </div>
                        </div>

                        {{-- Section: تسجيل الدخول --}}
                        <div class="mb-6 border-t pt-6">
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                بيانات تسجيل الدخول
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Phone --}}
                                <div>
                                    <label for="phone" class="block font-semibold text-sm text-gray-700 mb-1">
                                        رقم الهاتف
                                        <span class="text-xs text-blue-600 font-normal">(مستخدم لتسجيل الدخول)</span>
                                    </label>
                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        </div>
                                        <input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                                            placeholder="77XXXXXXX"
                                            class="block w-full pr-10 border-gray-300 rounded-lg shadow-sm focus:ring-brand-blue focus:border-brand-blue">
                                    </div>
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>

                                {{-- New Password --}}
                                <div>
                                    <label for="password" class="block font-semibold text-sm text-gray-700 mb-1">
                                        كلمة السر الجديدة
                                        <span class="text-xs text-gray-400">(اتركها فارغة إن لم تريد التغيير)</span>
                                    </label>
                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                            </svg>
                                        </div>
                                        <input id="password" type="password" name="password"
                                            class="block w-full pr-10 border-gray-300 rounded-lg shadow-sm focus:ring-brand-blue focus:border-brand-blue"
                                            placeholder="أدخل كلمة سر جديدة...">
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- Section: البصمة والأمان --}}
                        <div class="mb-6 border-t pt-6">
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/>
                                </svg>
                                الأمان والبصمة
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-xl border border-blue-100">
                                        <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-blue-800">تسجيل الدخول بالبصمة</div>
                                            <div class="text-sm text-blue-600 mt-0.5">
                                                الحالة الحالية:
                                                @if($user->has_biometric)
                                                    <span class="font-bold text-green-700">مفعّل ✓</span>
                                                @else
                                                    <span class="font-bold text-gray-500">غير مفعّل</span>
                                                @endif
                                            </div>
                                            <div class="text-xs text-blue-500 mt-1">يُدار هذا الإعداد من التطبيق مباشرةً. يمكن للمسؤول إلغاء تفعيله فقط.</div>
                                        </div>
                                        @if($user->has_biometric)
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" name="reset_biometric" value="1"
                                                    class="rounded border-gray-300 text-red-600">
                                                <span class="text-sm font-semibold text-red-600">إلغاء البصمة</span>
                                            </label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section: الحالة --}}
                        <div class="mb-6 border-t pt-6">
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">حالة الحساب</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="status" class="block font-semibold text-sm text-gray-700 mb-1">الحالة</label>
                                    <select name="status" id="status"
                                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm"
                                        onchange="document.getElementById('banField').classList.toggle('hidden', this.value !== 'banned')">
                                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                        <option value="banned" {{ old('status', $user->status) == 'banned' ? 'selected' : '' }}>محظور</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </div>
                                <div id="banField" class="{{ old('status', $user->status) !== 'banned' ? 'hidden' : '' }}">
                                    <label for="ban_reason" class="block font-semibold text-sm text-gray-700 mb-1">سبب الحظر</label>
                                    <input id="ban_reason" type="text" name="ban_reason"
                                        value="{{ old('ban_reason', $user->ban_reason) }}"
                                        placeholder="أدخل سبب الحظر..."
                                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end mt-8 border-t pt-6 gap-3">
                            <a href="{{ route('admin.users.index') }}"
                                class="px-5 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-200 transition">إلغاء</a>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-brand-blue text-white font-bold rounded-xl shadow-lg hover:bg-brand-blue-600 hover:-translate-y-0.5 transition-all duration-300 group">
                                <svg class="w-5 h-5 ml-2 group-hover:scale-110 transition-transform duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>