class Seokar_Theme_Setup {
    
    // **۱. مقداردهی اولیه کلاس**
    public function __construct() {
        add_action('after_setup_theme', array($this, 'theme_features'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
    }

    // **۲. فعال‌سازی ویژگی‌های قالب**
    public function theme_features() {
        add_theme_support('post-thumbnails'); // تصویر شاخص
        add_theme_support('title-tag'); // مدیریت عنوان صفحه
        add_theme_support('custom-logo'); // پشتیبانی از لوگوی سفارشی
        add_theme_support('woocommerce'); // پشتیبانی از ووکامرس

        register_nav_menus(array(
            'primary' => 'منوی اصلی',
            'footer'  => 'منوی فوتر',
        ));
    }

    // **۳. بارگذاری استایل‌ها و اسکریپت‌های قالب**
    public function enqueue_assets() {
        wp_enqueue_style('seokar-style', get_stylesheet_uri());
        wp_enqueue_script('seokar-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true);
    }
}

// **۴. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
new Seokar_Theme_Setup();
