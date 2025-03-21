<?php
/**
 * Template for 404 Page (Page Not Found)
 *
 * @package Seokar
 */

get_header(); ?>

<main id="main-content" class="container-404">
    <div class="content-wrapper">
        <h1 class="error-title">😢 متأسفیم! صفحه‌ای که به‌دنبال آن بودید، پیدا نشد.</h1>
        <p class="error-message">به نظر می‌رسد که این صفحه حذف شده یا آدرسی که وارد کرده‌اید اشتباه است.</p>

        <!-- فرم جستجو برای یافتن مطالب مرتبط -->
        <div class="search-container">
            <p>شاید جستجو به شما کمک کند:</p>
            <?php get_search_form(); ?>
        </div>

        <!-- پیشنهاد صفحات مهم -->
        <div class="quick-links">
            <p>می‌توانید از این صفحات بازدید کنید:</p>
            <ul>
                <li><a href="<?php echo home_url(); ?>">🏠 صفحه اصلی</a></li>
                <li><a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">📰 وبلاگ</a></li>
                <li><a href="<?php echo home_url('/contact'); ?>">📞 تماس با ما</a></li>
            </ul>
        </div>

        <!-- دکمه بازگشت به خانه -->
        <a class="back-home" href="<?php echo home_url(); ?>">🔙 بازگشت به صفحه اصلی</a>
    </div>
</main>

<?php get_footer(); ?>
