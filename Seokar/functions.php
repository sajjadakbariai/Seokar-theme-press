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
function seokar_enqueue_scripts() {
    // بارگذاری استایل‌ها (قبلاً اضافه شد)
    wp_enqueue_style('seokar-style', get_stylesheet_uri());

    // بارگذاری اسکریپت‌ها
    wp_enqueue_script('seokar-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'seokar_enqueue_scripts');
function seokar_enqueue_scripts() {
    // استایل‌ها و اسکریپت‌های قبلی
    wp_enqueue_style('seokar-style', get_stylesheet_uri());
    wp_enqueue_script('seokar-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), '1.0.0', true);

    // بارگذاری `custom.js`
    wp_enqueue_script('seokar-custom', get_template_directory_uri() . '/assets/js/custom.js', array('seokar-scripts'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'seokar_enqueue_scripts');
function seokar_enqueue_scripts() {
    wp_enqueue_style('seokar-style', get_stylesheet_uri());
    wp_enqueue_script('seokar-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), '1.0.0', true);
    wp_enqueue_script('seokar-custom', get_template_directory_uri() . '/assets/js/custom.js', array('seokar-scripts'), '1.0.0', true);
    wp_enqueue_script('seokar-ajax', get_template_directory_uri() . '/assets/js/ajax-handlers.js', array('jquery'), '1.0.0', true);

    // متغیرهای AJAX برای جاوا اسکریپت
    wp_localize_script('seokar-ajax', 'seokar_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('seokar_ajax_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'seokar_enqueue_scripts');
