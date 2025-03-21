<?php
if (!defined('ABSPATH')) exit; // امنیت: جلوگیری از دسترسی مستقیم

class Seokar_AMP_Support {

    // **۱. مقداردهی اولیه کلاس**
    public function __construct() {
        add_action('after_setup_theme', array($this, 'enable_amp_support'));
        add_filter('template_include', array($this, 'load_amp_template'));
        add_action('wp_enqueue_scripts', array($this, 'remove_unnecessary_assets'), 99);
        add_filter('amp_post_template_data', array($this, 'modify_amp_template_data'));
    }

    // **۲. فعال‌سازی پشتیبانی از AMP در وردپرس**
    public function enable_amp_support() {
        add_theme_support('amp'); // فعال کردن پشتیبانی از AMP در قالب
    }

    // **۳. تغییر مسیر قالب AMP برای نمایش صفحات AMP اختصاصی**
    public function load_amp_template($template) {
        if (function_exists('is_amp_endpoint') && is_amp_endpoint()) {
            $amp_template = get_template_directory() . '/amp/amp-template.php';
            if (file_exists($amp_template)) {
                return $amp_template;
            }
        }
        return $template;
    }

    // **۴. حذف استایل‌ها و اسکریپت‌های غیرضروری برای AMP**
    public function remove_unnecessary_assets() {
        if (function_exists('is_amp_endpoint') && is_amp_endpoint()) {
            wp_dequeue_script('jquery'); // حذف جی‌کوئری
            wp_dequeue_style('seokar-main-style'); // حذف استایل اصلی (اگر نیاز نباشه)
        }
    }

    // **۵. ویرایش داده‌های قالب در نسخه AMP**
    public function modify_amp_template_data($data) {
        $data['site_name'] = get_bloginfo('name') . ' (AMP)';
        return $data;
    }
}

// **۶. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
new Seokar_AMP_Support();
