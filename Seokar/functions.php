function seokar_enqueue_styles() {
    // بارگذاری استایل اصلی
    wp_enqueue_style('seokar-style', get_template_directory_uri() . '/assets/css/style.css', [], '1.0.0');

    // بارگذاری استایل RTL فقط برای زبان‌های راست‌چین
    if (is_rtl()) {
        wp_enqueue_style('seokar-rtl', get_template_directory_uri() . '/assets/css/rtl.css', ['seokar-style'], '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'seokar_enqueue_styles');
