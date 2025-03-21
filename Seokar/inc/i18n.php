<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_I18n {

    public function __construct() {
        add_action('after_setup_theme', [$this, 'load_theme_textdomain']);
        add_filter('gettext', [$this, 'override_translations'], 10, 3);
        add_filter('locale', [$this, 'set_admin_language']);
    }

    /**
     * **۱. بارگذاری فایل‌های ترجمه قالب**
     */
    public function load_theme_textdomain() {
        load_theme_textdomain('seokar', get_template_directory() . '/languages');
    }

    /**
     * **۲. جایگزینی ترجمه‌های سفارشی (Override ترجمه‌های پیش‌فرض)**
     *
     * @param string $translated ترجمه شده
     * @param string $original متن اصلی
     * @param string $domain دامنه ترجمه
     * @return string ترجمه جایگزین شده
     */
    public function override_translations($translated, $original, $domain) {
        if ($domain === 'seokar') {
            $custom_translations = [
                'Read More' => __('ادامه مطلب', 'seokar'),
                'Posted on' => __('منتشر شده در', 'seokar'),
                'Comments'  => __('دیدگاه‌ها', 'seokar'),
            ];
            if (isset($custom_translations[$original])) {
                return $custom_translations[$original];
            }
        }
        return $translated;
    }

    /**
     * **۳. تنظیم زبان پنل مدیریت برای کاربران خاص**
     *
     * @param string $locale زبان فعلی
     * @return string زبان جدید
     */
    public function set_admin_language($locale) {
        if (is_admin() && get_current_user_id() == 1) {
            return 'en_US'; // تغییر زبان پنل مدیریت به انگلیسی برای مدیر سایت
        }
        return $locale;
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
new Seokar_I18n();
