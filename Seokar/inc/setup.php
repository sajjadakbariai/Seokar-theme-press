<?php
if (!defined('ABSPATH')) exit; // امنیت: جلوگیری از دسترسی مستقیم

class Seokar_Setup {

    // **۱. مقداردهی اولیه تنظیمات قالب**
    public function __construct() {
        add_action('after_setup_theme', [$this, 'theme_setup']);
        add_action('init', [$this, 'register_menus']);
        add_action('init', [$this, 'register_sidebars']);
        add_action('wp_enqueue_scripts', [$this, 'load_theme_assets']);
    }

    // **۲. تنظیمات پایه قالب**
    public function theme_setup() {
        // پشتیبانی از تصاویر شاخص
        add_theme_support('post-thumbnails');

        // فعال‌سازی مدیریت عنوان سایت
        add_theme_support('title-tag');

        // فعال‌سازی پشتیبانی از ترجمه
        load_theme_textdomain('seokar', get_template_directory() . '/languages');

        // پشتیبانی از تصاویر واکنش‌گرا در محتوا
        add_theme_support('responsive-embeds');

        // پشتیبانی از بلوک‌های گوتنبرگ
        add_theme_support('editor-styles');
        add_editor_style('assets/css/editor-style.css');
    }

    // **۳. ثبت منوهای ناوبری قالب**
    public function register_menus() {
        register_nav_menus([
            'primary' => __('منوی اصلی', 'seokar'),
            'footer'  => __('منوی فوتر', 'seokar')
        ]);
    }

    // **۴. ثبت سایدبارهای سفارشی**
    public function register_sidebars() {
        register_sidebar([
            'name'          => __('سایدبار اصلی', 'seokar'),
            'id'            => 'main_sidebar',
            'description'   => __('ابزارک‌های سایدبار اصلی', 'seokar'),
            'before_widget' => '<div class="widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
    }

    // **۵. بارگذاری استایل‌ها و اسکریپت‌های قالب**
    public function load_theme_assets() {
        wp_enqueue_style('seokar-main-style', get_stylesheet_uri(), [], '1.0.0');
        wp_enqueue_script('seokar-main-script', get_template_directory_uri() . '/assets/js/scripts.js', ['jquery'], '1.0.0', true);
    }
}

// **۶. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
new Seokar_Setup();
