<x-admin-layout>
    <x-slot name="title">سجل نشاط العملاء</x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow p-4 flex items-center gap-3">
                    <div class="p-3 bg-sky-100 rounded-xl">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">إجمالي الأحداث</div>
                        <div class="text-2xl font-extrabold text-sky-700">{{ number_format($stats['total']) }}</div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow p-4 flex items-center gap-3">
                    <div class="p-3 bg-violet-100 rounded-xl">
                        <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">أحداث اليوم</div>
                        <div class="text-2xl font-extrabold text-violet-700">{{ $stats['today'] }}</div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow p-4 flex items-center gap-3">
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">إضافات للسلة</div>
                        <div class="text-2xl font-extrabold text-blue-700">{{ $stats['cart_adds'] }}</div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow p-4 flex items-center gap-3">
                    <div class="p-3 bg-green-100 rounded-xl">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">طلبات مكتملة</div>
                        <div class="text-2xl font-extrabold text-green-700">{{ $stats['orders'] }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    {{-- Header --}}
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-brand-blue-800">سجل نشاط العملاء</h2>
                            <p class="text-sm text-gray-500 mt-1">تتبع جميع حركات وأنشطة العملاء داخل التطبيق</p>
                        </div>
                    </div>

                    {{-- Filters --}}
                    <form method="GET" action="{{ route('admin.customer-activities.index') }}"
                        class="flex flex-wrap items-center gap-3 mb-6">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="ابحث بالاسم أو الهاتف..."
                            class="border-gray-300 rounded-lg shadow-sm w-full md:w-72">
                        <select name="action_type" class="border-gray-300 rounded-lg shadow-sm">
                            <option value="">كل الأنشطة</option>
                            @foreach($actionLabels as $key => $info)
                                <option value="{{ $key }}" @selected(request('action_type') == $key)>
                                    {{ $info['label'] }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow hover:bg-brand-blue-700 transition">بحث</button>
                        @if(request()->hasAny(['search','action_type']))
                            <a href="{{ route('admin.customer-activities.index') }}"
                                class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">إعادة تعيين</a>
                        @endif
                    </form>

                    {{-- Timeline / Table --}}
                    <div class="space-y-3 min-h-[400px]">
                        @forelse($activities as $activity)
                            @php
                                $actionInfo = $actionLabels[$activity->action_type] ?? [
                                    'label' => $activity->action_type,
                                    'color' => 'gray',
                                    'icon'  => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                                ];
                                $color = $actionInfo['color'];
                            @endphp
                            <div class="flex items-start gap-4 p-4 bg-gray-50 hover:bg-white border border-gray-100 rounded-xl transition group">
                                {{-- Icon --}}
                                <div class="flex-shrink-0 p-2.5 bg-{{ $color }}-100 rounded-lg group-hover:bg-{{ $color }}-200 transition">
                                    <svg class="w-5 h-5 text-{{ $color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $actionInfo['icon'] }}"/>
                                    </svg>
                                </div>
                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="font-semibold text-gray-800">{{ $activity->user_name ?? 'عميل مجهول' }}</span>
                                        @if($activity->user_phone)
                                            <span class="text-xs text-gray-400">{{ $activity->user_phone }}</span>
                                        @endif
                                        <span class="text-xs px-2 py-0.5 bg-{{ $color }}-100 text-{{ $color }}-700 rounded-full font-semibold">
                                            {{ $actionInfo['label'] }}
                                        </span>
                                        @if($activity->subject_type)
                                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">
                                                {{ $activity->subject_type }} #{{ $activity->subject_id }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($activity->description)
                                        <p class="text-sm text-gray-600 mt-1">{{ $activity->description }}</p>
                                    @endif
                                </div>
                                {{-- Date --}}
                                <div class="flex-shrink-0 text-xs text-gray-400 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                                    <div class="text-gray-300">{{ \Carbon\Carbon::parse($activity->created_at)->format('Y/m/d H:i') }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="py-16 text-center text-gray-400">
                                <svg class="w-16 h-16 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-lg font-semibold">لا توجد أنشطة مسجلة</p>
                                <p class="text-sm mt-1">ستظهر هنا أنشطة العملاء فور تسجيلها في النظام</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">{{ $activities->withQueryString()->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
