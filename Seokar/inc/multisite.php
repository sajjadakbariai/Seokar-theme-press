<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_Multisite {

    public function __construct() {
        add_action('init', [$this, 'check_multisite']);
        add_action('init', [$this, 'initialize_network_options']);
        add_action('network_admin_menu', [$this, 'add_network_settings_menu']);
    }

    // **۱. بررسی فعال بودن وردپرس چندسایته و ثبت در `error_log`**
    public function check_multisite() {
        if (is_multisite()) {
            error_log("🚀 قالب سئوکار روی وردپرس چندسایته فعال شده است.");
        }
    }

    // **۲. ایجاد و مقداردهی اولیه تنظیمات شبکه در صورت عدم وجود**
    public function initialize_network_options() {
        if (!is_multisite()) {
            return;
        }

        if (false === get_site_option('seokar_network_primary_color')) {
            add_site_option('seokar_network_primary_color', '#0073e6');
        }
    }

    // **۳. افزودن صفحه تنظیمات قالب در سطح شبکه**
    public function add_network_settings_menu() {
        if (!is_multisite() || !is_network_admin()) {
            return;
        }

        add_menu_page(
            'تنظیمات قالب شبکه',
            'تنظیمات قالب شبکه',
            'manage_network_options',
            'seokar-network-settings',
            [$this, 'network_settings_page'],
            'dashicons-admin-network',
            99
        );
    }

    // **۴. نمایش صفحه تنظیمات در پنل مدیریت شبکه**
    public function network_settings_page() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['seokar_network_primary_color'])) {
            check_admin_referer('seokar_network_settings');

            update_site_option('seokar_network_primary_color', sanitize_hex_color($_POST['seokar_network_primary_color']));
            echo '<div class="updated"><p>✅ تنظیمات ذخیره شد!</p></div>';
        }

        $primary_color = get_site_option('seokar_network_primary_color', '#0073e6');
        ?>
        <div class="wrap">
            <h1>تنظیمات قالب در سطح شبکه</h1>
            <form method="post">
                <?php wp_nonce_field('seokar_network_settings'); ?>
                <table class="form-table">
                    <tr>
                        <th><label for="seokar_network_primary_color">🎨 رنگ اصلی:</label></th>
                        <td><input type="color" id="seokar_network_primary_color" name="seokar_network_primary_color" value="<?php echo esc_attr($primary_color); ?>"></td>
                    </tr>
                </table>
                <button type="submit" class="button button-primary">💾 ذخیره تنظیمات</button>
            </form>
        </div>
        <?php
    }

    // **۵. دریافت مقدار تنظیمات برای هر سایت در شبکه**
    public static function get_multisite_option($option_name, $default = '') {
        return is_multisite() ? get_site_option($option_name, $default) : get_option($option_name, $default);
    }
}

// **۶. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
new Seokar_Multisite();
