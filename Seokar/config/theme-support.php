function seokar_theme_setup() {
    // **۱. فعال کردن تصویر شاخص (Featured Image)**
    add_theme_support('post-thumbnails');

    // **۲. ثبت منوهای سفارشی**
    register_nav_menus(array(
        'primary' => 'منوی اصلی',
        'footer'  => 'منوی فوتر',
    ));

    // **۳. فعال کردن پشتیبانی از ووکامرس**
    add_theme_support('woocommerce');

    // **۴. فعال کردن قالب‌بندی نوشته‌ها (Post Formats)**
    add_theme_support('post-formats', array('aside', 'gallery', 'video', 'quote', 'link'));

    // **۵. پشتیبانی از ویرایشگر گوتنبرگ (Block Editor)**
    add_theme_support('editor-styles');
    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');

    // **۶. پشتیبانی از لوگوی سفارشی**
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // **۷. فعال کردن پشتیبانی از هدر و بک‌گراند سفارشی**
    add_theme_support('custom-header');
    add_theme_support('custom-background');
}
add_action('after_setup_theme', 'seokar_theme_setup');
