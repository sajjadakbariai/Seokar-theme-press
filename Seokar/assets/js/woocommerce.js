document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".quick-add-to-cart").forEach(button => {
        button.addEventListener("click", function () {
            let productId = this.getAttribute("data-product_id");

            let formData = new FormData();
            formData.append("action", "seokar_quick_add_to_cart");
            formData.append("product_id", productId);
            formData.append("security", seokar_ajax.security);

            fetch(seokar_ajax.ajax_url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            });
        });
    });
});
