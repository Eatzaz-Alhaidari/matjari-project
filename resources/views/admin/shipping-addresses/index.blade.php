<x-admin-layout>
    <x-slot name="title">عناوين الشحن</x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-brand-blue-800">عناوين الشحن</h2>
                            <p class="text-sm text-gray-500 mt-1">عناوين الشحن المسجلة من قبل العملاء</p>
                        </div>
                    </div>

                    {{-- Search & Filters --}}
                    <form method="GET" action="{{ route('admin.shipping-addresses.index') }}"
                        class="flex flex-wrap items-center gap-3 mb-6">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="ابحث بالاسم أو رقم الهاتف..."
                            class="border-gray-300 rounded-lg shadow-sm w-full md:w-72">
                        <select name="city" class="border-gray-300 rounded-lg shadow-sm">
                            <option value="">كل المدن</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" @selected(request('city') == $city)>{{ $city }}</option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="px-4 py-2 bg-brand-blue text-white font-semibold rounded-lg shadow hover:bg-brand-blue-700 transition">بحث</button>
                        @if(request()->hasAny(['search','city']))
                            <a href="{{ route('admin.shipping-addresses.index') }}"
                                class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">إعادة تعيين</a>
                        @endif
                    </form>

                    {{-- Table --}}
                    <div class="overflow-x-auto bg-white min-h-[400px]">
                        <table class="min-w-full text-right">
                            <thead class="bg-brand-blue-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase">#</th>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase">العميل</th>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase">التصنيف</th>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase">المدينة</th>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase">العنوان الكامل</th>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">الإحداثيات (خريطة)</th>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">افتراضي</th>
                                    <th class="px-5 py-3 text-xs font-bold text-brand-blue-800 uppercase text-center">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($addresses as $address)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-5 py-4 text-xs text-gray-400">{{ $address->id }}</td>
                                        <td class="px-5 py-4">
                                            <div class="font-semibold text-gray-800">{{ $address->user_name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $address->user_phone ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            @if($address->label)
                                                <span class="text-xs bg-blue-50 text-blue-700 px-2 py-0.5 rounded border border-blue-100">
                                                    {{ $address->label }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-700">{{ $address->city }}</td>
                                        <td class="px-5 py-4 text-sm text-gray-600 max-w-xs">
                                            <div class="truncate">{{ $address->address }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            @if($address->lat && $address->lng)
                                                <a href="https://www.google.com/maps?q={{ $address->lat }},{{ $address->lng }}"
                                                    target="_blank"
                                                    class="inline-flex items-center gap-1 text-xs text-teal-600 hover:text-teal-800 font-semibold bg-teal-50 px-2 py-1 rounded border border-teal-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                    عرض على الخريطة
                                                </a>
                                            @else
                                                <span class="text-xs text-gray-400">كتابة يدوية</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            @if($address->is_default)
                                                <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-semibold">افتراضي</span>
                                            @else
                                                <span class="text-gray-300 text-xs">-</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <form method="POST" action="{{ route('admin.shipping-addresses.destroy', $address->id) }}"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذا العنوان؟')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="text-xs text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1 rounded border border-red-100 transition">
                                                    حذف
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-5 py-16 text-center text-gray-400">
                                            <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                            لا توجد عناوين شحن مسجلة
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $addresses->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
