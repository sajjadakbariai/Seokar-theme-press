// **۱. کش کردن کوئری‌های پرمصرف**
function seokar_cache_query($query_key, $callback, $expiration = 3600) {
    $cached_data = get_transient($query_key);
    if ($cached_data === false) {
        $cached_data = call_user_func($callback);
        set_transient($query_key, $cached_data, $expiration);
    }
    return $cached_data;
}

// **۲. نمونه استفاده: کش کردن لیست آخرین مطالب**
function seokar_get_cached_latest_posts() {
    return seokar_cache_query('seokar_latest_posts', function () {
        return get_posts(array('numberposts' => 5, 'post_status' => 'publish'));
    }, 1800);
}

// **۳. نمایش لیست آخرین مطالب با کش**
function seokar_display_latest_posts() {
    $posts = seokar_get_cached_latest_posts();
    echo '<ul>';
    foreach ($posts as $post) {
        echo '<li><a href="' . get_permalink($post->ID) . '">' . esc_html($post->post_title) . '</a></li>';
    }
    echo '</ul>';
}

// **۴. کش کردن خروجی ویجت‌های وردپرس**
function seokar_cache_widget_output($widget_id, $callback, $expiration = 3600) {
    $cached_widget = get_transient("widget_cache_$widget_id");
    if ($cached_widget === false) {
        ob_start();
        call_user_func($callback);
        $cached_widget = ob_get_clean();
        set_transient("widget_cache_$widget_id", $cached_widget, $expiration);
    }
    echo $cached_widget;
}

// **۵. حذف کش زمانی که پست جدید منتشر می‌شود**
function seokar_clear_cache_on_post_save($post_id) {
    if (wp_is_post_revision($post_id)) return;
    delete_transient('seokar_latest_posts');
}
add_action('save_post', 'seokar_clear_cache_on_post_save');

// **۶. حذف کش زمانی که ویجت‌ها بروزرسانی می‌شوند**
function seokar_clear_widget_cache() {
    global $wpdb;
    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_widget_cache_%'");
}
add_action('widgets_update', 'seokar_clear_widget_cache');
