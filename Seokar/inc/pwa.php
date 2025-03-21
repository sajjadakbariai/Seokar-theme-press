<?php
/**
 * Progressive Web App (PWA) Support for Seokar Theme
 *
 * @package Seokar
 */

defined( 'ABSPATH' ) || exit;

class Seokar_PWA {
    public static function init() {
        add_action('wp_head', [__CLASS__, 'add_pwa_meta']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'register_service_worker']);
        add_action('rest_api_init', [__CLASS__, 'register_manifest_route']);
    }

    // 📌 افزودن متا تگ‌های PWA به `<head>`
    public static function add_pwa_meta() {
        ?>
        <link rel="manifest" href="<?php echo esc_url(get_rest_url(null, 'seokar/v1/manifest')); ?>">
        <meta name="theme-color" content="#1A73E8">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/pwa-icon.png'); ?>">
        <?php
    }

    // 📌 ثبت `service worker` برای مدیریت کش و آفلاین
    public static function register_service_worker() {
        wp_enqueue_script('seokar-service-worker', get_template_directory_uri() . '/assets/js/service-worker.js', [], null, true);
    }

    // 📌 ایجاد `manifest.json` برای تنظیمات PWA
    public static function register_manifest_route() {
        register_rest_route('seokar/v1', '/manifest', [
            'methods'  => 'GET',
            'callback' => [__CLASS__, 'generate_manifest'],
            'permission_callback' => '__return_true',
        ]);
    }

    public static function generate_manifest() {
        return new WP_REST_Response([
            "name" => "Seokar PWA",
            "short_name" => "Seokar",
            "start_url" => home_url(),
            "display" => "standalone",
            "background_color" => "#FFFFFF",
            "theme_color" => "#1A73E8",
            "icons" => [
                [
                    "src" => get_template_directory_uri() . "/assets/images/pwa-icon.png",
                    "sizes" => "192x192",
                    "type" => "image/png"
                ],
                [
                    "src" => get_template_directory_uri() . "/assets/images/pwa-icon-large.png",
                    "sizes" => "512x512",
                    "type" => "image/png"
                ]
            ]
        ], 200);
    }
}

Seokar_PWA::init();
