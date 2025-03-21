// **۱. افزودن مسیر REST API برای دریافت آخرین مطالب**
function seokar_register_latest_posts_route() {
    register_rest_route('seokar/v1', '/latest-posts/', array(
        'methods'  => 'GET',
        'callback' => 'seokar_get_latest_posts',
        'permission_callback' => '__return_true'
    ));
}
add_action('rest_api_init', 'seokar_register_latest_posts_route');

function seokar_get_latest_posts() {
    $posts = get_posts(array('numberposts' => 5, 'post_status' => 'publish'));
    $data = array();

    foreach ($posts as $post) {
        $data[] = array(
            'id'    => $post->ID,
            'title' => $post->post_title,
            'link'  => get_permalink($post->ID)
        );
    }

    return rest_ensure_response($data);
}

// **۲. ایجاد API برای ارسال فرم تماس**
function seokar_register_contact_api() {
    register_rest_route('seokar/v1', '/contact/', array(
        'methods'  => 'POST',
        'callback' => 'seokar_handle_contact_form',
        'permission_callback' => '__return_true'
    ));
}
add_action('rest_api_init', 'seokar_register_contact_api');

function seokar_handle_contact_form(WP_REST_Request $request) {
    $name    = sanitize_text_field($request->get_param('name'));
    $email   = sanitize_email($request->get_param('email'));
    $message = sanitize_textarea_field($request->get_param('message'));

    if (!$name || !$email || !$message) {
        return new WP_REST_Response(['message' => 'لطفاً همه فیلدها را پر کنید.'], 400);
    }

    wp_mail(get_option('admin_email'), "پیام از $name", $message, "From: $email");
    
    return new WP_REST_Response(['message' => 'پیام شما ارسال شد!'], 200);
}

// **۳. احراز هویت برای API‌های خصوصی**
function seokar_private_api_auth(WP_REST_Request $request) {
    $api_key = $request->get_header('X-API-KEY');
    $valid_key = 'seokar-secret-key';

    if ($api_key !== $valid_key) {
        return new WP_Error('unauthorized', 'دسترسی غیرمجاز!', array('status' => 403));
    }

    return true;
}

function seokar_register_private_api() {
    register_rest_route('seokar/v1', '/private-data/', array(
        'methods'  => 'GET',
        'callback' => 'seokar_get_private_data',
        'permission_callback' => 'seokar_private_api_auth'
    ));
}
add_action('rest_api_init', 'seokar_register_private_api');

function seokar_get_private_data() {
    return rest_ensure_response(['message' => 'این یک داده محافظت‌شده است.']);
}
