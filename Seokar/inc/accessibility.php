<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_Accessibility {

    public function __construct() {
        add_action('wp_footer', [$this, 'add_accessibility_toolbar']);
        add_action('wp_head', [$this, 'add_screen_reader_styles']);
    }

    /**
     * **۱. افزودن کلیدهای میانبر برای ناوبری سریع**
     */
    public static function add_keyboard_shortcuts() {
        ?>
        <script>
            document.addEventListener("keydown", function (e) {
                if (e.altKey && e.key === "1") {
                    window.location.href = "<?php echo esc_url(home_url()); ?>"; // Alt + 1: صفحه اصلی
                }
                if (e.altKey && e.key === "2") {
                    window.location.href = "<?php echo esc_url(home_url('/contact')); ?>"; // Alt + 2: صفحه تماس با ما
                }
            });
        </script>
        <?php
    }
    add_action('wp_footer', 'Seokar_Accessibility::add_keyboard_shortcuts');

    /**
     * **۲. نوار ابزار دسترسی‌پذیری (افزایش فونت و کنتراست)**
     */
    public function add_accessibility_toolbar() {
        ?>
        <div id="accessibility-toolbar" class="accessibility-toolbar">
            <button id="increase-font" title="بزرگ‌تر کردن متن">A+</button>
            <button id="decrease-font" title="کوچک‌تر کردن متن">A-</button>
            <button id="toggle-contrast" title="تغییر کنتراست رنگی">⚫/⚪</button>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const increaseFontBtn = document.getElementById("increase-font");
                const decreaseFontBtn = document.getElementById("decrease-font");
                const contrastBtn = document.getElementById("toggle-contrast");

                increaseFontBtn.addEventListener("click", function () {
                    document.body.style.fontSize = (parseFloat(getComputedStyle(document.body).fontSize) + 2) + "px";
                });

                decreaseFontBtn.addEventListener("click", function () {
                    document.body.style.fontSize = (parseFloat(getComputedStyle(document.body).fontSize) - 2) + "px";
                });

                contrastBtn.addEventListener("click", function () {
                    document.body.classList.toggle("high-contrast");
                });
            });
        </script>
        <style>
            .accessibility-toolbar {
                position: fixed;
                bottom: 20px;
                left: 20px;
                background: #000;
                color: #fff;
                padding: 10px;
                border-radius: 5px;
                z-index: 9999;
            }
            .accessibility-toolbar button {
                background: none;
                color: #fff;
                border: none;
                cursor: pointer;
                margin: 5px;
                font-size: 16px;
            }
            .high-contrast {
                background: #000 !important;
                color: #ff0 !important;
            }
        </style>
        <?php
    }

    /**
     * **۳. افزودن استایل‌های لازم برای صفحه‌خوان‌ها**
     */
    public function add_screen_reader_styles() {
        ?>
        <style>
            .screen-reader-text {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                border: 0;
            }
            .screen-reader-text:focus {
                position: static;
                width: auto;
                height: auto;
                margin: 0;
                clip: auto;
            }
        </style>
        <?php
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
new Seokar_Accessibility();
