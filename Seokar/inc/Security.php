<?php
namespace Seokar;

defined('ABSPATH') || exit;

class Security {

    public function __construct() {
        add_action('init', [$this, 'apply']);
        add_action('wp_login_failed', [$this, 'track_login_attempts']);
        add_action('wp_authenticate', [$this, 'limit_login_attempts']);
        add_action('template_redirect', [$this, 'disable_author_url']);
        add_filter('rest_authentication_errors', [$this, 'restrict_rest_api']);
        add_filter('login_errors', [$this, 'custom_login_errors']);
        add_filter('xmlrpc_enabled', '__return_false');
        add_filter('the_generator', '__return_empty_string');
        add_filter('rest_authentication_errors', [$this, 'disable_rest_api']);
    }

    /**
     * **۱. افزایش امنیت با حذف ویژگی‌های غیرضروری**
     */
    public function apply() {
        remove_action('wp_head', 'wp_generator'); // حذف نسخه وردپرس
        remove_action('wp_head', 'wlwmanifest_link'); // حذف Windows Live Writer
        remove_action('wp_head', 'rsd_link'); // حذف Really Simple Discovery (RSD)
        remove_action('wp_head', 'wp_shortlink_wp_head'); // حذف Shortlink
        remove_action('wp_head', 'rest_output_link_wp_head'); // حذف REST API link

        // غیرفعال کردن ویرایش فایل‌های قالب و افزونه از پنل مدیریت
        if (!defined('DISALLOW_FILE_EDIT')) {
            define('DISALLOW_FILE_EDIT', true);
        }
    }

    /**
     * **۲. محدود کردن دسترسی به REST API**
     */
    public function restrict_rest_api($access) {
        if (!is_user_logged_in()) {
            return new \WP_Error('rest_cannot_access', __('دسترسی به REST API محدود شده است.'), ['status' => 403]);
        }
        return $access;
    }

    /**
     * **۳. غیرفعال کردن نمایش نام کاربری در URL نویسنده**
     */
    public function disable_author_url() {
        if (is_author()) {
            wp_redirect(home_url());
            exit;
        }
    }

    /**
     * **۴. محدود کردن تعداد تلاش‌های ورود برای جلوگیری از Brute Force**
     */
    public function limit_login_attempts() {
        if (!session_id()) {
            session_start();
        }

        $max_attempts = 5;
        $lockout_time = 5 * 60; // 5 دقیقه

        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
        }

        if ($_SESSION['login_attempts'] >= $max_attempts) {
            $_SESSION['lockout_time'] = time() + $lockout_time;
        }

        if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']) {
            wp_die('🚫 شما تعداد دفعات زیادی برای ورود تلاش کردید. لطفاً بعداً دوباره امتحان کنید.');
        }
    }

    /**
     * **۵. ثبت تلاش‌های ورود ناموفق**
     */
    public function track_login_attempts() {
        if (!session_id()) {
            session_start();
        }
        $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] + 1 : 1;
    }

    /**
     * **۶. تغییر پیام خطای ورود برای جلوگیری از افشای اطلاعات**
     */
    public function custom_login_errors() {
        return __('⚠️ اطلاعات ورود اشتباه است!');
    }

    /**
     * **۷. غیرفعال کردن REST API برای کاربران غیرمجاز**
     */
    public function disable_rest_api($access) {
        if (!is_user_logged_in()) {
            return new \WP_Error('rest_disabled', __('🚫 REST API غیرفعال شده است.'), ['status' => 403]);
        }
        return $access;
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
new Security();
