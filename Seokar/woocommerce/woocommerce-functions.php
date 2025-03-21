// **۱. تغییر متن دکمه "افزودن به سبد خرید"**
function seokar_custom_add_to_cart_text($text) {
    return __('🛒 خرید سریع', 'seokar');
}
add_filter('woocommerce_product_single_add_to_cart_text', 'seokar_custom_add_to_cart_text');
add_filter('woocommerce_product_add_to_cart_text', 'seokar_custom_add_to_cart_text');

// **۲. نمایش تعداد محصولات فروخته‌شده در صفحه محصول**
function seokar_show_sold_count() {
    global $product;
    $sales_count = get_post_meta($product->get_id(), 'total_sales', true);
    if ($sales_count) {
        echo '<p class="sold-count">📦 تاکنون ' . $sales_count . ' عدد فروخته شده است.</p>';
    }
}
add_action('woocommerce_single_product_summary', 'seokar_show_sold_count', 15);

// **۳. اضافه کردن یک تب سفارشی در صفحه محصول**
function seokar_custom_product_tab($tabs) {
    $tabs['extra_info'] = array(
        'title'    => 'اطلاعات بیشتر',
        'priority' => 50,
        'callback' => 'seokar_custom_product_tab_content'
    );
    return $tabs;
}
add_filter('woocommerce_product_tabs', 'seokar_custom_product_tab');

function seokar_custom_product_tab_content() {
    echo '<p>این یک بخش سفارشی برای اطلاعات بیشتر محصول است.</p>';
}

// **۴. نمایش خلاصه سفارشات در داشبورد مدیریت**
function seokar_admin_order_summary() {
    $order_count = wp_count_posts('shop_order')->publish;
    $total_sales = wc_get_orders(array('limit' => -1, 'return' => 'ids'));

    echo '<div class="notice notice-info">
            <p>📊 تعداد سفارشات: <strong>' . $order_count . '</strong></p>
            <p>💰 مجموع سفارشات: <strong>' . count($total_sales) . ' سفارش</strong></p>
          </div>';
}
add_action('admin_notices', 'seokar_admin_order_summary');
