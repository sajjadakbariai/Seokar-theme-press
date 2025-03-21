<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_Legacy_Browsers {

    public function __construct() {
        add_action('wp_footer', [$this, 'legacy_browser_warning']);
        add_action('wp_head', [$this, 'enqueue_polyfills']);
        add_action('wp_head', [$this, 'block_old_ie']);
    }

    /**
     * **۱. نمایش پیام هشدار برای کاربران مرورگرهای قدیمی**
     */
    public function legacy_browser_warning() {
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
                } else if (/Firefox\/([0-9]+)/.test(ua)) {
                    var firefoxVersion = parseInt(ua.match(/Firefox\/([0-9]+)/)[1]);
                    if (firefoxVersion < 70) outdated = true; // شناسایی نسخه‌های قدیمی Firefox
                }

                if (outdated) {
                    var warningDiv = document.createElement("div");
                    warningDiv.style.cssText = "position: fixed; top: 0; left: 0; width: 100%; background: red; color: white; text-align: center; padding: 10px; z-index: 9999;";
                    warningDiv.innerHTML = "🚨 مرورگر شما قدیمی است! لطفاً مرورگر خود را به‌روز کنید تا سایت به درستی نمایش داده شود.";
                    document.body.prepend(warningDiv);
                }
            });
        </script>
        <?php
    }

    /**
     * **۲. بارگذاری Polyfill برای مرورگرهای قدیمی**
     */
    public function enqueue_polyfills() {
        ?>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default,es6,fetch"></script>
        <?php
    }

    /**
     * **۳. جلوگیری از بارگذاری سایت در IE10 و پایین‌تر**
     */
    public function block_old_ie() {
        ?>
        <script>
            if (navigator.userAgent.indexOf("MSIE") !== -1 || navigator.appVersion.indexOf('Trident/') > 0) {
                document.body.innerHTML = '<div style="text-align: center; padding: 50px; font-size: 20px; background: #333; color: white;">🚫 این سایت از Internet Explorer پشتیبانی نمی‌کند. لطفاً مرورگر خود را ارتقا دهید.</div>';
            }
        </script>
        <?php
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
new Seokar_Legacy_Browsers();
