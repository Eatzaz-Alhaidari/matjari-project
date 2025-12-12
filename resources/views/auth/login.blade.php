<x-guest-layout>
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-brand-blue">تسجيل الدخول</h1>
        <p class="text-sm text-gray-500">أهلاً بك مجدداً في متجرنا</p>
    </div>

    <!-- ##### بداية الكود المضاف ##### -->
    <!-- Session Status (For password reset success message) -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- General Validation Errors -->
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
    <x-input-error :messages="$errors->get('password')" class="mt-2" />
    <!-- ##### نهاية الكود المضاف ##### -->

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="البريد الإلكتروني" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <!-- تم نقل رسالة الخطأ للأعلى لتكون أوضح -->
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="كلمة المرور" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <!-- تم نقل رسالة الخطأ للأعلى لتكون أوضح -->
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-brand-blue shadow-sm focus:ring-brand-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">تذكرني</span>
            </label>
            @if (Route::has('password.request'))
                <a class="underline text-sm text-brand-blue hover:text-brand-blue-800" href="{{ route('password.request') }}">
                    نسيت كلمة المرور؟
                </a>
            @endif
        </div>
        <div class="mt-6">
            <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-3 bg-brand-orange border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-opacity-90 active:bg-brand-orange-700 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 transition ease-in-out duration-150">
                دخـــول
            </button>
        </div>
        <div class="text-center mt-6">
             <a class="text-sm text-gray-500 hover:text-brand-blue" href="{{ route('register') }}">
                ليس لديك حساب؟ <span class="font-bold text-brand-blue">سجل الآن</span>
            </a>
        </div>
    </form>
</x-guest-layout>