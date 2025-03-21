<?php
if (!defined('ABSPATH')) exit; // امنیت: جلوگیری از دسترسی مستقیم

class Seokar_Shortcodes {

    // **۱. مقداردهی اولیه شورت‌کدها**
    public function __construct() {
        add_shortcode('message', [$this, 'custom_message_shortcode']);
        add_shortcode('button', [$this, 'custom_button_shortcode']);
        add_shortcode('latest_posts', [$this, 'latest_posts_shortcode']);
        add_shortcode('contact_form', [$this, 'contact_form_shortcode']);
    }

    // **۲. شورت‌کد برای نمایش پیام سفارشی**
    public function custom_message_shortcode($atts, $content = null) {
        return '<div class="custom-message">' . do_shortcode($content) . '</div>';
    }

    // **۳. شورت‌کد برای نمایش دکمه سفارشی**
    public function custom_button_shortcode($atts) {
        $atts = shortcode_atts([
            'text'  => 'کلیک کنید',
            'url'   => '#',
            'color' => '#0073e6'
        ], $atts);

        return '<a href="' . esc_url($atts['url']) . '" class="custom-button" style="background:' . esc_attr($atts['color']) . '; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; display: inline-block;">' . esc_html($atts['text']) . '</a>';
    }

    // **۴. شورت‌کد برای نمایش آخرین نوشته‌ها**
    public function latest_posts_shortcode($atts) {
        $atts = shortcode_atts(['count' => 5], $atts);

        $query = new WP_Query([
            'posts_per_page' => intval($atts['count']),
            'post_status'    => 'publish'
        ]);

        if (!$query->have_posts()) {
            return '<p>هیچ نوشته‌ای یافت نشد.</p>';
        }

        $output = '<ul class="latest-posts">';
        while ($query->have_posts()) {
            $query->the_post();
            $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        }
        wp_reset_postdata();
        $output .= '</ul>';

        return $output;
    }

    // **۵. شورت‌کد برای فرم تماس ساده**
    public function contact_form_shortcode() {
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
}

// **۶. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
new Seokar_Shortcodes();
