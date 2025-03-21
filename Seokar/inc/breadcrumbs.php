<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_Breadcrumbs {

    public function __construct() {
        add_action('wp_head', [$this, 'add_schema_json_ld']); // افزودن داده‌های ساختاریافته سئو
    }

    /**
     * **۱. نمایش مسیر راهنما**
     */
    public static function display_breadcrumbs() {
        if (is_front_page()) return; // عدم نمایش در صفحه اصلی

        echo '<nav class="seokar-breadcrumbs" aria-label="Breadcrumb">';
        echo '<ul itemscope itemtype="https://schema.org/BreadcrumbList">';
        
        // لینک صفحه اصلی
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<a href="' . home_url() . '" itemprop="item"><span itemprop="name">🏠 صفحه اصلی</span></a>';
        echo '<meta itemprop="position" content="1">';
        echo '</li>';

        $position = 2; // موقعیت آیتم‌ها در ساختار

        if (is_category() || is_single()) {
            $category = get_the_category();
            if ($category) {
                echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                echo '<a href="' . get_category_link($category[0]->term_id) . '" itemprop="item">';
                echo '<span itemprop="name">' . esc_html($category[0]->name) . '</span></a>';
                echo '<meta itemprop="position" content="' . $position . '">';
                echo '</li>';
                $position++;
            }

            if (is_single()) {
                echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                echo '<span itemprop="name">' . get_the_title() . '</span>';
                echo '<meta itemprop="position" content="' . $position . '">';
                echo '</li>';
            }
        } elseif (is_page()) {
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<span itemprop="name">' . get_the_title() . '</span>';
            echo '<meta itemprop="position" content="' . $position . '">';
            echo '</li>';
        } elseif (is_archive()) {
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<span itemprop="name">' . post_type_archive_title('', false) . '</span>';
            echo '<meta itemprop="position" content="' . $position . '">';
            echo '</li>';
        } elseif (is_search()) {
            echo '<li><span>🔍 نتایج جستجو برای: ' . get_search_query() . '</span></li>';
        } elseif (is_404()) {
            echo '<li><span>❌ صفحه موردنظر یافت نشد</span></li>';
        }

        echo '</ul>';
        echo '</nav>';
    }

    /**
     * **۲. افزودن داده‌های ساختاریافته (`JSON-LD Schema`) برای سئو**
     */
    public function add_schema_json_ld() {
        if (is_front_page()) return;

        $breadcrumbs = [];
        $breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'صفحه اصلی',
            'item' => home_url(),
        ];

        $position = 2;

        if (is_category() || is_single()) {
            $category = get_the_category();
            if ($category) {
                $breadcrumbs[] = [
                    '@type' => 'ListItem',
                    'position' => $position,
                    'name' => esc_html($category[0]->name),
                    'item' => get_category_link($category[0]->term_id),
                ];
                $position++;
            }

            if (is_single()) {
                $breadcrumbs[] = [
                    '@type' => 'ListItem',
                    'position' => $position,
                    'name' => get_the_title(),
                    'item' => get_permalink(),
                ];
            }
        } elseif (is_page()) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => get_the_title(),
                'item' => get_permalink(),
            ];
        } elseif (is_archive()) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => post_type_archive_title('', false),
                'item' => get_post_type_archive_link(get_post_type()),
            ];
        } elseif (is_search()) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => 'نتایج جستجو: ' . get_search_query(),
            ];
        } elseif (is_404()) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => 'خطای ۴۰۴ - صفحه یافت نشد',
            ];
        }

        $json_ld = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbs,
        ];

        echo '<script type="application/ld+json">' . json_encode($json_ld, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>';
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
new Seokar_Breadcrumbs();
