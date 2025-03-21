<?php
if (!defined('ABSPATH')) exit; // امنیت: جلوگیری از دسترسی مستقیم

class Seokar_WebP_Support {

    // **۱. بررسی پشتیبانی از WebP در مرورگر**
    public static function is_webp_supported() {
        return isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false;
    }

    // **۲. جایگزینی خودکار تصاویر JPG/PNG با WebP در محتوا**
    public static function replace_images_with_webp($content) {
        if (self::is_webp_supported()) {
            $content = preg_replace('/\.(jpg|jpeg|png)/i', '.webp', $content);
        }
        return $content;
    }

    // **۳. تبدیل خودکار تصاویر به WebP هنگام آپلود**
    public static function convert_image_to_webp($metadata, $attachment_id) {
        $upload_dir = wp_upload_dir();
        $file_path  = $upload_dir['basedir'] . '/' . $metadata['file'];

        // بررسی نوع فایل و تبدیل به WebP
        $ext   = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        $webp_path = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $file_path);

        if (function_exists('imagewebp') && file_exists($file_path) && !file_exists($webp_path)) {
            $image = null;

            if ($ext === 'jpg' || $ext === 'jpeg') {
                $image = imagecreatefromjpeg($file_path);
            } elseif ($ext === 'png') {
                $image = imagecreatefrompng($file_path);
                imagepalettetotruecolor($image); // برای بهبود کیفیت تصاویر PNG
                imagealphablending($image, true);
                imagesavealpha($image, true);
            }

            if ($image) {
                imagewebp($image, $webp_path, 80); // کیفیت 80٪
                imagedestroy($image);
            }
        }

        return $metadata;
    }
}

// **۴. اعمال فیلترها**
add_filter('the_content', ['Seokar_WebP_Support', 'replace_images_with_webp']);
add_filter('wp_generate_attachment_metadata', ['Seokar_WebP_Support', 'convert_image_to_webp'], 10, 2);
