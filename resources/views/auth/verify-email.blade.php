<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        شكراً لتسجيلك! قبل البدء، هل يمكنك تأكيد عنوان بريدك الإلكتروني بالضغط على الرابط الذي أرسلناه إليك للتو؟ إذا لم تستلم البريد الإلكتروني، فسنرسل لك بكل سرور بريداً آخر.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            تم إرسال رابط تحقق جديد إلى عنوان البريد الإلكتروني الذي قدمته أثناء التسجيل.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-brand-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-brand-blue focus:ring-offset-2 transition ease-in-out duration-150">
                    إعادة إرسال بريد التحقق
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                تسجيل الخروج
            </button>
        </form>
    </div>
</x-guest-layout>