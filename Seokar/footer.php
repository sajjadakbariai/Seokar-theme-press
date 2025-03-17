<?php
/**
 * Footer Template for Seokar Theme
 *
 * @package Seokar
 */

defined( 'ABSPATH' ) || exit;
?>

<footer id="colophon" class="site-footer">
    <div class="footer-widgets">
        <?php if ( is_active_sidebar( 'footer_sidebar' ) ) : ?>
            <?php dynamic_sidebar( 'footer_sidebar' ); ?>
        <?php endif; ?>
    </div>

    <div class="site-info">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> - <?php _e('All Rights Reserved.', 'seokar'); ?></p>
    </div>

    <?php wp_footer(); ?>
</footer>
