<?php
if (!defined('ABSPATH')) exit; // امنیت: جلوگیری از دسترسی مستقیم

class Seokar_Theme_Hooks {

    // **۱. مقداردهی اولیه هوک‌ها هنگام راه‌اندازی قالب**
    public function __construct() {
        add_action('wp_head', [$this, 'add_custom_meta_tags']);
        add_action('wp_footer', [$this, 'add_back_to_top_button']);
        add_filter('body_class', [$this, 'add_custom_body_classes']);
    }

    // **۲. افزودن متا تگ‌های سفارشی در `<head>`**
    public function add_custom_meta_tags() {
        echo '<meta name="author" content="Seokar Theme">' . "\n";
        echo '<meta name="viewport" content="width=device-width, initial-scale=1">' . "\n";
    }

    // **۳. افزودن دکمه بازگشت به بالا در فوتر**
    public function add_back_to_top_button() {
        if (get_theme_mod('seokar_show_back_to_top', true)) {
            echo '<button id="back-to-top" class="back-to-top">⬆</button>';
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const backToTop = document.getElementById("back-to-top");
                        window.addEventListener("scroll", function() {
                            backToTop.style.display = (window.scrollY > 300) ? "block" : "none";
                        });
                        backToTop.addEventListener("click", function() {
                            window.scrollTo({ top: 0, behavior: "smooth" });
                        });
                    });
                  </script>';
        }
    }

    // **۴. افزودن کلاس‌های سفارشی به `<body>` برای شخصی‌سازی استایل‌ها**
    public function add_custom_body_classes($classes) {
        if (is_singular()) {
            $classes[] = 'single-post-view';
        }
        if (get_theme_mod('seokar_primary_color') === '#ff0000') {
            $classes[] = 'theme-red';
        }
        return $classes;
    }
}

// **۵. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
new Seokar_Theme_Hooks();
