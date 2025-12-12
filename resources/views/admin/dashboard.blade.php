<x-admin-layout>
    <x-slot name="title">
        لوحة التحكم الرئيسية
    </x-slot>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-4">

        <!-- Card: Vendors Management -->
        <a href="{{ route('admin.vendors.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-brand-blue-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-brand-blue-100 rounded-xl">
                    <svg class="w-10 h-10 text-brand-blue" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة البائعين</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-brand-blue">{{ $vendorCount }}</span> بائع مسجل
                    </p>
                </div>
            </div>
        </a>

        <!-- Card: Customers Management -->
        <a href="{{ route('admin.users.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-brand-green-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-green-100 rounded-xl">
                    <svg class="w-10 h-10 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A10.99 10.99 0 0112 10c2.67 0 5.057 1.22 6.75 3.147" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة العملاء</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-green-600">{{ $customerCount }}</span> عميل مسجل
                    </p>
                </div>
            </div>
        </a>

        <!-- Card: Stores Management -->
        <a href="{{ route('admin.stores.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-brand-orange-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-brand-orange-100 rounded-xl">
                    <svg class="w-10 h-10 text-brand-orange" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المتاجر</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-brand-orange">{{ $activeStoresCount }}</span> متجر نشط
                    </p>
                </div>
            </div>
        </a>

        <!-- Card: Products Management -->
        <a href="{{ route('admin.products.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-sky-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-sky-100 rounded-xl">
                    <svg class="w-10 h-10 text-sky-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المنتجات</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-sky-600">{{ $productCount }}</span> منتج
                    </p>
                </div>
            </div>
        </a>

        <!-- Card: Wallets Management -->
        <a href="{{ route('admin.wallets.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-brand-purple-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-purple-100 rounded-xl">
                    <svg class="w-10 h-10 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة المحافظ</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-purple-600">{{ number_format($walletTotalBalance, 2) }}</span>
                        ريال
                    </p>
                </div>
            </div>
        </a>

        <!-- Card: Financial Reports -->
        <a href="{{ route('admin.reports.financial') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-brand-indigo-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-indigo-100 rounded-xl">
                    <svg class="w-10 h-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">التقارير المالية</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-indigo-600">{{ $financialReportsCount }}</span> تقرير
                    </p>
                </div>
            </div>
        </a>

        <!-- Card: Reviews -->
        <a href="{{ route('admin.reviews.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-brand-yellow-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-yellow-100 rounded-xl">
                    <svg class="w-10 h-10 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">التقييمات</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-yellow-500">{{ $reviewCount }}</span> تقييم جديد
                    </p>
                </div>
            </div>
        </a>

        <!-- Card: Notifications -->
        <a href="{{ route('admin.notifications.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-brand-rose-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-rose-100 rounded-xl">
                    <svg class="w-10 h-10 text-rose-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الإشعارات</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-rose-500">{{ $notificationCount }}</span> إشعار مرسل
                    </p>
                </div>
            </div>
        </a>

        <!-- Card: Complaints -->
        <a href="{{ route('admin.complaints.index') }}"
            class="block p-8 bg-white rounded-xl shadow-md hover:shadow-xl hover:bg-brand-red-50 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 p-5 bg-red-100 rounded-xl">
                    <svg class="w-10 h-10 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-bold text-gray-800">إدارة الشكاوى</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-extrabold text-red-600">{{ $complaintOpenCount }}</span> شكوى مفتوحة
                    </p>
                </div>
            </div>
        </a>

    </div>
</x-admin-layout>