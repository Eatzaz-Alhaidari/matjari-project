<x-admin-layout>
    <x-slot name="title">
        إدارة العملاء
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
             @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 rounded-md">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-brand-blue-800 mb-6">قائمة العملاء</h2>
                    
                    <div class="mb-6">
                        <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center">
                            <input type="text" name="search" placeholder="ابحث بالاسم أو البريد الإلكتروني..." class="w-full md:w-1/3 border-gray-300 rounded-lg shadow-sm" value="{{ request('search') }}">
                            <button type="submit" class="mr-3 px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow-md hover:bg-brand-blue-700">بحث</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto bg-white">
                        <table class="min-w-full">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">العميل</th>
                                    <th class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">رقم الهاتف</th>
                                    <th class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">الحالة</th>
                                    <th class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">تاريخ التسجيل</th>
                                    <th class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover" 
                                                         src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" 
                                                         alt="{{ $user->name }}">
                                                </div>
                                                <div class="mr-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->phone ?? 'لا يوجد' }}
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-center">
                                            @if ($user->status === 'active')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">نشط</span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">محظور</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-5 py-4 text-center text-sm font-medium">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="px-2 py-1 text-xs rounded-full font-semibold bg-blue-100 text-blue-800 hover:bg-blue-200">تعديل</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">لا يوجد عملاء حالياً.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>