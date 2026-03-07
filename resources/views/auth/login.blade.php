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
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <!-- تم نقل رسالة الخطأ للأعلى لتكون أوضح -->
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="كلمة المرور" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <!-- تم نقل رسالة الخطأ للأعلى لتكون أوضح -->
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-brand-blue shadow-sm focus:ring-brand-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">تذكرني</span>
            </label>
            @if (Route::has('password.request'))
                <a class="underline text-sm text-brand-blue hover:text-brand-blue-800"
                    href="{{ route('password.request') }}">
                    نسيت كلمة المرور؟
                </a>
            @endif
        </div>
        <div class="mt-6 space-y-3">
            <button type="submit"
                class="w-full justify-center inline-flex items-center px-4 py-3 bg-brand-orange border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-opacity-90 active:bg-brand-orange-700 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 transition ease-in-out duration-150">
                دخـــول
            </button>

            <a href="{{ route('google.login') }}"
                class="w-full justify-center inline-flex items-center px-4 py-3 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-brand-blue focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 48 48">
                    <title>Google Logo</title>
                    <g>
                        <path fill="#EA4335"
                            d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z">
                        </path>
                        <path fill="#4285F4"
                            d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z">
                        </path>
                        <path fill="#FBBC05"
                            d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z">
                        </path>
                        <path fill="#34A853"
                            d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z">
                        </path>
                        <path fill="none" d="M0 0h48v48H0z"></path>
                    </g>
                </svg>
                تسجيل الدخول بواسطة Google
            </a>
        </div>
    </form>
</x-guest-layout>