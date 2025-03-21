<?php
/**
 * Autoloader for Seokar Theme
 */

defined('ABSPATH') || exit; // جلوگیری از دسترسی مستقیم

spl_autoload_register(function ($class) {
    $prefix = 'Seokar\\';
    $base_dir = __DIR__ . '/';

    // بررسی اینکه کلاس متعلق به فضای نام Seokar است
    if (strpos($class, $prefix) !== 0) {
        return;
    }

    // تبدیل کلاس به مسیر فایل
    $relative_class = substr($class, strlen($prefix));
    $file = $base_dir . str_replace(['\\', '_'], '/', $relative_class) . '.php';

    // بررسی وجود فایل و بارگذاری آن
    if (file_exists($file)) {
        require_once $file;
    } else {
        error_log("[Autoload Error] فایل یافت نشد: " . $file);
    }
});
