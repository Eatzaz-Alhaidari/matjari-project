<x-vendor-layout>
    <x-slot name="title">
        تفاصيل الخصم
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <a href="{{ route('vendor.discounts.index') }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                            <h2 class="text-2xl font-bold text-black">{{ $discount->title }}</h2>
                        </div>
                        <div class="flex space-x-2 space-x-reverse">
                            @if($discount->status !== 'expired')
                                <form action="{{ route('vendor.discounts.toggleStatus', $discount->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-semibold rounded-lg shadow-md
                                                    {{ $discount->status === 'active' ? 'bg-yellow-500 text-white hover:bg-yellow-600' : 'bg-green-500 text-white hover:bg-green-600' }}">
                                        {{ $discount->status === 'active' ? 'تعطيل الخصم' : 'تفعيل الخصم' }}
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('vendor.discounts.edit', $discount->id) }}"
                                class="px-4 py-2 bg-blue-500 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-blue-600">
                                تعديل
                            </a>
                            <form action="{{ route('vendor.discounts.destroy', $discount->id) }}" method="POST"
                                onsubmit="return confirm('هل أنت متأكد من حذف هذا الخصم؟');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-500 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-red-600">
                                    حذف
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Discount Status -->
                    <div class="mb-6">
                        <span class="px-3 py-1 text-sm rounded-full font-semibold
                            @if($discount->status === 'active')
                                bg-green-100 text-green-800
                            @elseif($discount->status === 'inactive')
                                bg-red-100 text-red-800
                            @else
                                bg-gray-100 text-gray-800
                            @endif">
                            {{ $discount->status_text }}
                        </span>
                        @if($discount->isExpired() && $discount->status === 'active')
                            <span class="px-3 py-1 text-sm rounded-full font-semibold bg-red-100 text-red-800 ml-2">
                                منتهي الصلاحية
                            </span>
                        @endif
                    </div>

                    <!-- Discount Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Basic Information -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">معلومات أساسية</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">كود الخصم</label>
                                    <div class="mt-1">
                                        <span class="px-2 py-1 bg-gray-200 text-gray-800 rounded text-sm font-mono">
                                            {{ $discount->code }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">نوع الخصم</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $discount->type_text }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">قيمة الخصم</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $discount->value }}
                                        @if($discount->type === 'percentage')% @else ر.ي @endif
                                    </p>
                                </div>
                                @if($discount->description)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">الوصف</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $discount->description }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Conditions -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">شروط الخصم</h3>
                            <div class="space-y-3">
                                @if($discount->min_order_amount)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">الحد الأدنى للطلب</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $discount->min_order_amount }} ر.ي</p>
                                    </div>
                                @endif
                                @if($discount->max_discount_amount)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">الحد الأقصى للخصم</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $discount->max_discount_amount }} ر.ي</p>
                                    </div>
                                @endif
                                @if($discount->usage_limit)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">عدد مرات الاستخدام
                                            المسموح</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $discount->usage_limit }} مرة</p>
                                    </div>
                                @else
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">عدد مرات الاستخدام</label>
                                        <p class="mt-1 text-sm text-gray-900">غير محدود</p>
                                    </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">عدد مرات الاستخدام
                                        الحالي</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $discount->used_count }} مرة</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Validity Period -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">فترة الصلاحية</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">تاريخ البداية</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $discount->start_date->format('Y-m-d H:i') }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">تاريخ النهاية</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $discount->end_date->format('Y-m-d H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">الحالة</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    @if($discount->days_remaining < 0)
                                        <span class="text-red-600">انتهت الصلاحية</span>
                                    @elseif($discount->days_remaining === 0)
                                        <span class="text-orange-600">تنتهي اليوم</span>
                                    @elseif($discount->days_remaining <= 7)
                                        <span class="text-orange-600">{{ $discount->days_remaining }} يوم متبقي</span>
                                    @else
                                        <span class="text-green-600">{{ $discount->days_remaining }} يوم متبقي</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Applicable Products -->
                    @if($discount->applicable_products->count() > 0)
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">المنتجات المطبق عليها الخصم</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($discount->applicable_products as $product)
                                    <div class="bg-white p-3 rounded border">
                                        <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $product->price }} ر.ي</div>
                                        @if($product->category)
                                            <div class="text-xs text-gray-500">{{ $product->category->name }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">المنتجات المطبق عليها الخصم</h3>
                            <p class="text-sm text-gray-600">يطبق هذا الخصم على جميع المنتجات في المتجر</p>
                        </div>
                    @endif

                    <!-- Usage Statistics -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">إحصائيات الاستخدام</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $discount->used_count }}</div>
                                <div class="text-sm text-gray-600">مرات الاستخدام</div>
                            </div>
                            @if($discount->usage_limit)
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600">
                                        {{ $discount->usage_limit - $discount->used_count }}
                                    </div>
                                    <div class="text-sm text-gray-600">المرات المتبقية</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-purple-600">
                                        {{ $discount->usage_limit > 0 ? round(($discount->used_count / $discount->usage_limit) * 100, 1) : 0 }}%
                                    </div>
                                    <div class="text-sm text-gray-600">نسبة الاستخدام</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>