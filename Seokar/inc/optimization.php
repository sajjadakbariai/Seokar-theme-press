<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_Optimization {

    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'remove_block_library_css'], 100);
        add_action('init', [$this, 'disable_emojis']);
        add_filter('script_loader_src', [$this, 'remove_query_strings'], 15);
        add_filter('style_loader_src', [$this, 'remove_query_strings'], 15);
        add_action('init', [$this, 'enable_gzip']);
        add_action('init', [$this, 'limit_post_revisions']);
        add_action('wp_loaded', [$this, 'schedule_database_optimization']);
        add_action('seokar_db_optimization_event', [$this, 'optimize_database']);
        add_filter('the_content', [$this, 'lazyload_images']);
        add_action('wp_footer', [$this, 'defer_parsing_of_js'], 100);
        add_action('template_redirect', [$this, 'disable_heartbeat']);
        add_filter('wp_resource_hints', [$this, 'remove_dns_prefetch'], 10, 2);
    }

    // **۱. حذف استایل‌های بلاک ادیتور از فرانت‌اند برای کاهش درخواست‌های HTTP**
    public function remove_block_library_css() {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
    }

    // **۲. غیرفعال کردن ایموجی‌های وردپرس برای کاهش حجم فایل‌های اضافی**
    public function disable_emojis() {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
    }

    // **۳. حذف Query Strings از منابع استاتیک برای بهبود کش مرورگر**
    public function remove_query_strings($src) {
        return strpos($src, '?ver=') !== false ? remove_query_arg('ver', $src) : $src;
    }

    // **۴. فعال کردن Gzip برای فشرده‌سازی خروجی و افزایش سرعت بارگذاری**
    public function enable_gzip() {
        if (!ob_start("ob_gzhandler")) {
            ob_start();
        }
    }

    // **۵. محدود کردن تعداد رونوشت‌های ذخیره‌شده برای کاهش حجم دیتابیس**
    public function limit_post_revisions() {
        if (!defined('WP_POST_REVISIONS')) {
            define('WP_POST_REVISIONS', 5);
        }
    }

    // **۶. ایجاد زمان‌بندی برای بهینه‌سازی پایگاه داده**
    public function schedule_database_optimization() {
        if (!wp_next_scheduled('seokar_db_optimization_event')) {
            wp_schedule_event(time(), 'weekly', 'seokar_db_optimization_event');
        }
    }

    // **۷. پاک‌سازی و بهینه‌سازی پایگاه داده برای افزایش سرعت سایت**
    public function optimize_database() {
        global $wpdb;
        $tables = ['posts', 'postmeta', 'comments', 'commentmeta', 'options'];
        foreach ($tables as $table) {
            $wpdb->query("OPTIMIZE TABLE {$wpdb->prefix}$table");
        }
    }

    // **۸. لود تنبل تصاویر (Lazy Load) برای کاهش زمان بارگذاری صفحه**
    public function lazyload_images($content) {
        if (!is_admin()) {
            $content = preg_replace('/<img(.*?)src=/', '<img$1loading="lazy" src=', $content);
        }
        return $content;
    }

    // **۹. تاخیر در بارگذاری فایل‌های جاوااسکریپت برای بهینه‌سازی لود صفحه**
    public function defer_parsing_of_js() {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    let scripts = document.querySelectorAll('script');
                    scripts.forEach(script => {
                        if (!script.defer && !script.async) {
                            script.setAttribute('defer', 'defer');
                        }
                    });
                });
              </script>";
    }

    // **۱۰. غیرفعال کردن Heartbeat API برای کاهش مصرف منابع سرور**
    public function disable_heartbeat() {
        wp_deregister_script('heartbeat');
    }

    // **۱۱. حذف `DNS Prefetch` غیرضروری برای افزایش سرعت بارگذاری**
    public function remove_dns_prefetch($hints, $relation_type) {
        if ('dns-prefetch' === $relation_type) {
            return array_diff($hints, ['//s.w.org']);
        }
        return $hints;
    }
}

// **۱۲. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
new Seokar_Optimization();
