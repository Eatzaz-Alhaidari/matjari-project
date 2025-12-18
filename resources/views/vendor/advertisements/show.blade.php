<x-vendor-layout>
    <x-slot name="title">
        عرض الإعلان: {{ $advertisement->title }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-brand-orange-800">تفاصيل الإعلان</h2>
                        <a href="{{ route('vendor.advertisements.index') }}"
                            class="px-4 py-2 bg-brand-orange text-white font-semibold rounded-lg shadow-md hover:bg-brand-orange-700">
                            العودة للقائمة
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- معلومات الإعلان الأساسية -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">معلومات الإعلان</h3>
                                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">عنوان الإعلان:</span>
                                        <span class="text-gray-900">{{ $advertisement->title }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">الحالة:</span>
                                        <span class="px-2 py-1 text-xs rounded-full font-semibold
                                            @if($advertisement->status === 'active')
                                                bg-green-100 text-green-800
                                            @elseif($advertisement->status === 'inactive')
                                                bg-red-100 text-red-800
                                            @else
                                                bg-yellow-100 text-yellow-800
                                            @endif">
                                            {{ $advertisement->status_text }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">تاريخ البداية:</span>
                                        <span
                                            class="text-gray-900">{{ $advertisement->start_date->format('Y-m-d') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">تاريخ النهاية:</span>
                                        <span class="text-gray-900">{{ $advertisement->end_date->format('Y-m-d') }}
                                            @if($advertisement->days_remaining < 0)
                                                <span class="text-red-500 text-xs">(انتهى)</span>
                                            @elseif($advertisement->days_remaining <= 7)
                                                <span class="text-orange-500 text-xs">({{ $advertisement->days_remaining }}
                                                    يوم متبقي)</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">الميزانية:</span>
                                        <span
                                            class="text-green-600 font-semibold">{{ number_format($advertisement->budget, 2) }}
                                            ر.ي</span>
                                    </div>
                                    @if($advertisement->target_url)
                                        <div class="flex justify-between">
                                            <span class="font-medium text-gray-700">رابط الهدف:</span>
                                            <a href="{{ $advertisement->target_url }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-800 underline">{{ $advertisement->target_url }}</a>
                                        </div>
                                    @endif
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">تاريخ الإضافة:</span>
                                        <span
                                            class="text-gray-900">{{ $advertisement->created_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">آخر تحديث:</span>
                                        <span
                                            class="text-gray-900">{{ $advertisement->updated_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- إحصائيات الأداء -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">إحصائيات الأداء</h3>
                                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">عدد المشاهدات:</span>
                                        <span
                                            class="text-blue-600 font-semibold">{{ number_format($advertisement->views) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">عدد النقرات:</span>
                                        <span
                                            class="text-green-600 font-semibold">{{ number_format($advertisement->clicks) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">معدل النقر:</span>
                                        <span class="text-purple-600 font-semibold">
                                            @if($advertisement->click_through_rate > 0)
                                                {{ number_format($advertisement->click_through_rate, 2) }}%
                                            @else
                                                0%
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">الحالة النشطة:</span>
                                        <span
                                            class="px-2 py-1 text-xs rounded-full font-semibold
                                            {{ $advertisement->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $advertisement->isActive() ? 'نشط' : 'غير نشط' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- الوصف -->
                            @if($advertisement->description)
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">وصف الإعلان</h3>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-gray-700 leading-relaxed">{{ $advertisement->description }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- الصورة -->
                        <div class="space-y-6">
                            <!-- صورة الإعلان -->
                            @if($advertisement->image)
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">صورة الإعلان</h3>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <img src="{{ asset('storage/' . $advertisement->image) }}"
                                            alt="{{ $advertisement->title }}"
                                            class="w-full h-64 object-cover rounded-lg shadow-md">
                                    </div>
                                </div>
                            @else
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">صورة الإعلان</h3>
                                    <div class="bg-gray-50 rounded-lg p-4 flex items-center justify-center h-64">
                                        <div class="text-center">
                                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-gray-500">لا توجد صورة</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- أزرار الإجراءات -->
                    <div class="mt-8 flex justify-center space-x-4 space-x-reverse">
                        <a href="{{ route('vendor.advertisements.edit', $advertisement->id) }}"
                            class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-colors">
                            تعديل الإعلان
                        </a>
                        @if($advertisement->status !== 'pending')
                            <form action="{{ route('vendor.advertisements.toggleStatus', $advertisement->id) }}"
                                method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="px-6 py-2 font-semibold rounded-lg shadow-md transition-colors
                                            {{ $advertisement->status === 'active' ? 'bg-yellow-500 text-white hover:bg-yellow-600' : 'bg-green-500 text-white hover:bg-green-600' }}">
                                    {{ $advertisement->status === 'active' ? 'تعطيل الإعلان' : 'تفعيل الإعلان' }}
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('vendor.advertisements.destroy', $advertisement->id) }}" method="POST"
                            onsubmit="return confirm('هل أنت متأكد من حذف هذا الإعلان؟');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-6 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition-colors">
                                حذف الإعلان
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>