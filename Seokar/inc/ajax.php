<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_AJAX {

    public function __construct() {
        add_action('wp_ajax_seokar_load_more', [$this, 'load_more_posts']);
        add_action('wp_ajax_nopriv_seokar_load_more', [$this, 'load_more_posts']);

        add_action('wp_ajax_seokar_live_search', [$this, 'live_search']);
        add_action('wp_ajax_nopriv_seokar_live_search', [$this, 'live_search']);

        add_action('wp_ajax_seokar_contact_form', [$this, 'handle_contact_form']);
        add_action('wp_ajax_nopriv_seokar_contact_form', [$this, 'handle_contact_form']);

        add_action('wp_ajax_seokar_like_post', [$this, 'handle_like_post']);
        add_action('wp_ajax_nopriv_seokar_like_post', [$this, 'handle_like_post']);

        add_action('wp_ajax_seokar_quick_add_to_cart', [$this, 'quick_add_to_cart']);
        add_action('wp_ajax_nopriv_seokar_quick_add_to_cart', [$this, 'quick_add_to_cart']);
    }

    /**
     * **۱. بارگذاری بیشتر مطالب با AJAX**
     */
    public function load_more_posts() {
        check_ajax_referer('seokar_ajax_nonce', 'security');

        $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
        $query = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 5,
            'paged'          => $paged + 1,
        ]);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                echo '<div class="post-item"><a href="' . get_permalink() . '">' . get_the_title() . '</a></div>';
            }
            wp_reset_postdata();
        } else {
            echo 'no_more_posts';
        }

        wp_die();
    }

    /**
     * **۲. جستجوی زنده با AJAX**
     */
    public function live_search() {
        check_ajax_referer('seokar_ajax_nonce', 'security');

        $search_query = sanitize_text_field($_POST['search_query']);
        $query = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 5,
            's'              => $search_query,
        ]);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                echo '<div class="search-result"><a href="' . get_permalink() . '">' . get_the_title() . '</a></div>';
            }
            wp_reset_postdata();
        } else {
            echo '<div class="search-result">موردی یافت نشد.</div>';
        }

        wp_die();
    }

    /**
     * **۳. فرم تماس با AJAX**
     */
    public function handle_contact_form() {
        check_ajax_referer('seokar_ajax_nonce', 'security');

        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $message = sanitize_textarea_field($_POST['message']);

        if (!$name || !$email || !$message) {
            wp_send_json_error(['message' => 'لطفاً همه فیلدها را پر کنید.']);
        }

        wp_mail(get_option('admin_email'), "پیام از $name", $message, "From: $email");
        wp_send_json_success(['message' => 'پیام شما ارسال شد!']);
    }

    /**
     * **۴. لایک کردن پست با AJAX**
     */
    public function handle_like_post() {
        check_ajax_referer('seokar_ajax_nonce', 'security');

        $post_id = intval($_POST['post_id']);
        if (!$post_id) wp_send_json_error(['message' => 'خطای نامشخص']);

        $likes = get_post_meta($post_id, 'seokar_likes', true);
        $likes = $likes ? $likes + 1 : 1;
        update_post_meta($post_id, 'seokar_likes', $likes);

        wp_send_json_success(['likes' => $likes]);
    }

    /**
     * **۵. افزودن سریع محصول به سبد خرید (WooCommerce)**
     */
    public function quick_add_to_cart() {
        check_ajax_referer('seokar_ajax_nonce', 'security');

        $product_id = intval($_POST['product_id']);
        if ($product_id) {
            WC()->cart->add_to_cart($product_id);
            wp_send_json_success(['message' => 'محصول به سبد خرید اضافه شد!']);
        } else {
            wp_send_json_error(['message' => 'خطایی رخ داد.']);
        }
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
new Seokar_AJAX();
