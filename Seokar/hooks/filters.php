// **۱. تغییر متن "ادامه مطلب" در پست‌ها**
function seokar_modify_read_more($more) {
    return '... <a class="read-more" href="' . get_permalink() . '">ادامه مطلب</a>';
}
add_filter('excerpt_more', 'seokar_modify_read_more');

// **۲. افزودن پیشوند به عنوان صفحات**
function seokar_custom_title_prefix($title) {
    if (is_admin()) return $title;
    return '📌 ' . $title;
}
add_filter('the_title', 'seokar_custom_title_prefix');

// **۳. فیلتر کردن محتوای نوشته‌ها برای افزودن هشدار**
function seokar_filter_post_content($content) {
    if (is_single()) {
        $content = '<div class="post-warning">⚠️ این یک مطلب جدید است!</div>' . $content;
    }
    return $content;
}
add_filter('the_content', 'seokar_filter_post_content');

// **۴. حذف کلمات نامناسب از نظرات کاربران**
function seokar_filter_bad_words($comment) {
    $bad_words = array('بد', 'زشت', 'نامناسب'); // کلمات فیلتر شده
    return str_ireplace($bad_words, '***', $comment);
}
add_filter('comment_text', 'seokar_filter_bad_words');
