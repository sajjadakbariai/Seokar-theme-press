<?php
namespace Seokar;

defined( 'ABSPATH' ) || exit;

/**
 * Class Menus
 *
 * Handles the registration of theme menus and sidebars.
 *
 * @package Seokar
 */
class Menus {

    /**
     * Initialize hooks for menus and sidebars.
     */
    public static function register() {
        add_action( 'init', [ __CLASS__, 'register_menus' ] );
        add_action( 'widgets_init', [ __CLASS__, 'register_sidebars' ] );
        add_filter( 'nav_menu_css_class', [ __CLASS__, 'add_custom_menu_classes' ], 10, 4 );
        add_filter( 'nav_menu_link_attributes', [ __CLASS__, 'add_custom_menu_link_attributes' ], 10, 4 );
    }

    /**
     * Register theme navigation menus.
     */
    public static function register_menus() {
        register_nav_menus([
            'primary'   => __( 'Primary Menu', 'seokar' ),
            'footer'    => __( 'Footer Menu', 'seokar' ),
            'social'    => __( 'Social Menu', 'seokar' ),
        ]);
    }

    /**
     * Register theme sidebars.
     */
    public static function register_sidebars() {
        // Main Sidebar
        register_sidebar([
            'name'          => __( 'سایدبار اصلی', 'seokar' ),
            'id'            => 'seokar_sidebar',
            'description'   => __( 'ابزارک‌های سایدبار را در اینجا اضافه کنید.', 'seokar' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ]);

        // Footer Sidebar
        register_sidebar([
            'name'          => __( 'سایدبار فوتر', 'seokar' ),
            'id'            => 'footer_sidebar',
            'description'   => __( 'ابزارک‌های فوتر را در اینجا اضافه کنید.', 'seokar' ),
            'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="footer-widget-title">',
            'after_title'   => '</h2>',
        ]);
    }

    /**
     * Add custom classes to menu items.
     *
     * @param array  $classes The CSS classes applied to the menu item's `<li>` element.
     * @param object $item    The current menu item.
     * @param object $args    The menu's arguments.
     * @param int    $depth   Depth of menu item.
     * @return array
     */
    public static function add_custom_menu_classes( $classes, $item, $args, $depth ) {
        switch ( $args->theme_location ) {
            case 'primary':
                $classes[] = 'nav-item';
                break;
            case 'footer':
                $classes[] = 'footer-item';
                break;
            case 'social':
                $classes[] = 'social-item';
                break;
        }
        return $classes;
    }

    /**
     * Add custom attributes to menu links.
     *
     * @param array  $atts   The HTML attributes for the menu item's `<a>` element.
     * @param object $item   The current menu item.
     * @param object $args   The menu's arguments.
     * @param int    $depth  Depth of menu item.
     * @return array
     */
    public static function add_custom_menu_link_attributes( $atts, $item, $args, $depth ) {
        switch ( $args->theme_location ) {
            case 'primary':
                $atts['class'] = 'nav-link';
                break;
            case 'footer':
                $atts['class'] = 'footer-link';
                break;
            case 'social':
                $atts['class'] = 'social-link';
                $atts['target'] = '_blank';
                $atts['rel'] = 'noopener noreferrer';
                break;
        }
        return $atts;
    }
}
