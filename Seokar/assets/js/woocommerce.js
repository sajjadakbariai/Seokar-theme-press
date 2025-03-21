document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ Seokar WooCommerce Scripts Loaded");

    const addToCartButtons = document.querySelectorAll(".quick-add-to-cart");

    addToCartButtons.forEach(button => {
        button.addEventListener("click", function () {
            let productId = this.dataset.productId; // دریافت شناسه محصول
            let formData = new FormData();
            formData.append("action", "seokar_quick_add_to_cart");
            formData.append("product_id", productId);
            formData.append("security", seokar_ajax.nonce); // ارسال nonce برای امنیت

            fetch(seokar_ajax.ajax_url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast("✅ محصول به سبد خرید اضافه شد!", "success");
                } else {
                    showToast("❌ خطا: " + data.message, "error");
                }
            })
            .catch(error => showToast("❌ خطا در افزودن به سبد خرید!", "error"));
        });
    });

    // ** تابع نمایش نوتیفیکیشن زیبا **
    function showToast(message, type = "info") {
        let toast = document.createElement("div");
        toast.className = `seokar-toast ${type}`;
        toast.innerText = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
});
