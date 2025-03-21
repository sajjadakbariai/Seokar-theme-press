<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_REST_API {

    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    // **۱. ثبت APIهای سفارشی**
    public function register_routes() {
        register_rest_route('seokar/v1', '/latest-posts/', [
            'methods'  => 'GET',
            'callback' => [$this, 'get_latest_posts'],
            'permission_callback' => '__return_true'
        ]);

        register_rest_route('seokar/v1', '/contact/', [
            'methods'  => 'POST',
            'callback' => [$this, 'handle_contact_form'],
            'permission_callback' => '__return_true'
        ]);

        register_rest_route('seokar/v1', '/private-data/', [
            'methods'  => 'GET',
            'callback' => [$this, 'get_private_data'],
            'permission_callback' => [$this, 'validate_api_key']
        ]);
    }

    // **۲. دریافت آخرین نوشته‌های سایت**
    public function get_latest_posts() {
        $posts = get_posts(['numberposts' => 5, 'post_status' => 'publish']);
        if (empty($posts)) {
            return new WP_REST_Response(['message' => 'هیچ نوشته‌ای یافت نشد.'], 404);
        }

        $data = array_map(function ($post) {
            return [
                'id'    => $post->ID,
                'title' => get_the_title($post->ID),
                'link'  => get_permalink($post->ID),
                'date'  => get_the_date('Y-m-d', $post->ID)
            ];
        }, $posts);

        return rest_ensure_response($data);
    }

    // **۳. دریافت و پردازش فرم تماس**
    public function handle_contact_form(WP_REST_Request $request) {
        $params  = $request->get_params();
        $name    = sanitize_text_field($params['name'] ?? '');
        $email   = sanitize_email($params['email'] ?? '');
        $message = sanitize_textarea_field($params['message'] ?? '');

        if (empty($name) || empty($email) || empty($message)) {
            return new WP_REST_Response(['message' => 'لطفاً همه فیلدها را پر کنید.'], 400);
        }

        $headers = ['From: ' . $name . ' <' . $email . '>'];
        wp_mail(get_option('admin_email'), "پیام جدید از $name", $message, $headers);

        return new WP_REST_Response(['message' => 'پیام شما ارسال شد!'], 200);
    }

    // **۴. احراز هویت APIهای خصوصی با کلید امنیتی**
    public function validate_api_key(WP_REST_Request $request) {
        $api_key = $request->get_header('X-API-KEY');
        $valid_key = 'seokar-secret-key'; // 🔒 این مقدار را در `wp-config.php` ذخیره کنید

        if (!$api_key || $api_key !== $valid_key) {
            return new WP_Error('unauthorized', 'دسترسی غیرمجاز!', ['status' => 403]);
        }
        return true;
    }

    // **۵. دریافت داده‌های محافظت‌شده (API خصوصی)**
    public function get_private_data() {
        return rest_ensure_response(['message' => 'این یک داده محافظت‌شده است.']);
    }
}

// **۶. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
new Seokar_REST_API();
