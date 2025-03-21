// **۱. بررسی فعال بودن وردپرس چندسایته**
function seokar_check_multisite() {
    if (is_multisite()) {
        error_log("قالب سئوکار روی وردپرس چندسایته فعال شده است.");
    }
}
add_action('init', 'seokar_check_multisite');

// **۲. ایجاد تنظیمات سفارشی برای هر سایت**
function seokar_multisite_options() {
    if (!is_multisite()) {
        return;
    }

    add_site_option('seokar_network_primary_color', '#0073e6');
}
add_action('init', 'seokar_multisite_options');

// **۳. افزودن صفحه تنظیمات قالب در سطح شبکه**
function seokar_add_network_menu() {
    if (!is_multisite() || !is_network_admin()) {
        return;
    }

    add_menu_page(
        'تنظیمات قالب شبکه',
        'تنظیمات قالب',
        'manage_network_options',
        'seokar-network-settings',
        'seokar_network_settings_page',
        'dashicons-admin-network',
        99
    );
}
add_action('network_admin_menu', 'seokar_add_network_menu');

function seokar_network_settings_page() {
    if (isset($_POST['seokar_network_primary_color'])) {
        update_site_option('seokar_network_primary_color', sanitize_hex_color($_POST['seokar_network_primary_color']));
        echo '<div class="updated"><p>تنظیمات ذخیره شد!</p></div>';
    }

    $primary_color = get_site_option('seokar_network_primary_color', '#0073e6');
    ?>
    <div class="wrap">
        <h1>تنظیمات قالب در سطح شبکه</h1>
        <form method="post">
            <label for="seokar_network_primary_color">رنگ اصلی:</label>
            <input type="color" id="seokar_network_primary_color" name="seokar_network_primary_color" value="<?php echo esc_attr($primary_color); ?>">
            <button type="submit" class="button button-primary">ذخیره تنظیمات</button>
        </form>
    </div>
    <?php
}

// **۴. دریافت مقدار تنظیمات برای هر سایت**
function seokar_get_multisite_option($option_name, $default = '') {
    if (is_multisite()) {
        return get_site_option($option_name, $default);
    }
    return get_option($option_name, $default);
}
