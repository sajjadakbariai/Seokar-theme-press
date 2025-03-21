<?php
/**
 * Sidebar Template for Seokar Theme
 *
 * @package Seokar
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_active_sidebar( 'seokar_sidebar' ) ) {
    return;
}
?>

<aside id="secondary" class="widget-area">
    <?php dynamic_sidebar( 'seokar_sidebar' ); ?>
</aside>
<div class="widget">
    <h3>آخرین مطالب</h3>
    <?php seokar_display_latest_posts(); ?>
</div>
