document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ Seokar AJAX Handlers Loaded");

    // **۱. بارگذاری بیشتر مطالب با AJAX**
    const loadMoreButton = document.querySelector("#seokar-load-more");
    if (loadMoreButton) {
        let currentPage = 1;
        loadMoreButton.addEventListener("click", function () {
            currentPage++;
            let formData = new FormData();
            formData.append("action", "seokar_load_more");
            formData.append("paged", currentPage);
            formData.append("security", seokar_ajax.nonce);

            fetch(seokar_ajax.ajax_url, {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "no_more_posts") {
                    loadMoreButton.style.display = "none";
                } else {
                    document.querySelector("#seokar-posts-container").insertAdjacentHTML("beforeend", data);
                }
            })
            .catch(error => console.error("❌ خطا در بارگذاری مطالب:", error));
        });
    }

    // **۲. جستجوی زنده با AJAX**
    const searchInput = document.querySelector("#seokar-live-search");
    const searchResults = document.querySelector("#seokar-search-results");

    if (searchInput && searchResults) {
        searchInput.addEventListener("input", function () {
            let searchQuery = this.value.trim();
            if (searchQuery.length < 3) {
                searchResults.innerHTML = "";
                return;
            }

            let formData = new FormData();
            formData.append("action", "seokar_live_search");
            formData.append("search_query", searchQuery);
            formData.append("security", seokar_ajax.nonce);

            fetch(seokar_ajax.ajax_url, {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                searchResults.innerHTML = data;
            })
            .catch(error => console.error("❌ خطا در جستجو:", error));
        });
    }

    // **۳. ارسال فرم تماس با AJAX**
    const contactForm = document.querySelector("#seokar-contact-form");
    if (contactForm) {
        contactForm.addEventListener("submit", function (event) {
            event.preventDefault();
            
            let formData = new FormData(contactForm);
            formData.append("action", "seokar_contact_form");
            formData.append("security", seokar_ajax.nonce);

            fetch(seokar_ajax.ajax_url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    contactForm.reset();
                }
            })
            .catch(error => console.error("❌ خطا در ارسال فرم:", error));
        });
    }

    // **۴. لایک کردن پست با AJAX**
    const likeButtons = document.querySelectorAll(".seokar-like-post");
    likeButtons.forEach(button => {
        button.addEventListener("click", function () {
            let postID = this.dataset.postId;
            let formData = new FormData();
            formData.append("action", "seokar_like_post");
            formData.append("post_id", postID);
            formData.append("security", seokar_ajax.nonce);

            fetch(seokar_ajax.ajax_url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.querySelector(".like-count").textContent = data.likes;
                }
            })
            .catch(error => console.error("❌ خطا در لایک کردن پست:", error));
        });
    });

    // **۵. افزودن سریع محصول به سبد خرید (WooCommerce)**
    const addToCartButtons = document.querySelectorAll(".seokar-add-to-cart");
    addToCartButtons.forEach(button => {
        button.addEventListener("click", function () {
            let productID = this.dataset.productId;
            let formData = new FormData();
            formData.append("action", "seokar_quick_add_to_cart");
            formData.append("product_id", productID);
            formData.append("security", seokar_ajax.nonce);

            fetch(seokar_ajax.ajax_url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            })
            .catch(error => console.error("❌ خطا در افزودن به سبد خرید:", error));
        });
    });
});
