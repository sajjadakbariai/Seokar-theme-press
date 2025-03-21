<?php
$post_id = get_the_ID();
$likes = get_post_meta($post_id, 'seokar_likes', true);
$likes = $likes ? $likes : 0;
?>
<button class="like-button" data-postid="<?php echo $post_id; ?>">❤️ <?php echo $likes; ?></button>
<?php
$custom_field_value = seokar_get_custom_field(get_the_ID());
if (!empty($custom_field_value)) {
    echo '<p class="custom-field">📌 ' . esc_html($custom_field_value) . '</p>';
}
?>
