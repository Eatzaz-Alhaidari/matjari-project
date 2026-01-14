# توثيق جداول قاعدة البيانات - مشروع متجري

هذا الملف يحتوي على شرح شامل لجميع جداول قاعدة البيانات في المشروع.

---

## 1. جدول المستخدمين (users)

**الوصف:** يحتوي على معلومات جميع المستخدمين في النظام (عملاء، بائعين، مدراء)

**الحقول:**
- `id` - المعرف الفريد
- `name` - اسم المستخدم
- `email` - البريد الإلكتروني (فريد)
- `email_verified_at` - تاريخ التحقق من البريد
- `password` - كلمة المرور المشفرة
- `phone` - رقم الهاتف
- `profile_photo_path` - مسار صورة الملف الشخصي
- `status` - حالة المستخدم (active, inactive, banned)
- `ban_reason` - سبب الحظر (في حالة الحظر)
- `remember_token` - رمز التذكر للجلسات
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**العلاقات:**
- له علاقة مع جدول `stores` (يمكن أن يكون بائع)
- له علاقة مع جدول `orders` (يمكن أن يكون عميل)
- له علاقة مع جدول `wallets` (للبائعين)
- له علاقة مع جدول `reviews` (التقييمات)
- له علاقة مع جدول `complaints` (الشكاوى)
- له علاقة مع جدول `order_returns` (إرجاع الطلبات)

---

## 2. جدول المتاجر (stores)

**الوصف:** يحتوي على معلومات المتاجر التي يمتلكها البائعون

**الحقول:**
- `id` - المعرف الفريد
- `user_id` - معرف صاحب المتجر (علاقة مع users)
- `name` - اسم المتجر
- `slug` - رابط فريد للمتجر
- `slogan` - شعار المتجر النصي
- `description` - وصف المتجر
- `commercial_registration` - السجل التجاري
- `address` - عنوان المتجر
- `logo_path` - مسار شعار المتجر
- `cover_image_path` - مسار صورة الغلاف
- `support_phone` - رقم هاتف الدعم
- `support_email` - بريد الدعم
- `shipping_policy` - سياسة الشحن
- `return_policy` - سياسة الإرجاع
- `accounting_system` - النظام المحاسبي
- `is_active` - حالة تفعيل المتجر (نشط/غير نشط)
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**العلاقات:**
- علاقة مع `users` (صاحب المتجر)
- علاقة مع `products` (منتجات المتجر)
- علاقة مع `orders` (طلبات المتجر)
- علاقة مع `advertisements` (إعلانات المتجر)
- علاقة مع `discounts` (خصومات المتجر)
- علاقة مع `wallets` (محفظة المتجر)

---

## 3. جدول الفئات (categories)

**الوصف:** يحتوي على فئات المنتجات (لابتوبات، كاميرات، إلخ)

**الحقول:**
- `id` - المعرف الفريد
- `name` - اسم الفئة
- `slug` - رابط فريد للفئة
- `description` - وصف الفئة
- `image` - صورة الفئة
- `status` - حالة الفئة (active, inactive)
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**العلاقات:**
- علاقة مع `products` (المنتجات في هذه الفئة)

---

## 4. جدول المنتجات (products)

**الوصف:** يحتوي على معلومات جميع المنتجات في النظام

**الحقول:**
- `id` - المعرف الفريد
- `product_code` - كود المنتج
- `name` - اسم المنتج
- `brand` - العلامة التجارية
- `description` - الوصف القصير
- `full_description` - الوصف الكامل
- `notes` - ملاحظات إضافية
- `price` - السعر
- `cost_price` - سعر التكلفة
- `price_before` - السعر قبل الخصم
- `stock` - الكمية المتوفرة
- `min_stock` - الحد الأدنى للمخزون
- `image` - الصورة الرئيسية
- `three_d_model` - نموذج ثلاثي الأبعاد
- `three_sixty_images` - صور 360 درجة (JSON)
- `warranty` - الضمان
- `status` - حالة المنتج (active, inactive)
- `store_id` - معرف المتجر (علاقة مع stores)
- `category_id` - معرف الفئة (علاقة مع categories)
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**العلاقات:**
- علاقة مع `stores` (المتجر المالك)
- علاقة مع `categories` (الفئة)
- علاقة مع `order_items` (عناصر الطلبات)
- علاقة مع `reviews` (التقييمات)
- علاقة مع `product_images` (صور المنتج الإضافية)
- علاقة مع `order_returns` (إرجاع الطلبات)

