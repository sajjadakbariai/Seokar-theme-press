<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_SEO {

    public function __construct() {
        add_action('wp_head', [$this, 'add_meta_tags'], 1);
        add_filter('document_title_parts', [$this, 'customize_title']);
        add_action('wp_head', [$this, 'add_schema_markup'], 2);
    }

    // **۱. افزودن متا تگ‌های سئو به `<head>`**
    public function add_meta_tags() {
        global $post;

        // بررسی اگر صفحه آرشیو، نتایج جستجو یا دسته‌بندی بود
        if (is_archive() || is_search()) {
            echo '<meta name="robots" content="noindex, follow">' . "\n";
            return;
        }

        if (is_single() || is_page()) {
            $meta_description = get_post_meta($post->ID, '_meta_description', true);
            $meta_keywords = get_post_meta($post->ID, '_meta_keywords', true);
            $noindex = get_post_meta($post->ID, '_noindex', true);

            if (!$meta_description) {
                $meta_description = wp_trim_words(strip_tags($post->post_content), 30, '...');
            }

            echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
            if (!empty($meta_keywords)) {
                echo '<meta name="keywords" content="' . esc_attr($meta_keywords) . '">' . "\n";
            }
            if ($noindex) {
                echo '<meta name="robots" content="noindex, nofollow">' . "\n";
            }
        }
    }

    // **۲. شخصی‌سازی عنوان صفحه برای سئوی بهتر**
    public function customize_title($title) {
        if (is_single() || is_page()) {
            global $post;
            $custom_title = get_post_meta($post->ID, '_meta_title', true);
            if ($custom_title) {
                $title['title'] = esc_html($custom_title);
            }
        }
        return $title;
    }

    // **۳. افزودن داده‌های ساختاری (Schema Markup) حرفه‌ای**
    public function add_schema_markup() {
        if (!is_single() && !is_page()) return;

        global $post;

        $schema = [
            "@context" => "https://schema.org",
            "@type"    => "Article",
            "headline" => esc_html(get_the_title()),
            "author"   => [
                "@type" => "Person",
                "name"  => esc_html(get_the_author()),
            ],
            "publisher" => [
                "@type" => "Organization",
                "name"  => esc_html(get_bloginfo('name')),
                "logo"  => [
                    "@type"  => "ImageObject",
                    "url"    => esc_url(get_theme_mod('seokar_logo', get_site_icon_url())),
                    "width"  => 200,
                    "height" => 60
                ]
            ],
            "datePublished" => get_the_date('c'),
            "dateModified"  => get_the_modified_date('c'),
            "mainEntityOfPage" => get_permalink(),
            "description" => esc_html(wp_trim_words(strip_tags(get_the_content()), 30, '...')),
            "image" => [
                "@type"  => "ImageObject",
                "url"    => esc_url(get_the_post_thumbnail_url($post->ID, 'full')),
                "width"  => 1200,
                "height" => 628
            ]
        ];

        if (is_singular('product')) {
            $schema["@type"] = "Product";
            $schema["brand"] = get_bloginfo('name');
            $schema["sku"] = get_post_meta($post->ID, '_sku', true);
            $schema["offers"] = [
                "@type" => "Offer",
                "price" => get_post_meta($post->ID, '_price', true),
                "priceCurrency" => "IRR",
                "availability" => "https://schema.org/InStock",
                "url" => get_permalink()
            ];
        }

        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>';
    }
}

// **۴. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
new Seokar_SEO();
