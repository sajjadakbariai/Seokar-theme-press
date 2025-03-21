<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_Debug {

    private $log_file;

    public function __construct() {
        $this->log_file = WP_CONTENT_DIR . '/debug.log';

        add_action('admin_menu', [$this, 'add_debug_menu']);
        $this->setup_debug_constants();
    }

    /**
     * **۱. تنظیم متغیرهای حالت دیباگ وردپرس**
     */
    private function setup_debug_constants() {
        if (!defined('WP_DEBUG')) {
            define('WP_DEBUG', true); // فعال‌سازی دیباگ در محیط توسعه
        }
        if (!defined('WP_DEBUG_LOG')) {
            define('WP_DEBUG_LOG', true); // ذخیره لاگ‌ها در `wp-content/debug.log`
        }
        if (!defined('WP_DEBUG_DISPLAY')) {
            define('WP_DEBUG_DISPLAY', false); // جلوگیری از نمایش خطاها در محیط تولید
        }
        @ini_set('display_errors', 0); // عدم نمایش خطاها در مرورگر
    }

    /**
     * **۲. ثبت لاگ‌های دیباگ در `debug.log`**
     *
     * @param mixed $message پیام یا داده موردنظر برای ثبت در لاگ
     */
    public static function log($message) {
        if (WP_DEBUG && WP_DEBUG_LOG) {
            error_log(date('[Y-m-d H:i:s]') . " " . print_r($message, true) . "\n", 3, WP_CONTENT_DIR . '/debug.log');
        }
    }

    /**
     * **۳. افزودن صفحه مدیریت لاگ‌ها در پنل مدیریت وردپرس**
     */
    public function add_debug_menu() {
        add_menu_page(
            'مدیریت دیباگ وردپرس',
            '📜 لاگ‌های خطا',
            'manage_options',
            'seokar-debug-log',
            [$this, 'render_debug_log_page'],
            'dashicons-admin-tools',
            99
        );
    }

    /**
     * **۴. نمایش محتوای لاگ در پنل مدیریت**
     */
    public function render_debug_log_page() {
        if (isset($_POST['clear_log'])) {
            file_put_contents($this->log_file, '');
            echo '<script>location.reload();</script>';
        }

        $log_content = file_exists($this->log_file) ? file_get_contents($this->log_file) : '🚀 هیچ خطایی ثبت نشده است!';
        ?>
        <div class="wrap">
            <h1>📜 لاگ‌های خطای وردپرس</h1>
            <textarea style="width: 100%; height: 400px; font-family: monospace;" readonly><?php echo esc_textarea($log_content); ?></textarea>
            <form method="post">
                <button type="submit" name="clear_log" class="button button-secondary">🗑 حذف لاگ‌ها</button>
            </form>
        </div>
        <?php
    }

    /**
     * **۵. تبدیل `var_dump()` به خروجی زیباتر**
     *
     * @param mixed $var داده‌ای که باید نمایش داده شود.
     */
    public static function pretty_dump($var) {
        echo '<pre style="background: #1e1e1e; color: #61dafb; padding: 10px; border-radius: 5px; overflow: auto;">';
        var_dump($var);
        echo '</pre>';
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
new Seokar_Debug();
