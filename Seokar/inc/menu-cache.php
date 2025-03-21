<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_Menu_Cache {

    /**
     * مقداردهی اولیه کلاس و تنظیم هوک‌ها
     */
    public function __construct() {
        add_filter('wp_nav_menu', [$this, 'cache_menu'], 10, 2);
        add_action('save_post', [$this, 'clear_menu_cache']);
        add_action('wp_update_nav_menu', [$this, 'clear_menu_cache']);
        add_action('customize_save_after', [$this, 'clear_menu_cache']);
        add_action('switch_theme', [$this, 'clear_menu_cache']); 
        add_action('wp_loaded', [$this, 'clean_expired_cache']); // پاک‌سازی کش‌های منقضی‌شده
    }

    /**
     * کش کردن خروجی `wp_nav_menu()`
     *
     * @param string   $nav_menu خروجی HTML منو.
     * @param stdClass $args     آرگومان‌های `wp_nav_menu()`.
     *
     * @return string کش شده یا تازه تولید شده HTML منو.
     */
    public function cache_menu($nav_menu, $args) {
        if (is_admin() || !isset($args->theme_location)) {
            return $nav_menu;
        }

        $cache_key = 'seokar_menu_' . md5($args->theme_location . get_locale() . get_current_blog_id());
        $cached_menu = get_transient($cache_key);

        if (false === $cached_menu) {
            set_transient($cache_key, $nav_menu, DAY_IN_SECONDS);
            return $nav_menu;
        }

        return $cached_menu;
    }

    /**
     * پاک‌سازی کش منوها هنگام بروزرسانی تنظیمات یا تغییر منو
     */
    public function clear_menu_cache() {
        global $wpdb;
        $prefix = '_transient_seokar_menu_';
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '{$prefix}%'");
    }

    /**
     * پاک‌سازی کش‌های منقضی‌شده برای جلوگیری از افزایش حجم دیتابیس
     */
    public function clean_expired_cache() {
        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_seokar_menu_%' AND option_value < UNIX_TIMESTAMP()");
    }

    /**
     * بررسی حجم کلی کش‌ها و جلوگیری از افزایش بی‌رویه حجم دیتابیس
     */
    public static function get_cache_size() {
        global $wpdb;
        $size = $wpdb->get_var("SELECT SUM(LENGTH(option_value)) FROM {$wpdb->options} WHERE option_name LIKE '_transient_seokar_menu_%'");
        return $size ? round($size / 1024, 2) . ' KB' : '0 KB';
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
new Seokar_Menu_Cache();
