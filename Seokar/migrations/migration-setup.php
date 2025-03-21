class Seokar_Migrations {
    
    // **۱. مقداردهی اولیه کلاس و بررسی نیاز به مهاجرت**
    public function __construct() {
        add_action('after_setup_theme', array($this, 'check_migrations'));
    }

    // **۲. بررسی نسخه قالب و اجرای مهاجرت در صورت نیاز**
    public function check_migrations() {
        $current_version = '1.0.1'; // نسخه جدید قالب
        $db_version = get_option('seokar_db_version', '1.0.0');

        if (version_compare($db_version, $current_version, '<')) {
            $this->run_migrations($db_version, $current_version);
        }
    }

    // **۳. اجرای اسکریپت‌های مهاجرت بر اساس نسخه قالب**
    private function run_migrations($old_version, $new_version) {
        global $wpdb;

        // **الف. ایجاد یک جدول سفارشی برای ذخیره آمار بازدید**
        if ($old_version === '1.0.0') {
            $table_name = $wpdb->prefix . 'seokar_visits';
            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $table_name (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                post_id BIGINT UNSIGNED NOT NULL,
                visit_count INT UNSIGNED NOT NULL DEFAULT 0,
                last_visited TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) $charset_collate;";

            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($sql);
        }

        // **ب. به‌روزرسانی متا داده‌های قدیمی**
        if ($old_version === '1.0.0') {
            $wpdb->query("UPDATE {$wpdb->postmeta} SET meta_key = '_seokar_old_key' WHERE meta_key = 'old_key'");
        }

        // **۴. ذخیره نسخه جدید در دیتابیس**
        update_option('seokar_db_version', $new_version);
    }
}

// **۵. مقداردهی اولیه کلاس هنگام بارگذاری قالب**
new Seokar_Migrations();
