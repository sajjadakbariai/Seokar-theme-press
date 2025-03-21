if (defined('WP_CLI') && WP_CLI) {
    class Seokar_CLI_Commands {
        
        // **۱. دستور ایجاد پست جدید**
        public function create_post($args, $assoc_args) {
            $title = $assoc_args['title'] ?? 'پست جدید';
            $content = $assoc_args['content'] ?? 'محتوای پیش‌فرض';
            $post_id = wp_insert_post(array(
                'post_title'   => $title,
                'post_content' => $content,
                'post_status'  => 'publish',
                'post_type'    => 'post',
            ));

            if ($post_id) {
                WP_CLI::success("پست با ID: $post_id ایجاد شد.");
            } else {
                WP_CLI::error("مشکلی در ایجاد پست رخ داد.");
            }
        }

        // **۲. دستور پاک کردن کش وردپرس**
        public function clear_cache() {
            global $wpdb;
            $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_%'");
            WP_CLI::success("تمام کش‌های وردپرس پاک شدند.");
        }

        // **۳. دستور دریافت لیست کاربران**
        public function list_users() {
            $users = get_users();
            foreach ($users as $user) {
                WP_CLI::line("ID: {$user->ID} - نام: {$user->display_name} - ایمیل: {$user->user_email}");
            }
        }
    }

    WP_CLI::add_command('seokar create-post', [new Seokar_CLI_Commands(), 'create_post']);
    WP_CLI::add_command('seokar clear-cache', [new Seokar_CLI_Commands(), 'clear_cache']);
    WP_CLI::add_command('seokar list-users', [new Seokar_CLI_Commands(), 'list_users']);
}
