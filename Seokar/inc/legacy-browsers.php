// **۱. نمایش پیام هشدار برای کاربران مرورگرهای قدیمی**
function seokar_legacy_browser_warning() {
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var outdated = false;
            var ua = window.navigator.userAgent;

            if (/MSIE|Trident/.test(ua)) {
                outdated = true; // شناسایی Internet Explorer
            } else if (/Edge\/([0-9]+)/.test(ua)) {
                var edgeVersion = parseInt(ua.match(/Edge\/([0-9]+)/)[1]);
                if (edgeVersion < 80) outdated = true; // شناسایی نسخه‌های قدیمی Edge
            } else if (/Safari/.test(ua) && !/Chrome/.test(ua)) {
                var safariVersion = ua.match(/Version\/([0-9]+)/);
                if (safariVersion && parseInt(safariVersion[1]) < 12) outdated = true; // شناسایی نسخه‌های قدیمی Safari
            }

            if (outdated) {
                var warningDiv = document.createElement("div");
                warningDiv.style.cssText = "position: fixed; top: 0; left: 0; width: 100%; background: red; color: white; text-align: center; padding: 10px; z-index: 9999;";
                warningDiv.innerHTML = "مرورگر شما قدیمی است و ممکن است سایت به درستی نمایش داده نشود. لطفاً مرورگر خود را به‌روز کنید.";
                document.body.prepend(warningDiv);
            }
        });
    </script>
    <?php
}
add_action('wp_footer', 'seokar_legacy_browser_warning');

// **۲. بارگذاری Polyfill برای مرورگرهای قدیمی**
function seokar_enqueue_polyfills() {
    ?>
    <!-- Polyfill برای پشتیبانی از ویژگی‌های مدرن در مرورگرهای قدیمی -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <?php
}
add_action('wp_head', 'seokar_enqueue_polyfills');

// **۳. جلوگیری از بارگذاری سایت در IE10 و پایین‌تر**
function seokar_block_old_ie() {
    ?>
    <!-- نمایش پیام مسدود شدن سایت برای IE10 و پایین‌تر -->
    <!--[if lt IE 11]>
    <script>
        document.body.innerHTML = '<div style="text-align: center; padding: 50px; font-size: 20px; background: #333; color: white;">لطفاً مرورگر خود را به نسخه جدیدتر ارتقا دهید. این سایت از اینترنت اکسپلورر پشتیبانی نمی‌کند.</div>';
    </script>
    <![endif]-->
    <?php
}
add_action('wp_head', 'seokar_block_old_ie');