---

## 5. جدول صور المنتجات (product_images)

**الوصف:** يحتوي على الصور الإضافية للمنتجات

**الحقول:**
- `id` - المعرف الفريد
- `product_id` - معرف المنتج (علاقة مع products)
- `image_path` - مسار الصورة
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**العلاقات:**
- علاقة مع `products` (المنتج)

---

## 6. جدول الطلبات (orders)

**الوصف:** يحتوي على جميع الطلبات في النظام

**الحقول:**
- `id` - المعرف الفريد
- `order_number` - رقم الطلب (فريد)
- `user_id` - معرف العميل (علاقة مع users)
- `store_id` - معرف المتجر (علاقة مع stores)
- `total_amount` - المبلغ الإجمالي
- `status` - حالة الطلب (pending, processing, shipped, delivered, cancelled)
- `tracking_number` - رقم التتبع
- `carrier_name` - اسم شركة الشحن
- `shipping_city` - مدينة الشحن
- `shipping_address` - عنوان الشحن
- `payment_method` - طريقة الدفع (cash_on_delivery, credit_card, bank_transfer, wallet, etc.)
- `payment_proof` - إثبات الدفع (صورة)
- `payment_status` - حالة الدفع (pending, paid, failed)
- `notes` - ملاحظات
- `problem_reason` - سبب المشكلة (إن وجدت)
- `shipped_at` - تاريخ الشحن
- `delivered_at` - تاريخ التسليم
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**العلاقات:**
- علاقة مع `users` (العميل)
- علاقة مع `stores` (المتجر)
- علاقة مع `order_items` (عناصر الطلب)
- علاقة مع `shipments` (الشحنات)
- علاقة مع `order_returns` (إرجاع الطلبات)
- علاقة مع `complaints` (الشكاوى)

---

## 7. جدول عناصر الطلب (order_items)

**الوصف:** يحتوي على المنتجات المطلوبة في كل طلب

**الحقول:**
- `id` - المعرف الفريد
- `order_id` - معرف الطلب (علاقة مع orders)
- `product_id` - معرف المنتج (علاقة مع products)
- `quantity` - الكمية
- `price` - سعر المنتج وقت الطلب
- `total` - الإجمالي (الكمية × السعر)
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**العلاقات:**
- علاقة مع `orders` (الطلب)
- علاقة مع `products` (المنتج)

---

## 8. جدول الشحنات (shipments)

**الوصف:** يحتوي على معلومات الشحنات المرتبطة بالطلبات

**الحقول:**
- `id` - المعرف الفريد
- `order_id` - معرف الطلب (علاقة مع orders)
- `shipping_company` - شركة الشحن (افتراضي: "توصيل")
- `shipment_id` - معرف الشحنة من شركة الشحن الخارجية
- `tracking_number` - رقم التتبع (فريد)
- `status` - حالة الشحنة (pending, picked_up, in_transit, delivered, failed)
- `cost` - تكلفة الشحن (افتراضي: 1000)
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**العلاقات:**
- علاقة مع `orders` (الطلب)

---

## 9. جدول إرجاع الطلبات (order_returns)

**الوصف:** يحتوي على طلبات الإرجاع والاسترجاع

**الحقول:**
- `id` - المعرف الفريد
- `order_id` - معرف الطلب (علاقة مع orders)
- `product_id` - معرف المنتج (علاقة مع products)
- `user_id` - معرف العميل (علاقة مع users)
- `quantity` - الكمية المراد إرجاعها
- `reason` - سبب الإرجاع
- `status` - حالة الإرجاع (pending, approved, rejected, refunded)
- `is_restocked` - هل تم إعادة المنتج للمخزون
- `refund_amount` - مبلغ الاسترجاع
- `admin_response` - رد الإدارة
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**العلاقات:**
- علاقة مع `orders` (الطلب)
- علاقة مع `products` (المنتج)
- علاقة مع `users` (العميل)

