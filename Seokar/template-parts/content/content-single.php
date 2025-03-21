<?php
$post_id = get_the_ID();
$likes = get_post_meta($post_id, 'seokar_likes', true);
$likes = $likes ? $likes : 0;
?>
<button class="like-button" data-postid="<?php echo $post_id; ?>">❤️ <?php echo $likes; ?></button>
