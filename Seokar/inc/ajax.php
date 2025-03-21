// **۱. پردازش فرم تماس با AJAX**
function seokar_handle_contact_form() {
    check_ajax_referer('seokar_ajax_nonce', 'security');

    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    if (!$name || !$email || !$message) {
        wp_send_json_error(['message' => 'لطفاً همه فیلدها را پر کنید.']);
    }

    // ارسال ایمیل (مثال)
    wp_mail(get_option('admin_email'), "پیام از $name", $message, "From: $email");

    wp_send_json_success(['message' => 'پیام شما ارسال شد!']);
}
add_action('wp_ajax_seokar_contact_form', 'seokar_handle_contact_form');
add_action('wp_ajax_nopriv_seokar_contact_form', 'seokar_handle_contact_form');

// **۲. پردازش لایک پست**
function seokar_handle_like_post() {
    check_ajax_referer('seokar_ajax_nonce', 'security');

    $post_id = intval($_POST['post_id']);
    if (!$post_id) wp_send_json_error(['message' => 'خطای نامشخص']);

    $likes = get_post_meta($post_id, 'seokar_likes', true);
    $likes = $likes ? $likes + 1 : 1;
    update_post_meta($post_id, 'seokar_likes', $likes);

    wp_send_json_success(['likes' => $likes]);
}
add_action('wp_ajax_seokar_like_post', 'seokar_handle_like_post');
add_action('wp_ajax_nopriv_seokar_like_post', 'seokar_handle_like_post');