---

## 10. جدول التقييمات (reviews)

**الوصف:** يحتوي على تقييمات العملاء للمنتجات

**الحقول:**
- `id` - المعرف الفريد
- `user_id` - معرف المستخدم (علاقة مع users)
- `product_id` - معرف المنتج (علاقة مع products)
- `rating` - التقييم (رقم)
- `comment` - التعليق
- `status` - حالة التقييم (pending, approved, rejected)
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**العلاقات:**
- علاقة مع `users` (المستخدم)
- علاقة مع `products` (المنتج)

---

## 11. جدول الشكاوى (complaints)

**الوصف:** يحتوي على شكاوى المستخدمين

**الحقول:**
- `id` - المعرف الفريد
- `user_id` - معرف المستخدم (علاقة مع users)
- `order_id` - معرف الطلب (اختياري)
- `subject` - موضوع الشكوى
- `message` - نص الشكوى
- `status` - حالة الشكوى (open, closed, resolved)
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**العلاقات:**
- علاقة مع `users` (المستخدم)
- علاقة مع `orders` (الطلب - اختياري)

---

## 12. جدول المحافظ (wallets)

**الوصف:** يحتوي على محافظ البائعين للأموال

**الحقول:**
- `id` - المعرف الفريد
- `user_id` - معرف المستخدم/البائع (علاقة مع users)
- `balance` - الرصيد الحالي
- `total_earnings` - إجمالي الأرباح
- `withdrawn_amount` - المبلغ المسحوب
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**العلاقات:**
- علاقة مع `users` (البائع)
- علاقة مع `wallet_transactions` (معاملات المحفظة)

---

## 13. جدول معاملات المحفظة (wallet_transactions)

**الوصف:** يحتوي على سجل جميع المعاملات المالية للمحافظ

**الحقول:**
- `id` - المعرف الفريد
- `wallet_id` - معرف المحفظة (علاقة مع wallets)
- `type` - نوع المعاملة (deposit, withdrawal, purchase, refund, transfer)
- `amount` - المبلغ
- `reference_id` - معرف مرجعي (مثل معرف الطلب)
- `description` - وصف المعاملة
- `status` - حالة المعاملة (pending, completed, failed, cancelled)
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**العلاقات:**
- علاقة مع `wallets` (المحفظة)

---

## 14. جدول الإعلانات (advertisements)

**الوصف:** يحتوي على إعلانات المتاجر

**الحقول:**
- `id` - المعرف الفريد
- `store_id` - معرف المتجر (علاقة مع stores)
- `title` - عنوان الإعلان
- `description` - وصف الإعلان
- `image` - صورة الإعلان
- `status` - حالة الإعلان (active, inactive, pending)
- `start_date` - تاريخ البدء
- `end_date` - تاريخ الانتهاء
- `budget` - الميزانية
- `clicks` - عدد النقرات
- `views` - عدد المشاهدات
- `target_url` - رابط الهدف
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**العلاقات:**
- علاقة مع `stores` (المتجر)

---

## 15. جدول الخصومات (discounts)

**الوصف:** يحتوي على أكواد الخصومات والعروض

**الحقول:**
- `id` - المعرف الفريد
- `store_id` - معرف المتجر (علاقة مع stores)
- `title` - عنوان الخصم
- `description` - وصف الخصم
- `code` - كود الخصم (فريد)
- `type` - نوع الخصم (percentage, fixed)
- `value` - قيمة الخصم
- `min_order_amount` - الحد الأدنى لمبلغ الطلب
- `max_discount_amount` - الحد الأقصى لمبلغ الخصم
- `start_date` - تاريخ البدء
- `end_date` - تاريخ الانتهاء
- `usage_limit` - حد الاستخدام (عدد المرات)
- `used_count` - عدد مرات الاستخدام
- `status` - حالة الخصم (active, inactive, expired)
- `applicable_products` - المنتجات المطبق عليها الخصم (JSON)
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**العلاقات:**
- علاقة مع `stores` (المتجر)

