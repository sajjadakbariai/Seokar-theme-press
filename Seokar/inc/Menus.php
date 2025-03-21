<?php
namespace Seokar;

defined('ABSPATH') || exit;

class Menus {

    /**
     * **۱. مقداردهی اولیه کلاس و اتصال هوک‌ها**
     */
    public static function register() {
        add_action('after_setup_theme', [__CLASS__, 'register_menus']);
        add_filter('nav_menu_css_class', [__CLASS__, 'add_menu_item_class'], 10, 3);
        add_filter('nav_menu_link_attributes', [__CLASS__, 'add_menu_link_class'], 10, 3);
    }

    /**
     * **۲. ثبت منوهای قالب**
     */
    public static function register_menus() {
        register_nav_menus([
            'primary' => __('منوی اصلی', 'seokar'),
            'footer'  => __('منوی فوتر', 'seokar'),
            'social'  => __('منوی شبکه‌های اجتماعی', 'seokar'),
        ]);
    }

    /**
     * **۳. افزودن کلاس‌های سفارشی به آیتم‌های منو**
     *
     * @param array  $classes کلاس‌های CSS آیتم `<li>`.
     * @param object $item آیتم منو.
     * @param object $args آرگومان‌های `wp_nav_menu()`.
     * @return array کلاس‌های اصلاح شده.
     */
    public static function add_menu_item_class($classes, $item, $args) {
        $menu_classes = [
            'primary' => 'nav-item',
            'footer'  => 'footer-item',
            'social'  => 'social-item',
        ];

        if (isset($menu_classes[$args->theme_location])) {
            $classes[] = $menu_classes[$args->theme_location];
        }

        return $classes;
    }

    /**
     * **۴. افزودن ویژگی‌های سفارشی به لینک‌های منو**
     *
     * @param array  $atts ویژگی‌های HTML تگ `<a>`.
     * @param object $item آیتم منو.
     * @param object $args آرگومان‌های `wp_nav_menu()`.
     * @return array ویژگی‌های اصلاح شده.
     */
    public static function add_menu_link_class($atts, $item, $args) {
        $menu_link_classes = [
            'primary' => 'nav-link',
            'footer'  => 'footer-link',
            'social'  => 'social-link',
        ];

        if (isset($menu_link_classes[$args->theme_location])) {
            $atts['class'] = $menu_link_classes[$args->theme_location];
        }

        if ($args->theme_location === 'social') {
            $atts['target'] = '_blank';
            $atts['rel'] = 'noopener noreferrer';
        }

        return $atts;
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
Menus::register();
