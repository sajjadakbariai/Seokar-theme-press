// **۱. ارسال ایمیل هنگام انتشار نوشته جدید**
function seokar_notify_admin_on_new_post($post_ID, $post) {
    if ($post->post_status !== 'publish') return;
    
    $admin_email = get_option('admin_email');
    $subject = 'یک نوشته جدید منتشر شد!';
    $message = "نوشته '{$post->post_title}' منتشر شد. لینک: " . get_permalink($post_ID);

    wp_mail($admin_email, $subject, $message);
}
add_action('publish_post', 'seokar_notify_admin_on_new_post', 10, 2);

// **۲. ارسال ایمیل خوش‌آمدگویی به کاربران جدید**
function seokar_welcome_new_user($user_id) {
    $user = get_userdata($user_id);
    $subject = 'خوش آمدید به سایت ما!';
    $message = "سلام {$user->display_name}، خوش آمدید! امیدواریم تجربه خوبی داشته باشید.";

    wp_mail($user->user_email, $subject, $message);
}
add_action('user_register', 'seokar_welcome_new_user');

// **۳. پاک کردن کش هنگام بروزرسانی نوشته‌ها**
function seokar_clear_cache_on_update($post_ID) {
    delete_transient('seokar_latest_posts'); // حذف کش آخرین نوشته‌ها
}
add_action('save_post', 'seokar_clear_cache_on_update');

// **۴. افزودن پیام سفارشی به داشبورد مدیریت وردپرس**
function seokar_custom_admin_notice() {
    echo '<div class="notice notice-success"><p>⭐ قالب سئوکار با موفقیت فعال شد! از تنظیمات قالب را بررسی کنید.</p></div>';
}
add_action('admin_notices', 'seokar_custom_admin_notice');