---

## 16. جدول الإعدادات (settings)

**الوصف:** يحتوي على إعدادات النظام العامة

**الحقول:**
- `id` - المعرف الفريد
- `key` - مفتاح الإعداد (فريد)
- `value` - قيمة الإعداد
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

**الإعدادات الافتراضية:**
- `site_name` - اسم الموقع (افتراضي: "متجري")
- `site_description` - وصف الموقع
- `commission_rate` - نسبة العمولة (افتراضي: 10%)
- `auto_approve_vendors` - الموافقة التلقائية على البائعين
- `auto_approve_products` - الموافقة التلقائية على المنتجات
- `support_email` - بريد الدعم
- `support_phone` - هاتف الدعم
- `maintenance_mode` - وضع الصيانة

---

## 17. جدول سجل الأنشطة (activity_logs)

**الوصف:** يحتوي على سجل جميع الأنشطة في النظام

**الحقول:**
- `id` - المعرف الفريد
- `user_id` - معرف المستخدم (اختياري)
- `user_type` - نوع المستخدم (admin, vendor, customer)
- `action_type` - نوع الإجراء (create, update, delete, login, logout, payment)
- `subject_type` - نوع الموضوع (product, order, store, etc.)
- `subject_id` - معرف الموضوع
- `description` - وصف النشاط
- `ip_address` - عنوان IP
- `user_agent` - معلومات المتصفح
- `severity` - مستوى الخطورة (low, medium, high)
- `created_at` - تاريخ الإنشاء

**العلاقات:**
- علاقة مع `users` (المستخدم - اختياري)

---

## 18. جدول الإشعارات (notifications)

**الوصف:** يحتوي على إشعارات المستخدمين (Laravel Notifications)

**الحقول:**
- `id` - المعرف الفريد (UUID)
- `type` - نوع الإشعار
- `notifiable_type` - نوع الكائن المستلم (User, Store, etc.)
- `notifiable_id` - معرف الكائن المستلم
- `data` - بيانات الإشعار (JSON)
- `read_at` - تاريخ القراءة
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

---

## 19. جداول الصلاحيات (Permission Tables)

**الوصف:** جداول نظام الصلاحيات (Laravel Spatie Permission)

### 19.1. جدول الصلاحيات (permissions)
- `id` - المعرف الفريد
- `name` - اسم الصلاحية
- `guard_name` - اسم الحارس
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

### 19.2. جدول الأدوار (roles)
- `id` - المعرف الفريد
- `name` - اسم الدور
- `guard_name` - اسم الحارس
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

### 19.3. جدول ربط الصلاحيات بالنماذج (model_has_permissions)
- `permission_id` - معرف الصلاحية
- `model_type` - نوع النموذج
- `model_id` - معرف النموذج

### 19.4. جدول ربط الأدوار بالنماذج (model_has_roles)
- `role_id` - معرف الدور
- `model_type` - نوع النموذج
- `model_id` - معرف النموذج

### 19.5. جدول ربط الصلاحيات بالأدوار (role_has_permissions)
- `permission_id` - معرف الصلاحية
- `role_id` - معرف الدور

---

## 20. جداول النظام (System Tables)

### 20.1. جدول الكاش (cache)
- `key` - المفتاح (Primary Key)
- `value` - القيمة
- `expiration` - تاريخ الانتهاء

### 20.2. جدول أقفال الكاش (cache_locks)
- `key` - المفتاح (Primary Key)
- `owner` - المالك
- `expiration` - تاريخ الانتهاء

### 20.3. جدول المهام (jobs)
- `id` - المعرف الفريد
- `queue` - اسم الطابور
- `payload` - بيانات المهمة
- `attempts` - عدد المحاولات
- `reserved_at` - تاريخ الحجز
- `available_at` - تاريخ التوفر
- `created_at` - تاريخ الإنشاء

