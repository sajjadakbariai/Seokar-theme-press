// **۱. افزودن گزینه‌های تنظیمات به پنل سفارشی‌سازی**
function seokar_customize_register($wp_customize) {
    // **بخش تنظیمات عمومی**
    $wp_customize->add_section('seokar_general_settings', array(
        'title'    => 'تنظیمات عمومی قالب',
        'priority' => 30,
    ));

    // **۱. تنظیمات لوگو**
    $wp_customize->add_setting('seokar_logo', array(
        'default'   => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'seokar_logo', array(
        'label'    => 'لوگوی سایت',
        'section'  => 'seokar_general_settings',
        'settings' => 'seokar_logo',
    )));

    // **۲. رنگ اصلی سایت**
    $wp_customize->add_setting('seokar_primary_color', array(
        'default'   => '#0073e6',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'seokar_primary_color', array(
        'label'    => 'رنگ اصلی سایت',
        'section'  => 'seokar_general_settings',
        'settings' => 'seokar_primary_color',
    )));

    // **۳. نمایش یا مخفی کردن دکمه بازگشت به بالا**
    $wp_customize->add_setting('seokar_show_back_to_top', array(
        'default'   => true,
        'transport' => 'refresh',
        'sanitize_callback' => 'seokar_sanitize_checkbox'
    ));
    $wp_customize->add_control('seokar_show_back_to_top', array(
        'type'    => 'checkbox',
        'label'   => 'نمایش دکمه بازگشت به بالا',
        'section' => 'seokar_general_settings',
    ));
}
add_action('customize_register', 'seokar_customize_register');

// **۲. تابع بهینه‌سازی مقدارهای چک‌باکس**
function seokar_sanitize_checkbox($checked) {
    return (isset($checked) && $checked == true) ? true : false;
}

// **۳. خروجی مقدارهای تنظیمات در قالب**
function seokar_get_option($option_name, $default = '') {
    return get_theme_mod($option_name, $default);
}
