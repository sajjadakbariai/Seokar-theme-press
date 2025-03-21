<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_Caching {

    public function __construct() {
        add_action('save_post', [$this, 'clear_cache_on_post_save']);
        add_action('widgets_update', [$this, 'clear_widget_cache']);
    }

    /**
     * **۱. کش کردن کوئری‌های پرمصرف**
     *
     * @param string   $query_key کلید کش.
     * @param callable $callback تابعی که داده‌ها را تولید می‌کند.
     * @param int      $expiration مدت زمان کش (پیش‌فرض: ۱ ساعت).
     * @return mixed داده کش شده یا مقدار جدید.
     */
    public static function cache_query($query_key, $callback, $expiration = 3600) {
        $cached_data = get_transient($query_key);
        if ($cached_data === false) {
            $cached_data = call_user_func($callback);
            set_transient($query_key, $cached_data, $expiration);
        }
        return $cached_data;
    }

    /**
     * **۲. کش کردن لیست آخرین مطالب**
     *
     * @return array لیستی از آخرین پست‌های کش شده.
     */
    public static function get_cached_latest_posts() {
        return self::cache_query('seokar_latest_posts', function () {
            return get_posts(['numberposts' => 5, 'post_status' => 'publish']);
        }, 1800);
    }

    /**
     * **۳. نمایش لیست آخرین مطالب با کش**
     */
    public static function display_latest_posts() {
        $posts = self::get_cached_latest_posts();
        echo '<ul>';
        foreach ($posts as $post) {
            echo '<li><a href="' . get_permalink($post->ID) . '">' . esc_html($post->post_title) . '</a></li>';
        }
        echo '</ul>';
    }

    /**
     * **۴. کش کردن خروجی ویجت‌ها**
     *
     * @param string   $widget_id شناسه ویجت.
     * @param callable $callback تابعی که خروجی ویجت را تولید می‌کند.
     * @param int      $expiration مدت زمان کش (پیش‌فرض: ۱ ساعت).
     */
    public static function cache_widget_output($widget_id, $callback, $expiration = 3600) {
        $cached_widget = get_transient("widget_cache_$widget_id");
        if ($cached_widget === false) {
            ob_start();
            call_user_func($callback);
            $cached_widget = ob_get_clean();
            set_transient("widget_cache_$widget_id", $cached_widget, $expiration);
        }
        echo $cached_widget;
    }

    /**
     * **۵. حذف کش زمانی که پست جدید منتشر یا ویرایش می‌شود**
     *
     * @param int $post_id شناسه پست.
     */
    public function clear_cache_on_post_save($post_id) {
        if (wp_is_post_revision($post_id)) return;
        delete_transient('seokar_latest_posts');
    }

    /**
     * **۶. حذف کش ویجت‌ها هنگام بروزرسانی**
     */
    public function clear_widget_cache() {
        global $wpdb;
        $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_widget_cache_%'");
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
new Seokar_Caching();
