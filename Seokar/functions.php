<?php
/**
 * Main Functions File for Seokar Theme
 *
 * @package Seokar
 */

defined( 'ABSPATH' ) || exit;

// 📌 بارگذاری فایل Autoloader برای کلاس‌های PHP
require_once get_template_directory() . '/inc/autoload.php';

// 📌 بارگذاری تمام فایل‌های `inc/`
$inc_files = [
    'setup.php',
    'enqueue.php',
    'custom-post-types.php',
    'custom-taxonomies.php',
    'theme-functions.php',
    'theme-hooks.php',
    'theme-options.php',
    'breadcrumbs.php',
    'security.php',
    'seo.php',
    'caching.php',
    'user-roles.php',
    'i18n.php',
    'error-handling.php',
    'optimization.php',
    'debug.php',
    'legacy-browsers.php',
    'accessibility.php',
    'multisite.php',
    'custom-fields.php',
    'shortcodes.php',
    'ajax.php',
    'webp.php',
    'rest-api.php'
];

foreach ($inc_files as $file) {
    require_once get_template_directory() . '/inc/' . $file;
}

// 📌 اجرای توابع اصلی قالب
Seokar\Enqueue::register();
Seokar\Menus::register();
Seokar\Security::apply();

// 📌 ثبت منوهای قالب
function seokar_register_menus() {
    register_nav_menus([
        'primary' => __('منوی اصلی', 'seokar'),
        'footer'  => __('منوی فوتر', 'seokar'),
    ]);
}
add_action('after_setup_theme', 'seokar_register_menus');

// 📌 بارگذاری استایل‌ها و اسکریپت‌های اصلی
function seokar_enqueue_assets() {
    $theme_version = wp_get_theme()->get('Version');

    // 📌 استایل‌های قالب
    wp_enqueue_style('seokar-style', get_stylesheet_uri(), [], $theme_version);
    wp_enqueue_style('seokar-main', get_template_directory_uri() . '/assets/css/main.css', [], $theme_version);
    wp_enqueue_style('seokar-responsive', get_template_directory_uri() . '/assets/css/responsive.css', [], $theme_version);

    // 📌 اسکریپت‌های قالب
    wp_enqueue_script('seokar-scripts', get_template_directory_uri() . '/assets/js/scripts.js', ['jquery'], $theme_version, true);
    wp_enqueue_script('seokar-custom', get_template_directory_uri() . '/assets/js/custom.js', ['seokar-scripts'], $theme_version, true);
    wp_enqueue_script('seokar-ajax', get_template_directory_uri() . '/assets/js/ajax-handlers.js', ['jquery'], $theme_version, true);

    // 📌 ارسال متغیرهای AJAX به جاوا اسکریپت
    wp_localize_script('seokar-ajax', 'seokar_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('seokar_ajax_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'seokar_enqueue_assets');

// 📌 بارگذاری اسکریپت‌های پنل مدیریت
function seokar_enqueue_admin_scripts($hook) {
    if ($hook !== 'toplevel_page_seokar-theme-options') return;

    wp_enqueue_script('seokar-admin-scripts', get_template_directory_uri() . '/assets/js/admin-scripts.js', ['jquery'], '1.0.0', true);
    wp_localize_script('seokar-admin-scripts', 'seokar_admin', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('seokar_admin_nonce'),
    ]);
}
add_action('admin_enqueue_scripts', 'seokar_enqueue_admin_scripts');

// 📌 فعال‌سازی پشتیبانی از تصاویر شاخص و ویژگی‌های قالب
function seokar_theme_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'seokar_theme_setup');

// 📌 توابع مربوط به WooCommerce (در صورت فعال بودن)
if (class_exists('WooCommerce')) {
    require_once get_template_directory() . '/woocommerce/woocommerce-functions.php';

    function seokar_enqueue_woocommerce_scripts() {
        if (is_woocommerce()) {
            wp_enqueue_script('seokar-woocommerce', get_template_directory_uri() . '/assets/js/woocommerce.js', ['jquery'], '1.0.0', true);
            wp_localize_script('seokar-woocommerce', 'seokar_ajax', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'security' => wp_create_nonce('seokar_ajax_nonce'),
            ]);
        }
    }
    add_action('wp_enqueue_scripts', 'seokar_enqueue_woocommerce_scripts');

    function seokar_enqueue_woocommerce_styles() {
        if (is_woocommerce()) {
            wp_enqueue_style('seokar-woocommerce', get_template_directory_uri() . '/woocommerce/woocommerce.css');
        }
    }
    add_action('wp_enqueue_scripts', 'seokar_enqueue_woocommerce_styles');

    function seokar_quick_add_to_cart_button() {
        global $product;
        echo '<button class="quick-add-to-cart" data-product_id="' . $product->get_id() . '">🛒 خرید سریع</button>';
    }
    add_action('woocommerce_after_shop_loop_item', 'seokar_quick_add_to_cart_button', 15);
}

// 📌 بارگذاری فایل‌های اضافی در صورت نیاز
require_once get_template_directory() . '/classes/class-theme-setup.php';
require_once get_template_directory() . '/classes/class-ajax-handler.php';
require_once get_template_directory() . '/classes/class-custom-post.php';
require_once get_template_directory() . '/cli/custom-cli-commands.php';
require_once get_template_directory() . '/migrations/migration-setup.php';
require_once get_template_directory() . '/vendor/autoload.php';

// 📌 بارگذاری تنظیمات قالب در پنل مدیریت
if (is_admin()) {
    require_once get_template_directory() . '/admin/admin-menu.php';
    require_once get_template_directory() . '/admin/admin-settings.php';
}

// 📌 پشتیبانی از AMP در صورت فعال بودن
if (class_exists('Seokar_AMP_Support')) {
    require_once get_template_directory() . '/amp/amp-functions.php';
}
