<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>متجرنا الإلكتروني - قريباً</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" style="font-family: 'Cairo', sans-serif;">
    <div class="relative flex justify-center items-center min-h-screen bg-brand-blue-50 sm:items-center py-4 sm:pt-0">

        <!-- Top Right Links -->
        @if (Route::has('login'))
            <div class="hidden sm:block absolute top-0 left-0 px-6 py-4">
                @auth
                    {{-- إذا كان المستخدم مسجلاً دخوله --}}
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <span class="text-gray-600">أهلاً بك، {{ Auth::user()->name }}</span>
                        
                        @if(auth()->user()->hasRole('super-admin'))
                            <a href="{{ url('/admin/dashboard') }}" class="text-sm text-brand-blue-800 font-bold hover:underline">لوحة التحكم</a>
                        @elseif(auth()->user()->hasRole('vendor'))
                            <a href="{{ url('/vendor/dashboard') }}" class="text-sm text-brand-blue-800 font-bold hover:underline">لوحة التحكم</a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="text-sm text-red-600 hover:underline">
                                تسجيل الخروج
                            </a>
                        </form>
                    </div>
                @else
                    {{-- إذا كان المستخدم زائراً --}}
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-brand-blue font-semibold">تسجيل الدخول</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ms-4 text-sm text-gray-700 hover:text-brand-blue font-semibold">تسجيل</a>
                    @endif
                @endauth
            </div>
        @endif

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center">
                <x-application-logo class="h-24 w-auto text-brand-blue"/>
            </div>

            <div class="mt-8">
                <h1 class="text-5xl md:text-6xl font-extrabold text-brand-blue tracking-wider">
                    قريباً...
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    نحن نعمل بجد لإطلاق متجرنا الإلكتروني. ترقبوا تجربة تسوق فريدة من نوعها!
                </p>
            </div>

            <div class="mt-8">
                 <p class="text-sm text-gray-500">
                    تابعونا على وسائل التواصل الاجتماعي
                 </p>
                 <!-- (يمكننا إضافة أيقونات التواصل الاجتماعي هنا لاحقاً) -->
            </div>
        </div>
    </div>
</body>
</html>