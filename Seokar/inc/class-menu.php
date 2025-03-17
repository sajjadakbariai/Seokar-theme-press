<?php
/**
 * Class Seokar_Menu
 * 
 * Handles the registration and customization of theme menus.
 *
 * @package Seokar
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Seokar_Menu' ) ) {

    class Seokar_Menu {

        /**
         * Constructor to initialize hooks.
         */
        public function __construct() {
            add_action( 'after_setup_theme', [ $this, 'register_menus' ] );
            add_filter( 'nav_menu_css_class', [ $this, 'add_custom_menu_classes' ], 10, 4 );
            add_filter( 'nav_menu_link_attributes', [ $this, 'add_custom_menu_link_attributes' ], 10, 4 );
        }

        /**
         * Register theme menus.
         */
        public function register_menus() {
            register_nav_menus([
                'primary'   => __( 'Primary Menu', 'seokar' ),
                'footer'    => __( 'Footer Menu', 'seokar' ),
                'social'    => __( 'Social Menu', 'seokar' )
            ]);
        }

        /**
         * Add custom classes to menu items.
         *
         * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param object $args    An object of wp_nav_menu() arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         * @return array
         */
        public function add_custom_menu_classes( $classes, $item, $args, $depth ) {
            if ( isset( $args->theme_location ) ) {
                if ( $args->theme_location === 'primary' ) {
                    $classes[] = 'nav-item';
                }
                if ( $args->theme_location === 'footer' ) {
                    $classes[] = 'footer-item';
                }
                if ( $args->theme_location === 'social' ) {
                    $classes[] = 'social-item';
                }
            }
            return $classes;
        }

        /**
         * Add custom attributes to menu links.
         *
         * @param array $atts   The HTML attributes applied to the menu item's `<a>` element.
         * @param object $item  The current menu item.
         * @param object $args  An object of wp_nav_menu() arguments.
         * @param int    $depth Depth of menu item.
         * @return array
         */
        public function add_custom_menu_link_attributes( $atts, $item, $args, $depth ) {
            if ( isset( $args->theme_location ) ) {
                if ( $args->theme_location === 'primary' ) {
                    $atts['class'] = 'nav-link';
                }
                if ( $args->theme_location === 'footer' ) {
                    $atts['class'] = 'footer-link';
                }
                if ( $args->theme_location === 'social' ) {
                    $atts['class'] = 'social-link';
                    $atts['target'] = '_blank'; // Open social links in a new tab.
                    $atts['rel'] = 'noopener noreferrer';
                }
            }
            return $atts;
        }
    }

    // Initialize the menu class.
    new Seokar_Menu();
}
<?php
namespace Seokar;

defined( 'ABSPATH' ) || exit;

class Menus {

    public static function register() {
        add_action( 'init', [ __CLASS__, 'register_menus' ] );
        add_action( 'widgets_init', [ __CLASS__, 'register_sidebars' ] );
    }

    public static function register_menus() {
        register_nav_menus([
            'primary' => __( 'Primary Menu', 'seokar' ),
            'footer'  => __( 'Footer Menu', 'seokar' ),
        ]);
    }

    public static function register_sidebars() {
        register_sidebar([
            'name'          => __( 'سایدبار اصلی', 'seokar' ),
            'id'            => 'seokar_sidebar',
            'description'   => __( 'ابزارک‌های سایدبار را در اینجا اضافه کنید.', 'seokar' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ]);
    }
}
public static function register_sidebars() {
    // سایدبار اصلی
    register_sidebar([
        'name'          => __( 'سایدبار اصلی', 'seokar' ),
        'id'            => 'seokar_sidebar',
        'description'   => __( 'ابزارک‌های سایدبار را در اینجا اضافه کنید.', 'seokar' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);

    // سایدبار فوتر
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
