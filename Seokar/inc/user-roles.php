<?php
if (!defined('ABSPATH')) exit; // امنیت: جلوگیری از دسترسی مستقیم

class Seokar_User_Roles {

    // **۱. مقداردهی اولیه نقش‌های سفارشی هنگام فعال‌سازی قالب**
    public static function add_custom_roles() {
        add_role(
            'seo_manager',
            'مدیر سئو',
            [
                'read'         => true,
                'edit_posts'   => true,
                'edit_pages'   => true,
                'manage_options' => true,
                'edit_theme_options' => true,
                'moderate_comments' => true,
            ]
        );

        add_role(
            'content_editor',
            'ویرایشگر محتوا',
            [
                'read'         => true,
                'edit_posts'   => true,
                'publish_posts' => true,
                'edit_others_posts' => true,
                'delete_posts' => false,
            ]
        );

        add_role(
            'support_agent',
            'پشتیبان سایت',
            [
                'read'         => true,
                'edit_posts'   => false,
                'moderate_comments' => true,
                'manage_categories' => true,
            ]
        );
    }

    // **۲. حذف نقش‌های سفارشی هنگام غیرفعال‌سازی قالب**
    public static function remove_custom_roles() {
        remove_role('seo_manager');
        remove_role('content_editor');
        remove_role('support_agent');
    }

    // **۳. افزودن قابلیت‌های سفارشی به نقش‌های موجود**
    public static function add_capabilities() {
        $role = get_role('administrator');
        if ($role) {
            $role->add_cap('edit_theme_options'); // اجازه دسترسی به تنظیمات قالب
            $role->add_cap('manage_options'); // اجازه دسترسی به تنظیمات عمومی وردپرس
        }

        $editor_role = get_role('editor');
        if ($editor_role) {
            $editor_role->add_cap('moderate_comments'); // اجازه مدیریت نظرات
        }
    }

    // **۴. حذف قابلیت‌های سفارشی هنگام غیرفعال‌سازی قالب**
    public static function remove_capabilities() {
        $role = get_role('administrator');
        if ($role) {
            $role->remove_cap('edit_theme_options');
            $role->remove_cap('manage_options');
        }

        $editor_role = get_role('editor');
        if ($editor_role) {
            $editor_role->remove_cap('moderate_comments');
        }
    }
}

// **۵. اجرای تغییرات هنگام فعال‌سازی قالب**
add_action('after_switch_theme', ['Seokar_User_Roles', 'add_custom_roles']);
add_action('after_switch_theme', ['Seokar_User_Roles', 'add_capabilities']);

// **۶. اجرای تغییرات هنگام غیرفعال‌سازی قالب**
add_action('switch_theme', ['Seokar_User_Roles', 'remove_custom_roles']);
add_action('switch_theme', ['Seokar_User_Roles', 'remove_capabilities']);
