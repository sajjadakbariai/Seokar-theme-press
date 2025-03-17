<?php
/**
 * Main Functions File for Seokar Theme
 *
 * @package Seokar
 */

defined( 'ABSPATH' ) || exit;

// بارگذاری فایل Autoloader
require_once get_template_directory() . '/inc/autoload.php';

// اجرای توابع اصلی
Seokar\Enqueue::register();
Seokar\Menus::register();
Seokar\Security::apply();

/**
 * بارگذاری استایل اصلی قالب
 */
function seokar_enqueue_styles() {
    wp_enqueue_style('seokar-style', get_template_directory_uri() . '/assets/style.css', [], '1.0.0');
}
add_action('wp_enqueue_scripts', 'seokar_enqueue_styles');
