<x-admin-layout>
    <x-slot name="title">
        تعديل بيانات العميل: {{ $user->name }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">
                    
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">اسم العميل</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                             <div>
                                <label for="email" class="block font-medium text-sm text-gray-700">البريد الإلكتروني (غير قابل للتعديل)</label>
                                <input id="email" type="email" value="{{ $user->email }}" disabled class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100">
                            </div>

                            <div>
                                <label for="phone" class="block font-medium text-sm text-gray-700">رقم الهاتف</label>
                                <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                            
                            <div>
                                <label for="status" class="block font-medium text-sm text-gray-700">حالة الحساب</label>
                                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="banned" {{ old('status', $user->status) == 'banned' ? 'selected' : '' }}>محظور</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                            
                        </div>

                        <div class="flex items-center justify-end mt-8 border-t pt-6">
                            <a href="{{ route('admin.users.index') }}" class="px-5 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-200">إلغاء</a>
                            <button type="submit" class="mr-4 px-6 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-opacity-90">حفظ التغييرات</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>