// **۱. افزودن کلیدهای میانبر برای دسترسی سریع**
function seokar_accessibility_shortcuts() {
    ?>
    <script>
        document.addEventListener("keydown", function (e) {
            if (e.altKey && e.key === "1") {
                window.location.href = "<?php echo esc_url(home_url()); ?>"; // کلید Alt + 1 برای رفتن به صفحه اصلی
            }
            if (e.altKey && e.key === "2") {
                window.location.href = "<?php echo esc_url(home_url('/contact')); ?>"; // کلید Alt + 2 برای رفتن به صفحه تماس با ما
            }
        });
    </script>
    <?php
}
add_action('wp_footer', 'seokar_accessibility_shortcuts');

// **۲. افزودن دکمه‌های تغییر اندازه متن و کنتراست رنگی**
function seokar_accessibility_toolbar() {
    ?>
    <div id="accessibility-toolbar" style="position: fixed; bottom: 20px; left: 20px; background: #000; color: #fff; padding: 10px; border-radius: 5px; z-index: 9999;">
        <button id="increase-font" style="background: none; color: #fff; border: none; cursor: pointer;">A+</button>
        <button id="decrease-font" style="background: none; color: #fff; border: none; cursor: pointer;">A-</button>
        <button id="toggle-contrast" style="background: none; color: #fff; border: none; cursor: pointer;">⚫/⚪</button>
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
        .high-contrast {
            background: #000 !important;
            color: #ff0 !important;
        }
    </style>
    <?php
}
add_action('wp_footer', 'seokar_accessibility_toolbar');

// **۳. بهبود دسترسی‌پذیری برای صفحه‌خوان‌ها**
function seokar_add_screen_reader_text() {
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
add_action('wp_head', 'seokar_add_screen_reader_text');
