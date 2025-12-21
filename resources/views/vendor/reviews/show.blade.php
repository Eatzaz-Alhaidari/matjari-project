<x-vendor-layout>
    <x-slot name="title">
        تفاصيل التقييم
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- زر العودة -->
                    <div class="mb-6">
                        <a href="{{ route('vendor.reviews.index') }}"
                            class="inline-flex items-center text-brand-orange hover:text-brand-orange-700">
                            <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            العودة إلى قائمة التقييمات
                        </a>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-6">تفاصيل التقييم</h2>

                    <div class="space-y-6">
                        <!-- معلومات المنتج -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">معلومات المنتج</h3>
                            <div class="flex items-center">
                                @if($review->product->image)
                                    <img src="{{ asset('storage/' . $review->product->image) }}"
                                        alt="{{ $review->product->name }}" class="w-20 h-20 rounded-lg object-cover ml-4">
                                @endif
                                <div>
                                    <p class="text-lg font-bold text-gray-900">{{ $review->product->name }}</p>
                                    <p class="text-sm text-gray-500">السعر:
                                        {{ number_format($review->product->price, 2) }} ر.ي
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- معلومات العميل -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">معلومات العميل</h3>
                            <div>
                                <p class="text-lg font-bold text-gray-900">{{ $review->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $review->user->email }}</p>
                            </div>
                        </div>

                        <!-- التقييم -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">التقييم</h3>
                            <div class="flex items-center">
                                <div class="text-yellow-500 text-3xl font-bold">
                                    {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                </div>
                                <span class="mr-4 text-lg text-gray-700">({{ $review->rating }}/5)</span>
                            </div>
                        </div>

                        <!-- التعليق -->
                        @if($review->comment)
                            <div class="border-b pb-6">
                                <h3 class="text-lg font-semibold text-gray-700 mb-4">التعليق</h3>
                                <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                            </div>
                        @endif

                        <!-- الحالة -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">حالة التقييم</h3>
                            @if ($review->status == 'approved')
                                <span
                                    class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    مقبول
                                </span>
                            @elseif ($review->status == 'pending')
                                <span
                                    class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    قيد المراجعة
                                </span>
                            @else
                                <span
                                    class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    مرفوض
                                </span>
                            @endif
                        </div>

                        <!-- التاريخ -->
                        <div class="pb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">تاريخ التقييم</h3>
                            <p class="text-gray-700">
                                {{ $review->created_at->format('Y-m-d H:i') }}
                            </p>
                        </div>

                        <!-- أزرار الإجراءات -->
                        @if($review->status !== 'approved')
                            <div class="flex items-center space-x-4 space-x-reverse pt-6 border-t">
                                <form action="{{ route('vendor.reviews.updateStatus', $review->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit"
                                        class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700"
                                        onclick="return confirm('هل أنت متأكد من قبول هذا التقييم؟')">
                                        قبول التقييم
                                    </button>
                                </form>
                        @endif

                            @if($review->status !== 'rejected')
                                <form action="{{ route('vendor.reviews.updateStatus', $review->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit"
                                        class="px-6 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700"
                                        onclick="return confirm('هل أنت متأكد من رفض هذا التقييم؟')">
                                        رفض التقييم
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>
