<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">عنوان الكوبون <span class="text-red-500">*</span></label>
        <input type="text" name="title" required placeholder="مثال: خصم العيد"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">كود الخصم <span class="text-red-500">*</span></label>
        <input type="text" name="code" required placeholder="SALE20"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm font-mono tracking-widest uppercase">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">نوع الخصم <span class="text-red-500">*</span></label>
        <select name="type" required class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
            <option value="percentage">نسبة مئوية (%)</option>
            <option value="fixed">قيمة ثابتة (ر.ي)</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">قيمة الخصم <span class="text-red-500">*</span></label>
        <input type="number" name="value" required step="0.01" min="0"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">الحد الأدنى للطلب (ر.ي)</label>
        <input type="number" name="min_order_amount" step="0.01" min="0" value="0"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">الحد الأقصى للخصم (ر.ي)</label>
        <input type="number" name="max_discount_amount" step="0.01" min="0"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm" placeholder="اتركه فارغاً لعدم التحديد">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">صالح من <span class="text-red-500">*</span></label>
        <input type="date" name="start_date" required
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">صالح حتى <span class="text-red-500">*</span></label>
        <input type="date" name="end_date" required
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">حد الاستخدام الكلي</label>
        <input type="number" name="usage_limit" min="1"
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm" placeholder="اتركه فارغاً لعدم التحديد">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">الحالة <span class="text-red-500">*</span></label>
        <select name="status" required class="w-full border-gray-300 rounded-lg shadow-sm text-sm">
            <option value="active">نشط</option>
            <option value="inactive">معطل</option>
            @isset($edit)
                <option value="expired">منتهي</option>
            @endisset
        </select>
    </div>
</div>
