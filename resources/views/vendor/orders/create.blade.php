<x-vendor-layout>
    <x-slot name="title">إضافة طلب جديد</x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-bold mb-4">إضافة طلب جديد</h2>

                    @if (session('error'))
                        <div class="mb-4 px-4 py-2 bg-red-100 border border-red-200 text-red-700 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('vendor.orders.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">اختر العميل</label>
                            <select name="user_id" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">-- اختر --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">عنوان الشحن</label>
                            <textarea name="shipping_address" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('shipping_address') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">طريقة الدفع</label>
                            <select name="payment_method" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="cash_on_delivery">الدفع عند الاستلام</option>
                                <option value="credit_card">بطاقة ائتمان</option>
                                <option value="bank_transfer">تحويل بنكي</option>
                            </select>
                        </div>

                        <h3 class="font-semibold mb-2">عناصر الطلب</h3>
                        <div id="items">
                            <div class="item-row grid grid-cols-12 gap-2 items-end mb-2">
                                <div class="col-span-9">
                                    <label class="text-sm text-gray-600">المنتج</label>
                                    <select name="products[0][product_id]" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="">-- اختر المنتج --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }} - {{ number_format($product->price,2) }} ر.ي</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-2">
                                    <label class="text-sm text-gray-600">الكمية</label>
                                    <input type="number" name="products[0][quantity]" min="1" value="1" class="mt-1 block w-full rounded-md border-gray-300" />
                                </div>
                                <div class="col-span-1">
                                    <button type="button" onclick="removeRow(this)" class="text-red-600">حذف</button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <button type="button" onclick="addRow()" class="px-3 py-2 bg-gray-100 rounded">+ إضافة عنصر</button>
                        </div>

                        <div class="mb-4">
                            <label class="text-sm text-gray-600">ملاحظات (اختياري)</label>
                            <textarea name="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('vendor.orders.index') }}" class="px-4 py-2 mr-2 rounded bg-gray-100">إلغاء</a>
                            <button type="submit" class="px-4 py-2 rounded bg-brand-orange text-white">إنشاء الطلب</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let index = 1;
        function addRow() {
            const container = document.getElementById('items');
            const row = document.querySelector('.item-row').cloneNode(true);
            row.querySelectorAll('select, input').forEach(el => {
                if (el.name) {
                    el.name = el.name.replace(/products\[0\]/, `products[${index}]`);
                }
                if (el.type === 'number') el.value = 1;
            });
            container.appendChild(row);
            index++;
        }
        function removeRow(btn) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length <= 1) return;
            btn.closest('.item-row').remove();
        }
    </script>
</x-vendor-layout>
