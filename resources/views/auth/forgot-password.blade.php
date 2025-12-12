<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        هل نسيت كلمة المرور؟ لا مشكلة. فقط أخبرنا ببريدك الإلكتروني وسنرسل لك رابط إعادة تعيين كلمة المرور الذي سيسمح لك باختيار كلمة مرور جديدة.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="البريد الإلكتروني" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-3 bg-brand-blue border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-opacity-90 active:bg-brand-blue-800 focus:outline-none focus:ring-2 focus:ring-brand-blue focus:ring-offset-2 transition ease-in-out duration-150">
                إرسال رابط إعادة التعيين
            </button>
        </div>
    </form>
</x-guest-layout>