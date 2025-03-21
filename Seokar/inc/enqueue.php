<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_Enqueue {

    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    /**
     * **۱. بارگذاری استایل‌ها و اسکریپت‌های قالب**
     */
    public function enqueue_assets() {
        $theme_version = wp_get_theme()->get('Version');

        // **📌 بارگذاری CSS‌ها**
        wp_enqueue_style('seokar-main-style', get_stylesheet_uri(), [], $theme_version);
        wp_enqueue_style('seokar-custom-style', get_template_directory_uri() . '/assets/css/custom.css', [], $theme_version);
        wp_enqueue_style('seokar-responsive', get_template_directory_uri() . '/assets/css/responsive.css', [], $theme_version);

        // **📌 بارگذاری JavaScript‌ها**
        wp_enqueue_script('jquery'); // بارگذاری jQuery پیش‌فرض وردپرس
        wp_enqueue_script('seokar-main-js', get_template_directory_uri() . '/assets/js/scripts.js', ['jquery'], $theme_version, true);
        wp_enqueue_script('seokar-ajax', get_template_directory_uri() . '/assets/js/ajax-handlers.js', ['jquery'], $theme_version, true);

        // **📌 افزودن `defer` و `async` برای افزایش سرعت بارگذاری**
        add_filter('script_loader_tag', [$this, 'add_defer_async'], 10, 2);
    }

    /**
     * **۲. بارگذاری فایل‌های مربوط به پنل مدیریت**
     */
    public function enqueue_admin_assets() {
        $theme_version = wp_get_theme()->get('Version');
        wp_enqueue_style('seokar-admin-style', get_template_directory_uri() . '/assets/css/admin-style.css', [], $theme_version);
        wp_enqueue_script('seokar-admin-js', get_template_directory_uri() . '/assets/js/admin-scripts.js', ['jquery'], $theme_version, true);
    }

    /**
     * **۳. افزودن `defer` و `async` به اسکریپت‌های مشخص**
     *
     * @param string $tag برچسب `<script>` که بارگذاری می‌شود.
     * @param string $handle نام اسکریپت
     * @return string اسکریپت اصلاح شده با `defer` یا `async`
     */
    public function add_defer_async($tag, $handle) {
        $scripts_to_defer = ['seokar-main-js', 'seokar-ajax'];
        $scripts_to_async = ['seokar-admin-js'];

        if (in_array($handle, $scripts_to_defer)) {
            return str_replace(' src=', ' defer src=', $tag);
        }

        if (in_array($handle, $scripts_to_async)) {
            return str_replace(' src=', ' async src=', $tag);
        }

        return $tag;
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
new Seokar_Enqueue();
