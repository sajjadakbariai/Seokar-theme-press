<?php
namespace Seokar;

defined('ABSPATH') || exit;

class Enqueue {

    /**
     * **۱. مقداردهی اولیه و ثبت هوک‌ها**
     */
    public static function register() {
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_assets']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_admin_assets']);
    }

    /**
     * **۲. بارگذاری فایل‌های استایل و اسکریپت قالب**
     */
    public static function enqueue_assets() {
        $theme_version = wp_get_theme()->get('Version');

        // استایل اصلی قالب
        wp_enqueue_style('seokar-style', get_stylesheet_uri(), [], $theme_version);
        wp_enqueue_style('seokar-custom', get_template_directory_uri() . '/assets/css/custom.css', ['seokar-style'], $theme_version);
        
        // استایل مخصوص راست‌چین (RTL)
        if (is_rtl()) {
            wp_enqueue_style('seokar-rtl', get_template_directory_uri() . '/assets/css/rtl.css', ['seokar-style'], $theme_version);
        }

        // اسکریپت‌های عمومی قالب
        wp_enqueue_script('seokar-scripts', get_template_directory_uri() . '/assets/js/scripts.js', ['jquery'], $theme_version, true);

        // بارگذاری شرطی اسکریپت صفحه اصلی
        if (is_front_page()) {
            wp_enqueue_script('seokar-home', get_template_directory_uri() . '/assets/js/home.js', ['jquery'], $theme_version, true);
        }

        // ارسال مقدارهای PHP به جاوااسکریپت
        wp_localize_script('seokar-scripts', 'seokar_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('seokar_ajax_nonce'),
        ]);
    }

    /**
     * **۳. بارگذاری فایل‌های استایل و اسکریپت برای پنل مدیریت**
     */
    public static function enqueue_admin_assets() {
        $theme_version = wp_get_theme()->get('Version');

        wp_enqueue_style('seokar-admin-style', get_template_directory_uri() . '/assets/css/admin-style.css', [], $theme_version);
        wp_enqueue_script('seokar-admin-scripts', get_template_directory_uri() . '/assets/js/admin-scripts.js', ['jquery'], $theme_version, true);
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
Enqueue::register();
