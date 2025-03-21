document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ Seokar AJAX Scripts Loaded");

    // **۱. بارگذاری بیشتر مطالب با AJAX**
    const loadMoreBtn = document.getElementById("load-more");
    let currentPage = 1;

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener("click", function () {
            currentPage++;

            let formData = new FormData();
            formData.append("action", "seokar_load_more");
            formData.append("security", seokar_ajax.nonce);
            formData.append("paged", currentPage);

            fetch(seokar_ajax.ajax_url, {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "no_more_posts") {
                    loadMoreBtn.style.display = "none";
                } else {
                    document.getElementById("post-container").insertAdjacentHTML("beforeend", data);
                }
            })
            .catch(error => console.error("❌ خطا در بارگذاری مطالب:", error));
        });
    }

    // **۲. ارسال فرم تماس با AJAX**
    const contactForm = document.getElementById("contact-form");
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
            .catch(error => console.error("❌ خطا در ارسال فرم تماس:", error));
        });
    }

    // **۳. جستجوی زنده با AJAX**
    const searchInput = document.getElementById("search-input");
    const searchResults = document.getElementById("search-results");
    let searchTimeout;

    if (searchInput && searchResults) {
        searchInput.addEventListener("input", function () {
            clearTimeout(searchTimeout);
            let searchQuery = this.value.trim();

            if (searchQuery.length < 3) {
                searchResults.innerHTML = "";
                return;
            }

            searchTimeout = setTimeout(() => {
                let formData = new FormData();
                formData.append("action", "seokar_live_search");
                formData.append("security", seokar_ajax.nonce);
                formData.append("search_query", searchQuery);

                fetch(seokar_ajax.ajax_url, {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    searchResults.innerHTML = data;
                })
                .catch(error => console.error("❌ خطا در جستجو:", error));
            }, 300);
        });
    }
});
