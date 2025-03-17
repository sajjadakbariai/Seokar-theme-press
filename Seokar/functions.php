function seokar_enqueue_styles() {
    wp_enqueue_style('seokar-style', get_template_directory_uri() . '/assets/css/style.css');
    
    // پشتیبانی از زبان‌های راست‌چین
    if (is_rtl()) {
        wp_enqueue_style('seokar-rtl', get_template_directory_uri() . '/assets/css/rtl.css');
    }
}
add_action('wp_enqueue_scripts', 'seokar_enqueue_styles');
