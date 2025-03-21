<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_Custom_Post_Types {

    public function __construct() {
        add_action('init', [$this, 'register_custom_post_types']);
    }

    /**
     * **۱. ثبت پست تایپ‌های سفارشی**
     */
    public function register_custom_post_types() {
        $this->register_portfolio_cpt();
        $this->register_testimonials_cpt();
    }

    /**
     * **۲. ثبت `CPT` نمونه برای پروژه‌ها (`Portfolio`)**
     */
    private function register_portfolio_cpt() {
        $labels = [
            'name'          => __('نمونه کارها', 'seokar'),
            'singular_name' => __('نمونه کار', 'seokar'),
            'menu_name'     => __('نمونه کارها', 'seokar'),
            'add_new'       => __('افزودن نمونه کار جدید', 'seokar'),
            'add_new_item'  => __('افزودن نمونه کار', 'seokar'),
            'edit_item'     => __('ویرایش نمونه کار', 'seokar'),
            'new_item'      => __('نمونه کار جدید', 'seokar'),
            'view_item'     => __('مشاهده نمونه کار', 'seokar'),
            'all_items'     => __('همه نمونه کارها', 'seokar'),
            'search_items'  => __('جستجوی نمونه کار', 'seokar'),
            'not_found'     => __('هیچ نمونه کاری یافت نشد', 'seokar'),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'menu_icon'          => 'dashicons-portfolio',
            'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
            'has_archive'        => true,
            'rewrite'            => ['slug' => 'portfolio'],
            'show_in_rest'       => true, // پشتیبانی از ویرایشگر گوتنبرگ
        ];

        register_post_type('portfolio', $args);
    }

    /**
     * **۳. ثبت `CPT` برای نظرات مشتریان (`Testimonials`)**
     */
    private function register_testimonials_cpt() {
        $labels = [
            'name'          => __('نظرات مشتریان', 'seokar'),
            'singular_name' => __('نظر مشتری', 'seokar'),
            'menu_name'     => __('نظرات مشتریان', 'seokar'),
            'add_new'       => __('افزودن نظر جدید', 'seokar'),
            'add_new_item'  => __('افزودن نظر مشتری', 'seokar'),
            'edit_item'     => __('ویرایش نظر', 'seokar'),
            'new_item'      => __('نظر جدید', 'seokar'),
            'view_item'     => __('مشاهده نظر', 'seokar'),
            'all_items'     => __('همه نظرات مشتریان', 'seokar'),
            'search_items'  => __('جستجوی نظرات', 'seokar'),
            'not_found'     => __('هیچ نظری یافت نشد', 'seokar'),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'menu_icon'          => 'dashicons-testimonial',
            'supports'           => ['title', 'editor', 'thumbnail'],
            'has_archive'        => false,
            'rewrite'            => ['slug' => 'testimonials'],
            'show_in_rest'       => true, // پشتیبانی از ویرایشگر گوتنبرگ
        ];

        register_post_type('testimonials', $args);
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
new Seokar_Custom_Post_Types();
