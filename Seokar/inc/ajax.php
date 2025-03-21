// **۱. بارگذاری بیشتر مطالب با AJAX**
function seokar_load_more_posts() {
    check_ajax_referer('seokar_ajax_nonce', 'security');

    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $query = new WP_Query(array(
        'post_type'      => 'post',
        'posts_per_page' => 5,
        'paged'          => $paged + 1
    ));

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
add_action('wp_ajax_seokar_load_more', 'seokar_load_more_posts');
add_action('wp_ajax_nopriv_seokar_load_more', 'seokar_load_more_posts');

// **۲. فرم تماس با AJAX**
function seokar_ajax_contact_form() {
    check_ajax_referer('seokar_ajax_nonce', 'security');

    $name    = sanitize_text_field($_POST['name']);
    $email   = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    if (!$name || !$email || !$message) {
        wp_send_json_error(['message' => 'لطفاً همه فیلدها را پر کنید.']);
    }

    wp_mail(get_option('admin_email'), "پیام از $name", $message, "From: $email");
    wp_send_json_success(['message' => 'پیام شما ارسال شد!']);
}
add_action('wp_ajax_seokar_contact_form', 'seokar_ajax_contact_form');
add_action('wp_ajax_nopriv_seokar_contact_form', 'seokar_ajax_contact_form');

// **۳. جستجوی زنده با AJAX**
function seokar_ajax_live_search() {
    check_ajax_referer('seokar_ajax_nonce', 'security');

    $search_query = sanitize_text_field($_POST['search_query']);
    $query = new WP_Query(array(
        'post_type'      => 'post',
        'posts_per_page' => 5,
        's'              => $search_query
    ));

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
add_action('wp_ajax_seokar_live_search', 'seokar_ajax_live_search');
add_action('wp_ajax_nopriv_seokar_live_search', 'seokar_ajax_live_search');
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
