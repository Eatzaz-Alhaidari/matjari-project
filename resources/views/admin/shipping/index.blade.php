<x-admin-layout>
    <x-slot name="title">
        إدارة الشحن (تجريبي)
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">تتبع الشحنات</h2>
            <p class="text-sm text-gray-600">إدارة شحنات مدينة صنعاء - شركة توصيل</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border-r-4 border-green-500 text-green-700">
        {{ session('success') }}
    </div>
    @endif

    <!-- Lists -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden" x-data="{ openModal: null }">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-gray-200">
                    <th class="px-6 py-4 font-bold text-gray-700">رقم الشحنة</th>
                    <th class="px-6 py-4 font-bold text-gray-700">رقم الطلب</th>
                    <th class="px-6 py-4 font-bold text-gray-700">العميل</th>
                    <th class="px-6 py-4 font-bold text-gray-700 text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($shippings as $shipping)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <div class="font-medium text-brand-blue">{{ $shipping['id'] }}</div>
                        <div class="text-xs text-gray-400 font-mono">{{ $shipping['tracking_number'] }}</div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $shipping['order_id'] }}</td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800">{{ $shipping['customer'] }}</div>
                        <div class="text-xs text-brand-blue">{{ $shipping['carrier'] }} - {{ $shipping['city'] }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-2 space-x-reverse">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                                {{ $shipping['status'] }}
                            </span>
                            <button @click="openModal = '{{ $shipping['id'] }}'" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition" title="تحديث الحالة">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                        </div>

                        <!-- Update Status Modal -->
                        <div x-show="openModal === '{{ $shipping['id'] }}'" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openModal = null"></div>
                                <div class="bg-white rounded-xl shadow-xl transform transition-all w-full max-w-md p-6 z-50 text-right">
                                    <h3 class="text-lg font-bold text-gray-900 mb-4">تحديث حالة الشحنة {{ $shipping['id'] }}</h3>
                                    
                                    <form action="{{ route('admin.shipping.updateStatus', str_replace('SHP-', '', $shipping['id'])) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">الحالة الجديدة</label>
                                            <select name="status" class="w-full border-gray-300 rounded-lg focus:ring-brand-blue focus:border-brand-blue">
                                                <option value="pending">في الانتظار</option>
                                                <option value="processing">قيد المعالجة</option>
                                                <option value="shipped">تم الشحن (قيد التوصيل)</option>
                                                <option value="delivered">تم التسليم</option>
                                                <option value="cancelled">ملغي</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">رقم التتبع</label>
                                            <input type="text" name="tracking_number" value="{{ $shipping['tracking_number'] }}" class="w-full border-gray-300 rounded-lg font-mono focus:ring-brand-blue focus:border-brand-blue">
                                        </div>

                                        <div class="flex justify-end space-x-2 space-x-reverse mt-6">
                                            <button type="button" @click="openModal = null" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg">إلغاء</button>
                                            <button type="submit" class="px-4 py-2 bg-brand-blue text-white rounded-lg hover:bg-blue-700 transition">حفظ التعديلات</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                        لا توجد شحنات في مدينة صنعاء حالياً.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Mockup -->
    <div class="mt-6 flex justify-between items-center text-sm text-gray-600">
        <div>عرض 1 إلى 4 من أصل 4 شحنات</div>
        <div class="flex space-x-1 space-x-reverse">
            <button class="px-3 py-1 border rounded bg-white text-gray-400 cursor-not-allowed">السابق</button>
            <button class="px-3 py-1 border rounded bg-brand-blue text-white">1</button>
            <button class="px-3 py-1 border rounded bg-white hover:bg-gray-50">التالي</button>
        </div>
    </div>
</x-admin-layout>