<?php
$path = __DIR__ . '/resources/views/vendor/products/index.blade.php';
$content = file_get_contents($path);

// إن المشكلة تكمن في وجود تكرار أو قطع في الكود (حسب ما نسخه المستخدم)
// بما أن الكود تالف، سأحاول إصلاح زر البحث والجزء المكرر في الأسفل

// 1. Fix the broken button
$content = preg_replace('/<\/but\s*<div class="overflow-x-auto/s', "</button>\n                    </div>\n                    <div class=\"overflow-x-auto", $content);

// 2. Fix the duplicated table end
// Notice there are two `@endforelse` in their code? Let's count them.
$count = substr_count($content, '@endforelse');
if ($count > 1) {
    // There is duplicate garbage. Let's find the first `</table>\s*</div>` and remove everything between it and `<!-- Pagination Links -->`
    $content = preg_replace('/(<\/table>\s*<\/div>).*?(<!-- Pagination Links -->)/s', "$1\n                    $2", $content);
}

// 3. Remove weird character
$content = str_replace("يد", "", $content);

file_put_contents($path, $content);
echo "Done fixing. Count of endforelse: " . $count;
