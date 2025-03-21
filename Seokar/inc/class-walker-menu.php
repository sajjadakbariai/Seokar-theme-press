<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

if (!class_exists('Seokar_Walker_Nav_Menu')) {

    class Seokar_Walker_Nav_Menu extends Walker_Nav_Menu {

        /**
         * **۱. شروع سطح جدید منو (زیرمنوها)**
         */
        public function start_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            $submenu_class = $depth > 0 ? 'sub-sub-menu' : 'sub-menu';
            $output .= "\n$indent<ul class=\"$submenu_class\">\n";
        }

        /**
         * **۲. پایان سطح منو**
         */
        public function end_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }

        /**
         * **۳. شروع عنصر منو (یک آیتم)**
         */
        public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $indent = ($depth) ? str_repeat("\t", $depth) : '';

            // کلاس‌های سفارشی برای آیتم منو
            $classes = empty($item->classes) ? [] : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;
            if ($depth === 0) {
                $classes[] = 'top-menu-item';
            }
            $class_names = ' class="' . esc_attr(join(' ', array_filter($classes))) . '"';

            // ایجاد HTML برای لیست آیتم
            $output .= $indent . '<li' . $class_names . '>';

            // تنظیمات لینک
            $atts = [
                'title'  => !empty($item->attr_title) ? $item->attr_title : '',
                'target' => !empty($item->target) ? $item->target : '',
                'rel'    => !empty($item->xfn) ? $item->xfn : '',
                'href'   => !empty($item->url) ? $item->url : '',
                'class'  => 'nav-link',
            ];

            // مدیریت لینک‌های منوی شبکه‌های اجتماعی
            if ($args->theme_location === 'social') {
                $atts['target'] = '_blank';
                $atts['rel'] .= ' noopener noreferrer';
                $atts['class'] .= ' social-link';
            }

            // تبدیل آرایه `atts` به استرینگ HTML
            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= " $attr=\"$value\"";
                }
            }

            // خروجی نهایی آیتم منو
            $title = apply_filters('the_title', $item->title, $item->ID);
            $item_output  = $args->before;
            $item_output .= "<a$attributes>";
            $item_output .= $args->link_before . $title . $args->link_after;
            if (in_array('menu-item-has-children', $classes)) {
                $item_output .= '<span class="submenu-toggle">▼</span>';
            }
            $item_output .= "</a>";
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

        /**
         * **۴. پایان آیتم منو**
         */
        public function end_el(&$output, $item, $depth = 0, $args = null) {
            $output .= "</li>\n";
        }
    }
}
