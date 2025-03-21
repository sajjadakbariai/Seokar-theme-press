<?php
/**
 * Footer Template for Seokar Theme
 *
 * @package Seokar
 */

defined( 'ABSPATH' ) || exit;
?>
<?php if (seokar_get_option('seokar_show_back_to_top', true)) : ?>
    <button id="back-to-top">↑</button>
<?php endif; ?>

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
<?php if (seokar_get_theme_option('seokar_show_back_to_top', true)) : ?>
    <button id="back-to-top">↑</button>
<?php endif; ?>
