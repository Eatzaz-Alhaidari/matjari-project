<x-guest-layout>
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-brand-blue">إنشاء حساب جديد</h1>
        <p class="text-sm text-gray-500">انضم إلى مجتمعنا من البائعين والمشترين</p>
    </div>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <x-input-label for="name" value="الاسم الكامل" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="email" value="البريد الإلكتروني" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="password" value="كلمة المرور" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="تأكيد كلمة المرور" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-brand-blue" href="{{ route('login') }}">
                لديك حساب بالفعل؟
            </a>
            <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-brand-orange border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 active:bg-brand-orange-700 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 transition ease-in-out duration-150">
                تسجيل
            </button>
        </div>
    </form>
</x-guest-layout>