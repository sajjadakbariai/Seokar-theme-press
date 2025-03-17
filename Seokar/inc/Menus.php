<?php
namespace Seokar;

defined( 'ABSPATH' ) || exit;

class Menus {
    public static function register() {
        add_action( 'after_setup_theme', [ __CLASS__, 'register_menus' ] );
        add_filter( 'nav_menu_css_class', [ __CLASS__, 'add_menu_item_class' ], 10, 3 );
        add_filter( 'nav_menu_link_attributes', [ __CLASS__, 'add_menu_link_class' ], 10, 3 );
    }

    public static function register_menus() {
        register_nav_menus( [
            'primary' => __( 'Primary Menu', 'seokar' ),
            'footer'  => __( 'Footer Menu', 'seokar' ),
        ] );
    }

    public static function add_menu_item_class( $classes, $item, $args ) {
        if ( isset( $args->theme_location ) && $args->theme_location === 'primary' ) {
            $classes[] = 'nav-item';
        }
        return $classes;
    }

    public static function add_menu_link_class( $atts, $item, $args ) {
        if ( isset( $args->theme_location ) && $args->theme_location === 'primary' ) {
            $atts['class'] = 'nav-link';
        }
        return $atts;
    }
}
