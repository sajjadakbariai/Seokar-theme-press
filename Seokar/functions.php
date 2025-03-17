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

// بارگذاری استایل‌های قالب
function seokar_enqueue_styles() {
    // بارگذاری فایل استایل اصلی قالب
    wp_enqueue_style('seokar-main-style', get_stylesheet_uri(), [], '1.0.0');

    // بارگذاری فایل استایل سفارشی در پوشه assets
    wp_enqueue_style('seokar-custom-style', get_template_directory_uri() . '/assets/css/style.css', [], '1.0.0');
}
add_action('wp_enqueue_scripts', 'seokar_enqueue_styles');
