<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_Custom_Fields {

    public function __construct() {
        add_action('add_meta_boxes', [$this, 'add_custom_meta_box']);
        add_action('save_post', [$this, 'save_custom_field']);
    }

    /**
     * **۱. افزودن متاباکس فیلد سفارشی به ویرایشگر نوشته**
     */
    public function add_custom_meta_box() {
        $screens = ['post', 'portfolio', 'testimonials']; // نمایش در پست تایپ‌های مختلف
        foreach ($screens as $screen) {
            add_meta_box(
                'seokar_custom_field',
                __('اطلاعات سفارشی نوشته', 'seokar'),
                [$this, 'render_custom_field'],
                $screen,
                'normal',
                'high'
            );
        }
    }

    /**
     * **۲. نمایش فیلد در متاباکس**
     *
     * @param WP_Post $post پست جاری.
     */
    public function render_custom_field($post) {
        wp_nonce_field('seokar_save_custom_field', 'seokar_custom_field_nonce');
        $custom_value = get_post_meta($post->ID, '_seokar_custom_field', true);
        ?>
        <label for="seokar_custom_field"><?php _e('توضیح کوتاه:', 'seokar'); ?></label>
        <input type="text" id="seokar_custom_field" name="seokar_custom_field" value="<?php echo esc_attr($custom_value); ?>" style="width: 100%;">
        <?php
    }

    /**
     * **۳. ذخیره مقدار فیلد سفارشی در پایگاه داده**
     *
     * @param int $post_id شناسه پست.
     */
    public function save_custom_field($post_id) {
        if (!isset($_POST['seokar_custom_field_nonce']) || !wp_verify_nonce($_POST['seokar_custom_field_nonce'], 'seokar_save_custom_field')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['seokar_custom_field'])) {
            update_post_meta($post_id, '_seokar_custom_field', sanitize_text_field($_POST['seokar_custom_field']));
        }
    }

    /**
     * **۴. دریافت مقدار فیلد سفارشی در قالب**
     *
     * @param int $post_id شناسه پست.
     * @return string مقدار فیلد سفارشی.
     */
    public static function get_custom_field($post_id) {
        return get_post_meta($post_id, '_seokar_custom_field', true);
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
new Seokar_Custom_Fields();
