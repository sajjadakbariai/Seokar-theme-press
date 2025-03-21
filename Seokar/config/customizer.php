function seokar_customize_register($wp_customize) {
    // **۱. بخش تنظیمات عمومی**
    $wp_customize->add_section('seokar_general_settings', array(
        'title'    => 'تنظیمات عمومی قالب',
        'priority' => 30,
    ));

    // **۲. گزینه تغییر رنگ اصلی قالب**
    $wp_customize->add_setting('seokar_primary_color', array(
        'default'           => '#0073e6',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'seokar_primary_color', array(
        'label'    => 'رنگ اصلی سایت',
        'section'  => 'seokar_general_settings',
        'settings' => 'seokar_primary_color',
    )));

    // **۳. آپلود لوگوی سایت**
    $wp_customize->add_setting('seokar_logo', array(
        'default'           => '',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'seokar_logo', array(
        'label'    => 'لوگوی سایت',
        'section'  => 'seokar_general_settings',
        'settings' => 'seokar_logo',
    )));

    // **۴. فعال/غیرفعال کردن دکمه "بازگشت به بالا"**
    $wp_customize->add_setting('seokar_show_back_to_top', array(
        'default'           => true,
        'transport'         => 'refresh',
        'sanitize_callback' => 'seokar_sanitize_checkbox',
    ));
    $wp_customize->add_control('seokar_show_back_to_top', array(
        'type'    => 'checkbox',
        'label'   => 'نمایش دکمه بازگشت به بالا',
        'section' => 'seokar_general_settings',
    ));
}
add_action('customize_register', 'seokar_customize_register');

// **۵. تابع برای دریافت مقدار تنظیمات قالب**
function seokar_get_theme_option($option_name, $default = '') {
    return get_theme_mod($option_name, $default);
}

// **۶. تابع بررسی مقدار چک‌باکس**
function seokar_sanitize_checkbox($checked) {
    return isset($checked) && $checked === true ? true : false;
}
