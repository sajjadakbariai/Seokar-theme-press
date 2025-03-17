<?php
/**
 * Custom Walker Class for Menu
 *
 * @package Seokar
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Seokar_Walker_Nav_Menu' ) ) {

    class Seokar_Walker_Nav_Menu extends Walker_Nav_Menu {

        /**
         * Start level.
         *
         * @param string   $output Used to append additional content (passed by reference).
         * @param int      $depth  Depth of menu item. Used for padding.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         */
        public function start_lvl( &$output, $depth = 0, $args = null ) {
            $indent = str_repeat( "\t", $depth );
            $submenu_class = $depth > 0 ? 'sub-sub-menu' : 'sub-menu';
            $output .= "\n$indent<ul class=\"$submenu_class\">\n";
        }

        /**
         * End level.
         *
         * @param string   $output Used to append additional content (passed by reference).
         * @param int      $depth  Depth of menu item. Used for padding.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         */
        public function end_lvl( &$output, $depth = 0, $args = null ) {
            $indent = str_repeat( "\t", $depth );
            $output .= "$indent</ul>\n";
        }

        /**
         * Start element.
         *
         * @param string   $output Used to append additional content (passed by reference).
         * @param WP_Post  $item   Menu item data object.
         * @param int      $depth  Depth of menu item. Used for padding.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         * @param int      $id     Current item ID.
         */
        public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
            $classes = empty( $item->classes ) ? [] : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;
            $class_names = join( ' ', array_filter( $classes ) );
            $class_names = ' class="' . esc_attr( $class_names ) . '"';

            $output .= $indent . '<li' . $class_names . '>';

            $atts = [
                'title'  => ! empty( $item->attr_title ) ? $item->attr_title : '',
                'target' => ! empty( $item->target ) ? $item->target : '',
                'rel'    => ! empty( $item->xfn ) ? $item->xfn : '',
                'href'   => ! empty( $item->url ) ? $item->url : '',
                'class'  => 'nav-link'
            ];

            // Social menu customization
            if ( $args->theme_location === 'social' ) {
                $atts['target'] = '_blank';
                $atts['rel'] = 'noopener noreferrer';
                $atts['class'] .= ' social-link';
            }

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $title = apply_filters( 'the_title', $item->title, $item->ID );
            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }

        /**
         * End element.
         *
         * @param string   $output Used to append additional content (passed by reference).
         * @param WP_Post  $item   Page data object. Not used.
         * @param int      $depth  Depth of page. Not used.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         */
        public function end_el( &$output, $item, $depth = 0, $args = null ) {
            $output .= "</li>\n";
        }
    }
}
