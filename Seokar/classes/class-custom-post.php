class Seokar_Custom_Post {
    
    // **۱. مقداردهی اولیه کلاس**
    public function __construct() {
        add_action('init', array($this, 'register_portfolio_post_type'));
    }

    // **۲. ثبت پست تایپ سفارشی "نمونه کارها"**
    public function register_portfolio_post_type() {
        $labels = array(
            'name'               => 'نمونه کارها',
            'singular_name'      => 'نمونه کار',
            'menu_name'          => 'نمونه کارها',
            'name_admin_bar'     => 'نمونه کار جدید',
            'add_new'            => 'افزودن جدید',
            'add_new_item'       => 'افزودن نمونه کار جدید',
            'edit_item'          => 'ویرایش نمونه کار',
            'new_item'           => 'نمونه کار جدید',
            'view_item'          => 'مشاهده نمونه کار',
            'search_items'       => 'جستجوی نمونه کار',
            'not_found'          => 'موردی یافت نشد',
            'not_found_in_trash' => 'در زباله‌دان یافت نشد',
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'rewrite'            => array('slug' => 'portfolio'),
            'menu_icon'          => 'dashicons-portfolio',
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'taxonomies'         => array('category', 'post_tag'),
            'show_in_rest'       => true, // برای پشتیبانی از گوتنبرگ و REST API
        );

        register_post_type('portfolio', $args);
    }
}

// **۳. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
new Seokar_Custom_Post();
