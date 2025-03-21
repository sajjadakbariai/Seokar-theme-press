<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_Custom_Taxonomies {

    public function __construct() {
        add_action('init', [$this, 'register_taxonomies']);
    }

    /**
     * **۱. ثبت طبقه‌بندی‌های سفارشی**
     */
    public function register_taxonomies() {
        $this->register_custom_category();
        $this->register_custom_tags();
    }

    /**
     * **۲. ثبت دسته‌بندی سفارشی (`custom_category`)**
     */
    private function register_custom_category() {
        $labels = [
            'name'              => __('دسته‌بندی سفارشی', 'seokar'),
            'singular_name'     => __('دسته‌بندی', 'seokar'),
            'search_items'      => __('جستجوی دسته‌ها', 'seokar'),
            'all_items'         => __('همه دسته‌ها', 'seokar'),
            'parent_item'       => __('دسته والد', 'seokar'),
            'parent_item_colon' => __('دسته والد:', 'seokar'),
            'edit_item'         => __('ویرایش دسته', 'seokar'),
            'update_item'       => __('به‌روزرسانی دسته', 'seokar'),
            'add_new_item'      => __('افزودن دسته جدید', 'seokar'),
            'new_item_name'     => __('نام دسته جدید', 'seokar'),
            'menu_name'         => __('دسته‌بندی سفارشی', 'seokar'),
        ];

        $args = [
            'labels'            => $labels,
            'hierarchical'      => true, // تنظیم به `true` یعنی این یک دسته‌بندی است
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'custom-category'],
            'show_in_rest'      => true, // پشتیبانی از `Gutenberg` و `REST API`
        ];

        register_taxonomy('custom_category', ['post', 'custom_post_type'], $args);
    }

    /**
     * **۳. ثبت برچسب سفارشی (`custom_tags`)**
     */
    private function register_custom_tags() {
        $labels = [
            'name'              => __('برچسب‌های سفارشی', 'seokar'),
            'singular_name'     => __('برچسب', 'seokar'),
            'search_items'      => __('جستجوی برچسب‌ها', 'seokar'),
            'popular_items'     => __('برچسب‌های محبوب', 'seokar'),
            'all_items'         => __('همه برچسب‌ها', 'seokar'),
            'edit_item'         => __('ویرایش برچسب', 'seokar'),
            'update_item'       => __('به‌روزرسانی برچسب', 'seokar'),
            'add_new_item'      => __('افزودن برچسب جدید', 'seokar'),
            'new_item_name'     => __('نام برچسب جدید', 'seokar'),
            'separate_items_with_commas' => __('برچسب‌ها را با ویرگول جدا کنید', 'seokar'),
            'menu_name'         => __('برچسب‌های سفارشی', 'seokar'),
        ];

        $args = [
            'labels'            => $labels,
            'hierarchical'      => false, // `false` یعنی این یک `Tag` است نه `Category`
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'custom-tag'],
            'show_in_rest'      => true, // پشتیبانی از `Gutenberg` و `REST API`
        ];

        register_taxonomy('custom_tags', ['post', 'custom_post_type'], $args);
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
new Seokar_Custom_Taxonomies();
