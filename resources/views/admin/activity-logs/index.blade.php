<x-admin-layout>
    <x-slot name="title">
        سجل الأنشطة
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-brand-blue-800 mb-4 md:mb-0">سجل عمليات النظام</h2>
                        
                        <!-- Filter Form -->
                        <form action="{{ route('admin.activity-logs.index') }}" method="GET" class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                            <select name="action_type" class="border-gray-300 rounded-lg shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 text-sm">
                                <option value="">كل العمليات</option>
                                <option value="login" {{ request('action_type') == 'login' ? 'selected' : '' }}>تسجيل دخول</option>
                                <option value="logout" {{ request('action_type') == 'logout' ? 'selected' : '' }}>تسجيل خروج</option>
                                <option value="create" {{ request('action_type') == 'create' ? 'selected' : '' }}>إضافة</option>
                                <option value="update" {{ request('action_type') == 'update' ? 'selected' : '' }}>تحديث</option>
                                <option value="delete" {{ request('action_type') == 'delete' ? 'selected' : '' }}>حذف</option>
                                <option value="payment" {{ request('action_type') == 'payment' ? 'selected' : '' }}>دفع</option>
                            </select>

                            <select name="user_type" class="border-gray-300 rounded-lg shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 text-sm">
                                <option value="">كل الأدوار</option>
                                <option value="admin" {{ request('user_type') == 'admin' ? 'selected' : '' }}>مسؤول</option>
                                <option value="vendor" {{ request('user_type') == 'vendor' ? 'selected' : '' }}>بائع</option>
                                <option value="customer" {{ request('user_type') == 'customer' ? 'selected' : '' }}>عميل</option>
                                <option value="guest" {{ request('user_type') == 'guest' ? 'selected' : '' }}>زائر</option>
                            </select>

                            <input type="text" name="search" placeholder="بحث بالوصف أو IP..." value="{{ request('search') }}" 
                                class="border-gray-300 rounded-lg shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50 text-sm">

                            <button type="submit" class="px-4 py-2 bg-brand-blue text-white font-bold rounded-lg hover:bg-brand-blue-700 transition">
                                تصفية
                            </button>
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-brand-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">المستخدم</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">العملية</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">الوصف</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">التفاصيل التقنية</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-brand-blue-800 uppercase tracking-wider">التوقيت</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($logs as $log)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($log->user)
                                                <div class="text-sm font-bold text-gray-900">{{ $log->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $log->user->email }}</div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                    {{ $log->user_type == 'admin' ? 'bg-purple-100 text-purple-800' : 
                                                       ($log->user_type == 'vendor' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800') }}">
                                                    {{ $log->user_type }}
                                                </span>
                                            @else
                                                <span class="text-sm text-gray-500 italic">زائر / نظام</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $actionColors = [
                                                    'create' => 'bg-green-100 text-green-800',
                                                    'update' => 'bg-blue-100 text-blue-800',
                                                    'delete' => 'bg-red-100 text-red-800',
                                                    'login' => 'bg-indigo-100 text-indigo-800',
                                                    'logout' => 'bg-gray-100 text-gray-800',
                                                    'payment' => 'bg-yellow-100 text-yellow-800',
                                                    'login_failed' => 'bg-red-50 text-red-600',
                                                ];
                                                $actionTexts = [
                                                    'create' => 'إضافة',
                                                    'update' => 'تعديل',
                                                    'delete' => 'حذف',
                                                    'login' => 'تسجيل دخول',
                                                    'logout' => 'خروج',
                                                    'payment' => 'دفع',
                                                    'login_failed' => 'فشل دخول',
                                                ];
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full {{ $actionColors[$log->action_type] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $actionTexts[$log->action_type] ?? $log->action_type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ $log->description }}</div>
                                            @if($log->subject_type)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ ucfirst($log->subject_type) }} #{{ $log->subject_id }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 dir-ltr">
                                            <div class="font-mono">{{ $log->ip_address }}</div>
                                            <div class="truncate max-w-xs" title="{{ $log->user_agent }}">
                                                {{ Str::limit($log->user_agent, 30) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->created_at->format('Y-m-d H:i:s') }}
                                            <div class="text-xs">{{ $log->created_at->diffForHumans() }}</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                            لا توجد سجلات أنشطة مطابقة للبحث.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
