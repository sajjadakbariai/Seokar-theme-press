<?php
if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

class Seokar_Error_Handling {

    private $log_file;

    public function __construct() {
        $this->log_file = WP_CONTENT_DIR . '/seokar-error-log.txt';

        set_error_handler([$this, 'handle_errors']);
        set_exception_handler([$this, 'handle_exceptions']);
        register_shutdown_function([$this, 'handle_fatal_errors']);
    }

    /**
     * **۱. مدیریت خطاهای PHP و ثبت در فایل لاگ**
     */
    public function handle_errors($errno, $errstr, $errfile, $errline) {
        if (!(error_reporting() & $errno)) {
            return;
        }

        $message = "[خطا] نوع: $errno | پیام: $errstr | فایل: $errfile | خط: $errline";
        $this->log_error($message);

        if (WP_DEBUG) {
            echo "<strong>⚠️ خطا:</strong> $errstr در خط $errline از فایل $errfile";
        }

        return true;
    }

    /**
     * **۲. مدیریت استثناها (Exceptions)**
     */
    public function handle_exceptions($exception) {
        $message = "[استثنا] پیام: " . $exception->getMessage() . " | فایل: " . $exception->getFile() . " | خط: " . $exception->getLine();
        $this->log_error($message);

        if (WP_DEBUG) {
            echo "<strong>⚠️ استثنا:</strong> " . $exception->getMessage();
        } else {
            $this->show_friendly_error_page();
        }
    }

    /**
     * **۳. مدیریت خطاهای مرگبار (Fatal Errors)**
     */
    public function handle_fatal_errors() {
        $error = error_get_last();
        if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            $message = "[خطای بحرانی] پیام: {$error['message']} | فایل: {$error['file']} | خط: {$error['line']}";
            $this->log_error($message);

            if (!WP_DEBUG) {
                $this->show_friendly_error_page();
            }
        }
    }

    /**
     * **۴. ثبت خطاها در فایل لاگ**
     */
    private function log_error($message) {
        $timestamp = date("Y-m-d H:i:s");
        error_log("[$timestamp] $message\n", 3, $this->log_file);
        
        // ارسال ایمیل در صورت وقوع خطای بحرانی
        if (strpos($message, '[خطای بحرانی]') !== false) {
            wp_mail(get_option('admin_email'), '🚨 خطای بحرانی در سایت!', $message);
        }
    }

    /**
     * **۵. نمایش صفحه خطای سفارشی**
     */
    private function show_friendly_error_page() {
        wp_die(
            '<h1>🚧 خطایی رخ داده است</h1><p>متأسفیم، مشکلی در پردازش درخواست شما پیش آمده است.</p><a href="' . home_url() . '" class="button">بازگشت به صفحه اصلی</a>',
            'خطای سایت',
            ['response' => 500]
        );
    }
}

// مقداردهی اولیه کلاس هنگام بارگذاری قالب
new Seokar_Error_Handling();
