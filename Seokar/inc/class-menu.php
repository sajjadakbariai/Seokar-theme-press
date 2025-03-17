<?php
/**
 * Class Seokar_Menu
 * 
 * Handles the registration and customization of theme menus.
 *
 * @package Seokar
 */
namespace Seokar;

defined( 'ABSPATH' ) || exit;

class Theme_Menus {

    const MENU_LOCATIONS = [
        'primary' => 'Primary Menu',
        'footer'  => 'Footer Menu',
        'social'  => 'Social Menu',
    ];

    const SIDEBARS = [
        'main'   => [
            'name'        => 'سایدبار اصلی',
            'id'          => 'seokar_sidebar',
            'description' => 'ابزارک‌های سایدبار را در اینجا اضافه کنید.',
            'class'       => 'widget',
            'title_class' => 'widget-title',
        ],
        'footer' => [
            'name'        => 'سایدبار فوتر',
            'id'          => 'footer_sidebar',
            'description' => 'ابزارک‌های فوتر را در اینجا اضافه کنید.',
            'class'       => 'footer-widget',
            'title_class' => 'footer-widget-title',
        ],
    ];

    public function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        add_action( 'after_setup_theme', [ $this, 'register_menus' ] );
        add_action( 'widgets_init', [ $this, 'register_sidebars' ] );
        add_filter( 'nav_menu_css_class', [ $this, 'add_custom_menu_classes' ], 10, 4 );
        add_filter( 'nav_menu_link_attributes', [ $this, 'add_custom_menu_link_attributes' ], 10, 4 );
    }

    public function register_menus() {
        foreach ( self::MENU_LOCATIONS as $location => $description ) {
            register_nav_menu( $location, __( $description, 'seokar' ) );
        }
    }

    public function register_sidebars() {
        foreach ( self::SIDEBARS as $sidebar ) {
            register_sidebar([
                'name'          => __( $sidebar['name'], 'seokar' ),
                'id'            => $sidebar['id'],
                'description'   => __( $sidebar['description'], 'seokar' ),
                'before_widget' => '<section id="%1$s" class="' . $sidebar['class'] . ' %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="' . $sidebar['title_class'] . '">',
                'after_title'   => '</h2>',
            ]);
        }
    }

    public function add_custom_menu_classes( $classes, $item, $args, $depth ) {
        if ( isset( $args->theme_location ) ) {
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
        }
        return $classes;
    }

    public function add_custom_menu_link_attributes( $atts, $item, $args, $depth ) {
        if ( isset( $args->theme_location ) ) {
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
        }
        return $atts;
    }
}

// Initialize the menu class.
new Theme_Menus();
