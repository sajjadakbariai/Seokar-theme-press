<?php
if (!defined('ABSPATH')) exit; // امنیت: جلوگیری از دسترسی مستقیم

class Seokar_Theme_Options {

    // **۱. مقداردهی اولیه تنظیمات هنگام راه‌اندازی قالب**
    public function __construct() {
        add_action('customize_register', [$this, 'customize_register']);
    }

    // **۲. تعریف تنظیمات در پنل سفارشی‌سازی وردپرس**
    public function customize_register($wp_customize) {
        // **بخش تنظیمات عمومی**
        $wp_customize->add_section('seokar_general_settings', [
            'title'    => 'تنظیمات عمومی قالب',
            'priority' => 30,
        ]);

        // **۱. تنظیمات لوگو**
        $wp_customize->add_setting('seokar_logo', [
            'default'   => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'esc_url_raw'
        ]);
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'seokar_logo', [
            'label'    => 'لوگوی سایت',
            'section'  => 'seokar_general_settings',
            'settings' => 'seokar_logo',
        ]));

        // **۲. رنگ اصلی سایت**
        $wp_customize->add_setting('seokar_primary_color', [
            'default'   => '#0073e6',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color'
        ]);
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'seokar_primary_color', [
            'label'    => 'رنگ اصلی سایت',
            'section'  => 'seokar_general_settings',
            'settings' => 'seokar_primary_color',
        ]));

        // **۳. نمایش یا مخفی کردن دکمه بازگشت به بالا**
        $wp_customize->add_setting('seokar_show_back_to_top', [
            'default'   => true,
            'transport' => 'refresh',
            'sanitize_callback' => [$this, 'sanitize_checkbox']
        ]);
        $wp_customize->add_control('seokar_show_back_to_top', [
            'type'    => 'checkbox',
            'label'   => 'نمایش دکمه بازگشت به بالا',
            'section' => 'seokar_general_settings',
        ]);

        // **۴. افزودن فیلد متن برای کپی‌رایت فوتر**
        $wp_customize->add_setting('seokar_footer_text', [
            'default'   => 'تمامی حقوق محفوظ است.',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control('seokar_footer_text', [
            'type'    => 'text',
            'label'   => 'متن کپی‌رایت فوتر',
            'section' => 'seokar_general_settings',
        ]);
    }

    // **۳. تابع بهینه‌سازی مقدارهای چک‌باکس**
    public function sanitize_checkbox($checked) {
        return (isset($checked) && $checked == true) ? true : false;
    }

    // **۴. خروجی مقدارهای تنظیمات در قالب**
    public static function get_option($option_name, $default = '') {
        return get_theme_mod($option_name, $default);
    }
}

// **۵. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
new Seokar_Theme_Options();
