// **۱. مدیریت حالت دیباگ وردپرس**
if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', true); // در حالت توسعه فعال باشد
}
if (!defined('WP_DEBUG_LOG')) {
    define('WP_DEBUG_LOG', true); // ذخیره لاگ در `wp-content/debug.log`
}
if (!defined('WP_DEBUG_DISPLAY')) {
    define('WP_DEBUG_DISPLAY', false); // جلوگیری از نمایش خطاها در محیط تولید
}
@ini_set('display_errors', 0); // عدم نمایش خطاها در مرورگر

// **۲. تابع لاگ‌گیری سفارشی**
function seokar_debug_log($message) {
    if (WP_DEBUG && WP_DEBUG_LOG) {
        error_log(print_r($message, true));
    }
}

// **۳. نمایش خطاهای لاگ‌شده در پنل مدیریت وردپرس**
function seokar_debug_menu() {
    add_menu_page(
        'دیباگ وردپرس',
        'لاگ‌های خطا',
        'manage_options',
        'seokar-debug-log',
        'seokar_debug_log_page',
        'dashicons-admin-tools',
        99
    );
}
add_action('admin_menu', 'seokar_debug_menu');

function seokar_debug_log_page() {
    $log_file = WP_CONTENT_DIR . '/debug.log';
    ?>
    <div class="wrap">
        <h1>لاگ‌های خطای وردپرس</h1>
        <textarea style="width: 100%; height: 400px;" readonly><?php 
            if (file_exists($log_file)) {
                echo esc_textarea(file_get_contents($log_file));
            } else {
                echo 'هیچ لاگی ثبت نشده است.';
            }
        ?></textarea>
        <form method="post">
            <input type="submit" name="clear_log" class="button button-secondary" value="حذف لاگ‌ها">
        </form>
    </div>
    <?php
    if (isset($_POST['clear_log'])) {
        file_put_contents($log_file, '');
        echo '<script>location.reload();</script>';
    }
}

// **۴. تبدیل `var_dump()` به خروجی زیباتر**
function seokar_pretty_dump($var) {
    echo '<pre style="background: #282c34; color: #61dafb; padding: 10px; border-radius: 5px; overflow: auto;">';
    var_dump($var);
    echo '</pre>';
}
