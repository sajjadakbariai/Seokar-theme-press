<?php
/**
 * Menu Cache for Seokar Theme
 *
 * @package Seokar
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Seokar_Menu_Cache {

    /**
     * Initialize the menu cache.
     */
    public function __construct() {
        add_action( 'wp_nav_menu', [ $this, 'cache_menu' ], 10, 2 );
        add_action( 'save_post', [ $this, 'clear_menu_cache' ] );
        add_action( 'wp_update_nav_menu', [ $this, 'clear_menu_cache' ] );
        add_action( 'customize_save_after', [ $this, 'clear_menu_cache' ] );
    }

    /**
     * Get cached menu if available, otherwise generate and cache it.
     *
     * @param string   $nav_menu The HTML content for the menu.
     * @param stdClass $args     Arguments passed to wp_nav_menu().
     *
     * @return string Cached or freshly generated menu HTML.
     */
    public function cache_menu( $nav_menu, $args ) {
        if ( is_admin() || ! isset( $args->theme_location ) ) {
            return $nav_menu;
        }

        $cache_key = 'seokar_menu_' . $args->theme_location;
        $cached_menu = get_transient( $cache_key );

        if ( false === $cached_menu ) {
            // Cache the generated menu for 12 hours.
            set_transient( $cache_key, $nav_menu, 12 * HOUR_IN_SECONDS );
            return $nav_menu;
        }

        return $cached_menu;
    }

    /**
     * Clear menu cache when menus are updated.
     */
    public function clear_menu_cache() {
        $locations = get_nav_menu_locations();
        if ( ! empty( $locations ) ) {
            foreach ( $locations as $location => $menu_id ) {
                delete_transient( 'seokar_menu_' . $location );
            }
        }
    }
}

new Seokar_Menu_Cache();
