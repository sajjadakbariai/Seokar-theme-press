// **۱. شورت‌کد برای نمایش پیام سفارشی**
function seokar_custom_message_shortcode($atts, $content = null) {
    return '<div class="custom-message">' . do_shortcode($content) . '</div>';
}
add_shortcode('message', 'seokar_custom_message_shortcode');

// **۲. شورت‌کد برای نمایش دکمه سفارشی**
function seokar_custom_button_shortcode($atts) {
    $atts = shortcode_atts(array(
        'text'  => 'کلیک کنید',
        'url'   => '#',
        'color' => '#0073e6'
    ), $atts);

    return '<a href="' . esc_url($atts['url']) . '" class="custom-button" style="background:' . esc_attr($atts['color']) . '; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; display: inline-block;">' . esc_html($atts['text']) . '</a>';
}
add_shortcode('button', 'seokar_custom_button_shortcode');

// **۳. شورت‌کد برای نمایش آخرین نوشته‌ها**
function seokar_latest_posts_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => 5
    ), $atts);

    $query = new WP_Query(array(
        'posts_per_page' => intval($atts['count']),
        'post_status'    => 'publish'
    ));

    $output = '<ul class="latest-posts">';
    while ($query->have_posts()) {
        $query->the_post();
        $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
    }
    wp_reset_postdata();
    $output .= '</ul>';

    return $output;
}
add_shortcode('latest_posts', 'seokar_latest_posts_shortcode');

// **۴. شورت‌کد برای فرم تماس ساده**
function seokar_contact_form_shortcode() {
    ob_start();
    ?>
    <form id="seokar-contact-form">
        <input type="text" name="name" placeholder="نام شما" required>
        <input type="email" name="email" placeholder="ایمیل شما" required>
        <textarea name="message" placeholder="پیام شما" required></textarea>
        <button type="submit">ارسال پیام</button>
    </form>
    <script>
        document.getElementById("seokar-contact-form").addEventListener("submit", function (e) {
            e.preventDefault();
            alert("پیام شما ارسال شد!");
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('contact_form', 'seokar_contact_form_shortcode');
