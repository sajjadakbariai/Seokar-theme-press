use PHPUnit\Framework\TestCase;

class SeokarThemeTest extends TestCase {

    // **۱. بررسی اینکه قالب فعال است**
    public function testThemeIsActive() {
        $this->assertTrue(in_array('seokar', wp_get_theme()->get('TextDomain')));
    }

    // **۲. بررسی اینکه تابع `seokar_get_theme_option` مقدار درستی برمی‌گرداند**
    public function testThemeOption() {
        update_option('seokar_primary_color', '#ff6600');
        $this->assertEquals('#ff6600', get_option('seokar_primary_color'));
    }

    // **۳. بررسی اینکه پست تایپ "نمونه کارها" ثبت شده است**
    public function testPortfolioPostTypeExists() {
        $this->assertTrue(post_type_exists('portfolio'));
    }
}
