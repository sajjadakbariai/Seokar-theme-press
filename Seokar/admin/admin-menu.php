<?php
if (!defined('ABSPATH')) exit; // امنیت: جلوگیری از دسترسی مستقیم

class Seokar_Admin_Menu {

    // **۱. مقداردهی اولیه کلاس**
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    // **۲. ایجاد منوی اختصاصی در داشبورد وردپرس**
    public function add_admin_menu() {
        add_menu_page(
            'تنظیمات قالب سئوکار',  // عنوان صفحه
            'تنظیمات سئوکار',       // عنوان منو
            'manage_options',       // سطح دسترسی
            'seokar-settings',      // slug صفحه
            array($this, 'settings_page'), // تابع نمایش صفحه تنظیمات
            'dashicons-admin-generic', // آیکون منو
            59                         // موقعیت در منوی وردپرس
        );

        add_submenu_page(
            'seokar-settings',
            'تنظیمات عمومی',
            'تنظیمات عمومی',
            'manage_options',
            'seokar-general-settings',
            array($this, 'settings_page')
        );

        add_submenu_page(
            'seokar-settings',
            'تنظیمات سئو',
            'تنظیمات سئو',
            'manage_options',
            'seokar-seo-settings',
            array($this, 'seo_settings_page')
        );
    }

    // **۳. ثبت تنظیمات قالب در دیتابیس**
    public function register_settings() {
        register_setting('seokar_settings_group', 'seokar_primary_color');
        register_setting('seokar_settings_group', 'seokar_logo');
        register_setting('seokar_settings_group', 'seokar_meta_description');
    }

    // **۴. صفحه تنظیمات عمومی قالب**
    public function settings_page() {
        ?>
        <div class="wrap">
            <h1>تنظیمات عمومی قالب سئوکار</h1>
            <form method="post" action="options.php">
                <?php settings_fields('seokar_settings_group'); ?>
                <?php do_settings_sections('seokar_settings_group'); ?>
                <table class="form-table">
                    <tr>
                        <th><label for="seokar_primary_color">رنگ اصلی قالب</label></th>
                        <td><input type="color" name="seokar_primary_color" value="<?php echo esc_attr(get_option('seokar_primary_color', '#0073e6')); ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="seokar_logo">لوگوی سایت</label></th>
                        <td>
                            <input type="text" name="seokar_logo" value="<?php echo esc_url(get_option('seokar_logo')); ?>">
                            <p class="description">لینک مستقیم تصویر لوگو را وارد کنید.</p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    // **۵. صفحه تنظیمات سئو**
    public function seo_settings_page() {
        ?>
        <div class="wrap">
            <h1>تنظیمات سئو قالب سئوکار</h1>
            <form method="post" action="options.php">
                <?php settings_fields('seokar_settings_group'); ?>
                <?php do_settings_sections('seokar_settings_group'); ?>
                <table class="form-table">
                    <tr>
                        <th><label for="seokar_meta_description">توضیحات متا</label></th>
                        <td>
                            <textarea name="seokar_meta_description" rows="4"><?php echo esc_textarea(get_option('seokar_meta_description', '')); ?></textarea>
                            <p class="description">توضیحات متا که در نتایج گوگل نمایش داده می‌شود.</p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}

// **۶. مقداردهی اولیه کلاس**
new Seokar_Admin_Menu();
