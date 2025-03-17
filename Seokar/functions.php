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

// بارگذاری استایل‌ها و اسکریپت‌ها
function seokar_enqueue_styles() {
    wp_enqueue_style('seokar-main-style', get_template_directory_uri() . '/style.css', [], '1.0.0');
}
add_action('wp_enqueue_scripts', 'seokar_enqueue_styles');

// ثبت منوها
function seokar_register_menus() {
    register_nav_menus([
        'primary' => 'منوی اصلی',
    ]);
}
add_action('after_setup_theme', 'seokar_register_menus');
// بارگذاری استایل‌ها و اسکریپت‌ها
function seokar_enqueue_styles() {
    wp_enqueue_style('seokar-reset', get_template_directory_uri() . '/assets/css/reset.css', [], '1.0.0');
    wp_enqueue_style('seokar-header', get_template_directory_uri() . '/assets/css/header.css', [], '1.0.0');
    wp_enqueue_style('seokar-footer', get_template_directory_uri() . '/assets/css/footer.css', [], '1.0.0');
    wp_enqueue_style('seokar-main', get_template_directory_uri() . '/assets/css/main.css', [], '1.0.0');
    wp_enqueue_style('seokar-responsive', get_template_directory_uri() . '/assets/css/responsive.css', [], '1.0.0');
    wp_enqueue_style('seokar-style', get_stylesheet_uri(), [], '1.0.0');
}
add_action('wp_enqueue_scripts', 'seokar_enqueue_styles');
