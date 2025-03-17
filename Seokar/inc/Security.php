<?php
namespace Seokar;

defined( 'ABSPATH' ) || exit;

class Security {
    public static function apply() {
        add_filter( 'rest_authentication_errors', [ __CLASS__, 'restrict_rest_api' ] );
        remove_action( 'wp_head', 'wp_generator' );
        remove_action( 'wp_head', 'rsd_link' );
        remove_action( 'wp_head', 'wlwmanifest_link' );
        remove_action( 'wp_head', 'rest_output_link_wp_head' );
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    }

    public static function restrict_rest_api( $access ) {
        if ( ! is_user_logged_in() ) {
            return new \WP_Error( 'rest_cannot_access', __( 'دسترسی به REST API محدود شده است.' ), [ 'status' => rest_authorization_required_code() ] );
        }
        return $access;
    }
}
