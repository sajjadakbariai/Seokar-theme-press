// ایجاد صفحه تنظیمات قالب
function seokar_add_theme_menu() {
    add_menu_page(
        'تنظیمات سئوکار',
        'تنظیمات قالب',
        'manage_options',
        'seokar-theme-options',
        'seokar_theme_options_page',
        'dashicons-admin-generic',
        50
    );
}
add_action('admin_menu', 'seokar_add_theme_menu');

// **نمایش صفحه تنظیمات قالب**
function seokar_theme_options_page() {
?>
    <div class="wrap">
        <h1>تنظیمات قالب سئوکار</h1>
        <form id="seokar-settings-form">
            <label for="seokar-primary-color">رنگ اصلی:</label>
            <input type="color" id="seokar-primary-color" name="seokar_primary_color" value="<?php echo get_option('seokar_primary_color', '#0073e6'); ?>">
            
            <div id="seokar-preview" style="width: 100px; height: 50px; background: <?php echo get_option('seokar_primary_color', '#0073e6'); ?>;"></div>
            
            <button id="seokar-save-settings" class="button button-primary">ذخیره تنظیمات</button>
        </form>
    </div>
<?php
}

// **پردازش ذخیره تنظیمات قالب با AJAX**
function seokar_save_theme_options() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'دسترسی غیرمجاز']);
    }

    check_ajax_referer('seokar_admin_nonce', 'security');

    if (isset($_POST['seokar_primary_color'])) {
        update_option('seokar_primary_color', sanitize_hex_color($_POST['seokar_primary_color']));
    }

    wp_send_json_success(['message' => 'تنظیمات ذخیره شد!']);
}
add_action('wp_ajax_seokar_save_theme_options', 'seokar_save_theme_options');
