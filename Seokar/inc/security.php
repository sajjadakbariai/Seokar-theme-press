<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_Security {

    public function __construct() {
        add_action('init', [$this, 'disable_xml_rpc']);
        add_filter('xmlrpc_enabled', '__return_false');
        add_filter('wp_headers', [$this, 'remove_version_headers']);
        add_filter('script_loader_src', [$this, 'remove_version_query'], 9999);
        add_filter('style_loader_src', [$this, 'remove_version_query'], 9999);
        add_filter('the_generator', '__return_empty_string');
        add_filter('login_errors', '__return_null');
        add_action('wp', [$this, 'block_author_enumeration']);
        add_action('template_redirect', [$this, 'disable_directory_browsing']);
        add_filter('authenticate', [$this, 'limit_failed_logins'], 30, 3);
        add_action('admin_init', [$this, 'restrict_admin_access']);
        add_action('wp_loaded', [$this, 'prevent_xss_attacks']);
        add_action('plugins_loaded', [$this, 'session_security']);
    }

    // **۱. غیرفعال کردن XML-RPC برای جلوگیری از حملات Brute Force**
    public function disable_xml_rpc() {
        add_filter('xmlrpc_enabled', '__return_false');
        remove_action('wp_head', 'rsd_link'); 
    }

    // **۲. مخفی کردن پیام‌های خطای ورود برای جلوگیری از لو رفتن اطلاعات**
    public function remove_version_headers($headers) {
        unset($headers['X-Pingback']);
        return $headers;
    }

    // **۳. حذف ?ver= از لینک‌های CSS و JS برای جلوگیری از شناسایی نسخه وردپرس**
    public function remove_version_query($src) {
        return remove_query_arg('ver', $src);
    }

    // **۴. جلوگیری از حملات User Enumeration (لیست کاربران سایت)**
    public function block_author_enumeration() {
        if (!is_admin() && isset($_REQUEST['author'])) {
            wp_redirect(home_url());
            exit;
        }
    }

    // **۵. جلوگیری از دسترسی مستقیم به فایل‌های حساس**
    public function disable_directory_browsing() {
        if (is_admin()) return;

        $restricted_files = [
            '.htaccess',
            'wp-config.php',
            'php.ini',
            'error_log',
        ];

        foreach ($restricted_files as $file) {
            if (strpos($_SERVER['REQUEST_URI'], $file) !== false) {
                wp_die('⛔ دسترسی غیرمجاز!', 'خطا', ['response' => 403]);
                exit;
            }
        }
    }

    // **۶. محدود کردن تعداد تلاش‌های ناموفق ورود برای جلوگیری از Brute Force**
    public function limit_failed_logins($user, $username, $password) {
        if (!session_id()) {
            session_start();
        }

        if (!isset($_SESSION['failed_login_attempts'])) {
            $_SESSION['failed_login_attempts'] = 0;
        }

        $_SESSION['failed_login_attempts']++;

        if ($_SESSION['failed_login_attempts'] > 5) {
            wp_die('⛔ حساب شما موقتاً قفل شده است. لطفاً بعداً تلاش کنید.', 'خطا', ['response' => 403]);
            exit;
        }

        return $user;
    }

    // **۷. محدود کردن دسترسی به پنل مدیریت فقط برای مدیران**
    public function restrict_admin_access() {
        if (is_admin() && !current_user_can('manage_options') && !(defined('DOING_AJAX') && DOING_AJAX)) {
            wp_redirect(home_url());
            exit;
        }
    }

    // **۸. جلوگیری از حملات XSS از طریق کوئری‌های GET و POST**
    public function prevent_xss_attacks() {
        foreach ($_GET as $key => $value) {
            $_GET[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        foreach ($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
    }

    // **۹. افزایش امنیت نشست‌های کاربری (Sessions)**
    public function session_security() {
        if (!session_id()) {
            session_start();
        }
        if (!isset($_SESSION['user_agent'])) {
            $_SESSION['user_agent'] = md5($_SERVER['HTTP_USER_AGENT']);
        } elseif ($_SESSION['user_agent'] !== md5($_SERVER['HTTP_USER_AGENT'])) {
            session_destroy();
            wp_redirect(home_url());
            exit;
        }
    }
}

// **۱۰. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
new Seokar_Security();
