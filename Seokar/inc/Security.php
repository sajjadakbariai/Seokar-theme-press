<?php
namespace Seokar;

defined( 'ABSPATH' ) || exit;

class Security {
    public static function apply() {
        add_filter( 'rest_authentication_errors', [ __CLASS__, 'restrict_rest_api' ] );
        remove_action( 'wp_head', 'wp_generator' );
        remove_action( 'wp_head', 'rsd_link' );
        remove_action( 'wp_head', 'wlwmanifest_link' );
        remove_action( 'wp_head', 'rest_output_link_wp_head' );
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    }

    public static function restrict_rest_api( $access ) {
        if ( ! is_user_logged_in() ) {
            return new \WP_Error( 'rest_cannot_access', __( 'دسترسی به REST API محدود شده است.' ), [ 'status' => rest_authorization_required_code() ] );
        }
        return $access;
    }
}
// **۲. حذف نسخه وردپرس از سورس کد برای جلوگیری از شناسایی نسخه**
function seokar_remove_wp_version() {
    return '';
}
add_filter('the_generator', 'seokar_remove_wp_version');

// **۳. غیرفعال کردن XML-RPC برای جلوگیری از حملات Brute Force**
add_filter('xmlrpc_enabled', '__return_false');

// **۴. غیرفعال کردن ویرایش فایل‌های قالب و افزونه از پنل مدیریت**
define('DISALLOW_FILE_EDIT', true);

// **۵. جلوگیری از نمایش اطلاعات خطای ورود به سیستم**
function seokar_custom_login_errors() {
    return 'اطلاعات وارد شده نادرست است!';
}
add_filter('login_errors', 'seokar_custom_login_errors');

// **۶. محدود کردن تعداد تلاش‌های ورود به مدیریت (مناسب برای جلوگیری از Brute Force)**
function seokar_limit_login_attempts() {
    if (!session_id()) {
        session_start();
    }

    $max_attempts = 5;
    $lockout_time = 60 * 5; // 5 دقیقه

    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    if ($_SESSION['login_attempts'] >= $max_attempts) {
        $_SESSION['lockout_time'] = time() + $lockout_time;
    }

    if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']) {
        wp_die('شما تعداد دفعات زیادی برای ورود تلاش کردید. لطفاً بعداً دوباره امتحان کنید.');
    }
}
add_action('wp_login_failed', function () {
    $_SESSION['login_attempts']++;
});
add_action('wp_authenticate', 'seokar_limit_login_attempts');

// **۷. غیرفعال کردن نمایش نام کاربری در URL نویسنده**
function seokar_disable_author_url() {
    if (is_author()) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('template_redirect', 'seokar_disable_author_url');

// **۸. حذف متا تگ‌های غیرضروری از هد سایت**
remove_action('wp_head', 'wp_generator'); // حذف نسخه وردپرس
remove_action('wp_head', 'wlwmanifest_link'); // حذف Windows Live Writer
remove_action('wp_head', 'rsd_link'); // حذف Really Simple Discovery (RSD)
remove_action('wp_head', 'wp_shortlink_wp_head'); // حذف Shortlink
remove_action('wp_head', 'rest_output_link_wp_head'); // حذف REST API link

// **۹. حذف REST API برای کاربران غیرمجاز**
function seokar_disable_rest_api($access) {
    if (!is_user_logged_in()) {
        return new WP_Error('rest_disabled', 'REST API غیرفعال شده است.', array('status' => 403));
    }
    return $access;
}
add_filter('rest_authentication_errors', 'seokar_disable_rest_api');
