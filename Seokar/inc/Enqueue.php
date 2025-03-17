<?php
namespace Seokar;

defined( 'ABSPATH' ) || exit;

class Enqueue {
    public static function register() {
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_assets' ] );
    }

    public static function enqueue_assets() {
        $version = wp_get_theme()->get( 'Version' );

        // استایل اصلی
        wp_enqueue_style( 'seokar-style', get_stylesheet_uri(), [], $version );

        // استایل RTL
        if ( is_rtl() ) {
            wp_enqueue_style( 'seokar-rtl', get_template_directory_uri() . '/assets/css/rtl.css', [ 'seokar-style' ], $version );
        }

        // اسکریپت اصلی فقط در صفحه اصلی
        if ( is_front_page() ) {
            wp_enqueue_script( 'seokar-main', get_template_directory_uri() . '/assets/js/main.js', [ 'jquery' ], $version, true );
        }
    }
}
