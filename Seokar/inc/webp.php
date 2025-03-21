// **۱. بررسی پشتیبانی از WebP**
function seokar_is_webp_supported() {
    return strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false;
}

// **۲. تغییر مسیر تصاویر برای استفاده از نسخه WebP در صورتی که موجود باشد**
function seokar_replace_images_with_webp($content) {
    if (seokar_is_webp_supported()) {
        $content = preg_replace('/\.(jpg|jpeg|png)/i', '.webp', $content);
    }
    return $content;
}
add_filter('the_content', 'seokar_replace_images_with_webp');

// **۳. تبدیل خودکار تصاویر جدید به WebP هنگام آپلود**
function seokar_convert_image_to_webp($metadata, $attachment_id) {
    $upload_dir = wp_upload_dir();
    $file_path  = $upload_dir['basedir'] . '/' . $metadata['file'];
    $webp_path  = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $file_path);

    if (function_exists('imagewebp') && file_exists($file_path)) {
        $image = null;
        $ext   = pathinfo($file_path, PATHINFO_EXTENSION);

        if ($ext === 'jpg' || $ext === 'jpeg') {
            $image = imagecreatefromjpeg($file_path);
        } elseif ($ext === 'png') {
            $image = imagecreatefrompng($file_path);
        }

        if ($image) {
            imagewebp($image, $webp_path, 80); // کیفیت 80٪
            imagedestroy($image);
        }
    }

    return $metadata;
}
add_filter('wp_generate_attachment_metadata', 'seokar_convert_image_to_webp', 10, 2);
