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
function seokar_enqueue_admin_scripts($hook) {
    if ($hook !== 'toplevel_page_seokar-theme-options') return;

    wp_enqueue_script('seokar-admin-scripts', get_template_directory_uri() . '/assets/js/admin-scripts.js', array('jquery'), '1.0.0', true);

    wp_localize_script('seokar-admin-scripts', 'seokar_admin', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('seokar_admin_nonce'),
    ));
}
add_action('admin_enqueue_scripts', 'seokar_enqueue_admin_scripts');
function seokar_enqueue_ajax_scripts() {
    wp_enqueue_script('seokar-ajax', get_template_directory_uri() . '/assets/js/ajax.js', array('jquery'), '1.0.0', true);

    wp_localize_script('seokar-ajax', 'seokar_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('seokar_ajax_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'seokar_enqueue_ajax_scripts');
function seokar_get_featured_image_webp($post_id, $size = 'full') {
    $image_id  = get_post_thumbnail_id($post_id);
    $image_url = wp_get_attachment_image_url($image_id, $size);
    $webp_url  = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $image_url);

    return seokar_is_webp_supported() && file_exists(str_replace(home_url('/'), ABSPATH, $webp_url)) ? $webp_url : $image_url;
}
require_once get_template_directory() . '/classes/class-theme-setup.php';
require_once get_template_directory() . '/classes/class-ajax-handler.php';
require_once get_template_directory() . '/classes/class-custom-post.php';
require_once get_template_directory() . '/cli/custom-cli-commands.php';
require_once get_template_directory() . '/migrations/migration-setup.php';
require_once get_template_directory() . '/vendor/autoload.php';
if (class_exists('WooCommerce')) {
    require_once get_template_directory() . '/woocommerce/woocommerce-functions.php';
}
function seokar_enqueue_woocommerce_scripts() {
    if (is_woocommerce()) {
        wp_enqueue_script('seokar-woocommerce', get_template_directory_uri() . '/assets/js/woocommerce.js', array('jquery'), '1.0.0', true);
        wp_localize_script('seokar-woocommerce', 'seokar_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'security' => wp_create_nonce('seokar_ajax_nonce'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'seokar_enqueue_woocommerce_scripts');
function seokar_quick_add_to_cart_button() {
    global $product;
    echo '<button class="quick-add-to-cart" data-product_id="' . $product->get_id() . '">🛒 خرید سریع</button>';
}
add_action('woocommerce_after_shop_loop_item', 'seokar_quick_add_to_cart_button', 15);
function seokar_enqueue_woocommerce_styles() {
    if (is_woocommerce()) {
        wp_enqueue_style('seokar-woocommerce', get_template_directory_uri() . '/woocommerce/woocommerce.css');
    }
}
add_action('wp_enqueue_scripts', 'seokar_enqueue_woocommerce_styles');
if (is_admin()) {
    require_once get_template_directory() . '/admin/admin-menu.php';
}
if (is_admin()) {
    require_once get_template_directory() . '/admin/admin-settings.php';
}
