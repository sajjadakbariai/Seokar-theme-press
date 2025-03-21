function seokar_register_block_patterns() {
    if (!function_exists('register_block_pattern')) {
        return;
    }

    // **۱. ثبت الگوی بلوک "بخش معرفی"**
    register_block_pattern(
        'seokar/intro-section',
        array(
            'title'       => 'بخش معرفی',
            'description' => 'یک بخش ساده شامل عنوان، متن و دکمه',
            'categories'  => array('seokar-patterns'),
            'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"50px","bottom":"50px"}}}} -->
            <div class="wp-block-group alignfull" style="padding-top:50px;padding-bottom:50px;">
                <h2>به سایت ما خوش آمدید!</h2>
                <p>این یک نمونه از بلوک‌های آماده وردپرس است.</p>
                <a class="wp-block-button__link" href="#">بیشتر بخوانید</a>
            </div>
            <!-- /wp:group -->',
        )
    );

    // **۲. ثبت الگوی بلوک "بخش تماس با ما"**
    register_block_pattern(
        'seokar/contact-section',
        array(
            'title'       => 'بخش تماس با ما',
            'description' => 'یک بخش ساده برای فرم تماس',
            'categories'  => array('seokar-patterns'),
            'content'     => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"50px","bottom":"50px"}}}} -->
            <div class="wp-block-group alignfull" style="padding-top:50px;padding-bottom:50px;">
                <h2>تماس با ما</h2>
                <p>با ما در ارتباط باشید.</p>
                <form>
                    <input type="text" placeholder="نام شما" />
                    <input type="email" placeholder="ایمیل شما" />
                    <textarea placeholder="پیام شما"></textarea>
                    <button type="submit">ارسال</button>
                </form>
            </div>
            <!-- /wp:group -->',
        )
    );
}
add_action('init', 'seokar_register_block_patterns');
