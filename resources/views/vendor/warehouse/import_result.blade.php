<x-vendor-layout>
    <x-slot name="title">
        نتائج الاستيراد
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl">
                <div class="p-10">
                    <div class="text-center mb-10">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 bg-green-100 text-green-600 rounded-full mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-extrabold text-gray-900">اكتملت العملية!</h2>
                        <p class="text-gray-500 mt-1">تقرير ملخص لعملية الاستيراد التي تمت</p>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                        <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 text-center">
                            <span
                                class="block text-3xl font-black text-gray-900 mb-1">{{ $results['row_count'] }}</span>
                            <span class="text-sm font-bold text-gray-500">إجمالي الصفوف</span>
                        </div>
                        <div class="p-6 bg-green-50 rounded-2xl border border-green-100 text-center">
                            <span class="block text-3xl font-black text-green-600 mb-1">{{ $results['success'] }}</span>
                            <span class="text-sm font-bold text-green-700">ناجحة</span>
                        </div>
                        <div class="p-6 bg-red-50 rounded-2xl border border-red-100 text-center">
                            <span
                                class="block text-3xl font-black text-red-600 mb-1">{{ count($results['errors']) }}</span>
                            <span class="text-sm font-bold text-red-700">فاشلة / أخطاء</span>
                        </div>
                    </div>

                    @if(count($results['errors']) > 0)
                        <div class="mb-10">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center text-red-600">
                                <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                                تفاصيل الأخطاء
                            </h4>
                            <div class="bg-red-50 rounded-2xl border border-red-100 overflow-hidden">
                                <ul class="divide-y divide-red-100">
                                    @foreach($results['errors'] as $error)
                                        <li class="px-6 py-4 text-sm text-red-800 flex items-start">
                                            <span class="ml-3 mt-1 w-1.5 h-1.5 bg-red-400 rounded-full flex-shrink-0"></span>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-center pt-6">
                        <a href="{{ route('vendor.warehouse.index') }}"
                            class="px-12 py-4 bg-gray-900 text-white font-bold rounded-2xl hover:bg-black transition-all shadow-xl">
                            العودة لإدارة المخزن
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>