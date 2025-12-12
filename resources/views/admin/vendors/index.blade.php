<x-admin-layout>
    <x-slot name="title">
        إدارة البائعين
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 rounded-md">{{ session('success') }}</div>
            @endif
             @if (session('error'))
                <div class="mb-4 px-4 py-2 bg-red-100 border border-red-200 text-red-700 rounded-md">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-brand-blue-800">قائمة البائعين</h2>
                        <a href="{{ route('admin.vendors.create') }}" class="px-4 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-opacity-90">إضافة بائع جديد</a>
                    </div>
                    
                    <!-- ##### بداية نموذج البحث ##### -->
                    <div class="mb-6">
                        <form action="{{ route('admin.vendors.index') }}" method="GET" class="flex items-center">
                            <input type="text" name="search" placeholder="ابحث بالاسم أو البريد الإلكتروني..." class="w-full md:w-1/3 border-gray-300 rounded-lg shadow-sm" value="{{ request('search') }}">
                            <button type="submit" class="mr-3 px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow-md hover:bg-brand-blue-700">بحث</button>
                        </form>
                    </div>
                     <!-- ##### نهاية نموذج البحث ##### -->
                    <div class="overflow-x-auto bg-white">
                        <table class="min-w-full">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">البائع</th>
                                    <th class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">المتجر</th>
                                    <th class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">السجل التجاري</th>
                                    <th class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">الحالة</th>
                                    <th class="px-5 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">تاريخ التسجيل</th>
                                    <th class="px-5 py-3 text-center text-xs font-bold text-brand-blue-800 uppercase tracking-wider">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($vendors as $vendor)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover" 
                                                         src="{{ $vendor->profile_photo_path ? asset('storage/' . $vendor->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode($vendor->name) }}" 
                                                         alt="{{ $vendor->name }}">
                                                </div>
                                                <div class="mr-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $vendor->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $vendor->email }}</div>
                                                    <div class="text-xs text-gray-500">{{ $vendor->phone ?? 'لا يوجد هاتف' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $vendor->store?->name ?? 'لا يوجد' }}</div>
                                            <div class="text-xs text-gray-500">{{ $vendor->store?->address ?? 'لا يوجد عنوان' }}</div>
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $vendor->store?->commercial_registration ?? 'لا يوجد' }}
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-center">
                                            @if ($vendor->store?->is_active)
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">نشط</span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">غير نشط</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $vendor->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-5 py-4 whitespace-nowrap text-left text-sm font-medium">
                                            <div class="flex items-center space-x-2 space-x-reverse">
                                                @if($vendor->store)
                                                    <form action="{{ route('admin.vendors.toggleStatus', $vendor->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        <button type="submit" class="px-2 py-1 text-xs rounded-full font-semibold {{ $vendor->store->is_active ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }}" title="{{ $vendor->store->is_active ? 'تعطيل المتجر' : 'تفعيل المتجر' }}">
                                                            {{ $vendor->store->is_active ? 'تعطيل' : 'تفعيل' }}
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('admin.vendors.edit', $vendor->id) }}" class="px-2 py-1 text-xs rounded-full font-semibold bg-blue-100 text-blue-800 hover:bg-blue-200">تعديل</a>
                                                
                                                <!-- ##### هذا هو الجزء الذي تم تعديله ##### -->
                                                <form action="{{ route('admin.vendors.destroy', $vendor->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا البائع؟ لا يمكن التراجع عن هذا الإجراء.');" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2 py-1 text-xs rounded-full font-semibold bg-red-100 text-red-800 hover:bg-red-200">حذف</button>
                                                </form>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">لا يوجد بائعين حالياً.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-8">
                     {{ $vendors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>