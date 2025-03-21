<?php
if (!defined('ABSPATH')) exit; // امنیت: جلوگیری از دسترسی مستقیم

class Seokar_Admin_Settings {

    // **۱. مقداردهی اولیه کلاس**
    public function __construct() {
        add_action('admin_menu', array($this, 'add_theme_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_ajax_seokar_save_theme_options', array($this, 'save_theme_options'));
    }

    // **۲. ایجاد منوی تنظیمات قالب در پنل مدیریت وردپرس**
    public function add_theme_menu() {
        add_menu_page(
            'تنظیمات سئوکار',
            'تنظیمات قالب',
            'manage_options',
            'seokar-theme-options',
            array($this, 'theme_options_page'),
            'dashicons-admin-generic',
            50
        );
    }

    // **۳. نمایش صفحه تنظیمات قالب**
    public function theme_options_page() {
        ?>
        <div class="wrap">
            <h1>تنظیمات قالب سئوکار</h1>
            <form id="seokar-settings-form">
                <table class="form-table">
                    <tr>
                        <th><label for="seokar-primary-color">🎨 رنگ اصلی:</label></th>
                        <td>
                            <input type="color" id="seokar-primary-color" name="seokar_primary_color" value="<?php echo esc_attr(get_option('seokar_primary_color', '#0073e6')); ?>">
                            <div id="seokar-preview" style="width: 100px; height: 50px; background: <?php echo esc_attr(get_option('seokar_primary_color', '#0073e6')); ?>; margin-top: 10px;"></div>
                        </td>
                    </tr>
                </table>
                <button id="seokar-save-settings" type="button" class="button button-primary">💾 ذخیره تنظیمات</button>
                <p class="description" id="seokar-save-message" style="display: none;"></p>
            </form>
        </div>
        <?php
    }

    // **۴. ذخیره تنظیمات قالب با AJAX**
    public function save_theme_options() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => '⛔ دسترسی غیرمجاز!']);
        }

        check_ajax_referer('seokar_admin_nonce', 'security');

        if (isset($_POST['seokar_primary_color'])) {
            update_option('seokar_primary_color', sanitize_hex_color($_POST['seokar_primary_color']));
        }

        wp_send_json_success(['message' => '✅ تنظیمات با موفقیت ذخیره شد!']);
    }

    // **۵. بارگذاری فایل‌های جاوااسکریپت و استایل برای مدیریت تنظیمات**
    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'toplevel_page_seokar-theme-options') return;

        wp_enqueue_script('seokar-admin-js', get_template_directory_uri() . '/admin/admin-settings.js', array('jquery'), '1.0.0', true);
        wp_localize_script('seokar-admin-js', 'seokar_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'security' => wp_create_nonce('seokar_admin_nonce'),
        ));
    }
}

// **۶. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
new Seokar_Admin_Settings();
