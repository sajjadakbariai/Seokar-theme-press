// **۱. افزودن متاباکس فیلد سفارشی به ویرایشگر نوشته**
function seokar_add_custom_meta_box() {
    add_meta_box(
        'seokar_custom_field',
        'اطلاعات سفارشی نوشته',
        'seokar_custom_field_callback',
        'post',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'seokar_add_custom_meta_box');

// **۲. نمایش فیلد در متاباکس**
function seokar_custom_field_callback($post) {
    wp_nonce_field('seokar_save_custom_field', 'seokar_custom_field_nonce');
    $custom_value = get_post_meta($post->ID, '_seokar_custom_field', true);
    ?>
    <label for="seokar_custom_field">توضیح کوتاه:</label>
    <input type="text" id="seokar_custom_field" name="seokar_custom_field" value="<?php echo esc_attr($custom_value); ?>" style="width: 100%;">
    <?php
}

// **۳. ذخیره مقدار فیلد سفارشی در پایگاه داده**
function seokar_save_custom_field($post_id) {
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
add_action('save_post', 'seokar_save_custom_field');

// **۴. دریافت مقدار فیلد سفارشی در قالب**
function seokar_get_custom_field($post_id) {
    return get_post_meta($post_id, '_seokar_custom_field', true);
}
