<?php
if (!defined('ABSPATH')) exit; // امنیت: جلوگیری از دسترسی مستقیم

class Seokar_Theme_Functions {

    // **۱. مقداردهی اولیه هنگام راه‌اندازی قالب**
    public function __construct() {
        add_action('after_setup_theme', [$this, 'theme_setup']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('widgets_init', [$this, 'register_widgets']);
    }

    // **۲. تنظیمات اولیه قالب (پشتیبانی از ویژگی‌های وردپرس)**
    public function theme_setup() {
        // پشتیبانی از تصویر شاخص
        add_theme_support('post-thumbnails');

        // افزودن قابلیت انتخاب فهرست
        register_nav_menus([
            'primary' => 'منوی اصلی',
            'footer'  => 'منوی فوتر'
        ]);

        // پشتیبانی از عنوان پویا
        add_theme_support('title-tag');

        // پشتیبانی از تصاویر واکنش‌گرا در محتوا
        add_theme_support('responsive-embeds');
    }

    // **۳. بارگذاری فایل‌های CSS و JS**
    public function enqueue_assets() {
        // بارگذاری استایل‌های اصلی
        wp_enqueue_style('seokar-main-style', get_stylesheet_uri(), [], '1.0.0');
        wp_enqueue_style('seokar-custom-style', get_template_directory_uri() . '/assets/css/custom.css', [], '1.0.0');

        // بارگذاری اسکریپت‌های اصلی
        wp_enqueue_script('seokar-main-script', get_template_directory_uri() . '/assets/js/scripts.js', ['jquery'], '1.0.0', true);
    }

    // **۴. ثبت ابزارک‌های سفارشی**
    public function register_widgets() {
        register_sidebar([
            'name'          => 'سایدبار اصلی',
            'id'            => 'main_sidebar',
            'description'   => 'ابزارک‌های سایدبار اصلی',
            'before_widget' => '<div class="widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
    }

    // **۵. تابع کمکی برای دریافت تنظیمات قالب**
    public static function get_option($option_name, $default = '') {
        return get_theme_mod($option_name, $default);
    }
}

// **۶. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
new Seokar_Theme_Functions();