### 20.4. جدول دفعات المهام (job_batches)
- `id` - المعرف الفريد (String)
- `name` - اسم الدفعة
- `total_jobs` - إجمالي المهام
- `pending_jobs` - المهام المعلقة
- `failed_jobs` - المهام الفاشلة
- `failed_job_ids` - معرفات المهام الفاشلة
- `options` - خيارات إضافية
- `cancelled_at` - تاريخ الإلغاء
- `created_at` - تاريخ الإنشاء
- `finished_at` - تاريخ الانتهاء

### 20.5. جدول المهام الفاشلة (failed_jobs)
- `id` - المعرف الفريد
- `uuid` - المعرف الفريد (UUID)
- `connection` - الاتصال
- `queue` - اسم الطابور
- `payload` - بيانات المهمة
- `exception` - الاستثناء
- `failed_at` - تاريخ الفشل

### 20.6. جدول رموز إعادة تعيين كلمة المرور (password_reset_tokens)
- `email` - البريد الإلكتروني (Primary Key)
- `token` - الرمز
- `created_at` - تاريخ الإنشاء

### 20.7. جدول الجلسات (sessions)
- `id` - المعرف الفريد (String)
- `user_id` - معرف المستخدم (اختياري)
- `ip_address` - عنوان IP
- `user_agent` - معلومات المتصفح
- `payload` - بيانات الجلسة
- `last_activity` - آخر نشاط

### 20.8. جدول رموز الوصول الشخصية (personal_access_tokens)
- `id` - المعرف الفريد
- `tokenable_type` - نوع الكائن
- `tokenable_id` - معرف الكائن
- `name` - اسم الرمز
- `token` - الرمز (فريد)
- `abilities` - الصلاحيات
- `last_used_at` - آخر استخدام
- `expires_at` - تاريخ الانتهاء
- `created_at`, `updated_at` - تواريخ الإنشاء والتحديث

---

## ملخص الجداول

### جداول الأعمال الرئيسية:
1. users - المستخدمون
2. stores - المتاجر
3. categories - الفئات
4. products - المنتجات
5. product_images - صور المنتجات
6. orders - الطلبات
7. order_items - عناصر الطلب
8. shipments - الشحنات
9. order_returns - إرجاع الطلبات
10. reviews - التقييمات
11. complaints - الشكاوى
12. wallets - المحافظ
13. wallet_transactions - معاملات المحفظة
14. advertisements - الإعلانات
15. discounts - الخصومات
16. settings - الإعدادات
17. activity_logs - سجل الأنشطة
18. notifications - الإشعارات

### جداول الصلاحيات:
19. permissions - الصلاحيات
20. roles - الأدوار
21. model_has_permissions - ربط الصلاحيات
22. model_has_roles - ربط الأدوار
23. role_has_permissions - ربط الصلاحيات بالأدوار

### جداول النظام:
24. cache - الكاش
25. cache_locks - أقفال الكاش
26. jobs - المهام
27. job_batches - دفعات المهام
28. failed_jobs - المهام الفاشلة
29. password_reset_tokens - رموز إعادة تعيين كلمة المرور
30. sessions - الجلسات
31. personal_access_tokens - رموز الوصول الشخصية

---

## العلاقات الرئيسية

```
users (1) ──→ (N) stores
users (1) ──→ (N) orders
users (1) ──→ (1) wallets
users (1) ──→ (N) reviews
users (1) ──→ (N) complaints

stores (1) ──→ (N) products
stores (1) ──→ (N) orders
stores (1) ──→ (N) advertisements
stores (1) ──→ (N) discounts

categories (1) ──→ (N) products

products (1) ──→ (N) product_images
products (1) ──→ (N) order_items
products (1) ──→ (N) reviews

orders (1) ──→ (N) order_items
orders (1) ──→ (1) shipments
orders (1) ──→ (N) order_returns

wallets (1) ──→ (N) wallet_transactions
```

---

**تاريخ الإنشاء:** 2026
**آخر تحديث:** 2026
