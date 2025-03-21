// **۱. حذف استایل‌های بلاک ادیتور از فرانت‌اند (اگر استفاده نمی‌کنید)**
function seokar_remove_block_library_css() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
}
add_action('wp_enqueue_scripts', 'seokar_remove_block_library_css', 100);

// **۲. غیرفعال کردن ایموجی‌های وردپرس برای کاهش درخواست‌های HTTP**
function seokar_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
}
add_action('init', 'seokar_disable_emojis');

// **۳. حذف query strings از منابع استاتیک (برای بهبود کشینگ)**
function seokar_remove_query_strings($src) {
    if (strpos($src, '?ver=') !== false) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('script_loader_src', 'seokar_remove_query_strings', 15);
add_filter('style_loader_src', 'seokar_remove_query_strings', 15);

// **۴. فعال کردن Gzip برای بهینه‌سازی خروجی**
function seokar_enable_gzip() {
    if (!ob_start("ob_gzhandler")) {
        ob_start();
    }
}
add_action('init', 'seokar_enable_gzip');

// **۵. حذف خودکار رونوشت‌های قدیمی پست‌ها برای کاهش حجم دیتابیس**
function seokar_limit_post_revisions() {
    if (!defined('WP_POST_REVISIONS')) {
        define('WP_POST_REVISIONS', 5);
    }
}
add_action('init', 'seokar_limit_post_revisions');

// **۶. بهینه‌سازی پایگاه داده به‌صورت زمان‌بندی‌شده**
function seokar_optimize_database() {
    global $wpdb;
    $wpdb->query('OPTIMIZE TABLE ' . $wpdb->posts);
    $wpdb->query('OPTIMIZE TABLE ' . $wpdb->postmeta);
    $wpdb->query('OPTIMIZE TABLE ' . $wpdb->comments);
    $wpdb->query('OPTIMIZE TABLE ' . $wpdb->commentmeta);
    $wpdb->query('OPTIMIZE TABLE ' . $wpdb->options);
}
if (!wp_next_scheduled('seokar_db_optimization_event')) {
    wp_schedule_event(time(), 'weekly', 'seokar_db_optimization_event');
}
add_action('seokar_db_optimization_event', 'seokar_optimize_database');

// **۷. لود تنبل تصاویر (Lazy Load)**
function seokar_lazyload_images($content) {
    if (!is_admin()) {
        $content = preg_replace('/<img(.*?)src=/', '<img$1loading="lazy" src=', $content);
    }
    return $content;
}
add_filter('the_content', 'seokar_lazyload_images');
