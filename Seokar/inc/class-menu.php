<?php
namespace Seokar;

defined('ABSPATH') || exit;

/**
 * **مدیریت منوها و سایدبارهای قالب**
 */
class Menus {

    /**
     * **۱. مقداردهی اولیه کلاس و اتصال هوک‌ها**
     */
    public static function register() {
        add_action('init', [__CLASS__, 'register_menus']);
        add_action('widgets_init', [__CLASS__, 'register_sidebars']);
        add_filter('nav_menu_css_class', [__CLASS__, 'add_custom_menu_classes'], 10, 4);
        add_filter('nav_menu_link_attributes', [__CLASS__, 'add_custom_menu_link_attributes'], 10, 4);
    }

    /**
     * **۲. ثبت منوهای قالب**
     */
    public static function register_menus() {
        register_nav_menus([
            'primary'   => __('منوی اصلی', 'seokar'),
            'footer'    => __('منوی فوتر', 'seokar'),
            'social'    => __('منوی شبکه‌های اجتماعی', 'seokar'),
        ]);
    }

    /**
     * **۳. ثبت سایدبارهای قالب**
     */
    public static function register_sidebars() {
        $sidebars = [
            [
                'name'          => __('سایدبار اصلی', 'seokar'),
                'id'            => 'seokar_sidebar',
                'description'   => __('ابزارک‌های سایدبار را در اینجا اضافه کنید.', 'seokar'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ],
            [
                'name'          => __('سایدبار فوتر', 'seokar'),
                'id'            => 'footer_sidebar',
                'description'   => __('ابزارک‌های فوتر را در اینجا اضافه کنید.', 'seokar'),
                'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="footer-widget-title">',
                'after_title'   => '</h2>',
            ],
        ];

        foreach ($sidebars as $sidebar) {
            register_sidebar($sidebar);
        }
    }

    /**
     * **۴. افزودن کلاس‌های سفارشی به آیتم‌های منو**
     *
     * @param array  $classes کلاس‌های CSS آیتم `<li>`.
     * @param object $item آیتم منو.
     * @param object $args آرگومان‌های `wp_nav_menu()`.
     * @param int    $depth عمق منو.
     * @return array کلاس‌های اصلاح شده.
     */
    public static function add_custom_menu_classes($classes, $item, $args, $depth) {
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
     * **۵. افزودن ویژگی‌های سفارشی به لینک‌های منو**
     *
     * @param array  $atts ویژگی‌های HTML تگ `<a>`.
     * @param object $item آیتم منو.
     * @param object $args آرگومان‌های `wp_nav_menu()`.
     * @param int    $depth عمق منو.
     * @return array ویژگی‌های اصلاح شده.
     */
    public static function add_custom_menu_link_attributes($atts, $item, $args, $depth) {
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

// **۶. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
Menus::register();
