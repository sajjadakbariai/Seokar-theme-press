document.addEventListener("DOMContentLoaded", function () {
    console.log("Seokar AJAX Scripts Loaded");

    // **۱. بارگذاری بیشتر مطالب**
    let loadMoreBtn = document.getElementById("load-more");
    let page = 1;

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener("click", function () {
            page++;
            let formData = new FormData();
            formData.append("action", "seokar_load_more");
            formData.append("security", seokar_ajax.security);
            formData.append("paged", page);

            fetch(seokar_ajax.ajax_url, {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "no_more_posts") {
                    loadMoreBtn.style.display = "none";
                } else {
                    document.getElementById("post-container").innerHTML += data;
                }
            });
        });
    }

    // **۲. فرم تماس با AJAX**
    let contactForm = document.getElementById("contact-form");
    if (contactForm) {
        contactForm.addEventListener("submit", function (event) {
            event.preventDefault();

            let formData = new FormData(contactForm);
            formData.append("action", "seokar_contact_form");
            formData.append("security", seokar_ajax.security);

            fetch(seokar_ajax.ajax_url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) contactForm.reset();
            });
        });
    }

    // **۳. جستجوی زنده با AJAX**
    let searchInput = document.getElementById("search-input");
    let searchResults = document.getElementById("search-results");

    if (searchInput) {
        searchInput.addEventListener("keyup", function () {
            let formData = new FormData();
            formData.append("action", "seokar_live_search");
            formData.append("security", seokar_ajax.security);
            formData.append("search_query", searchInput.value);

            fetch(seokar_ajax.ajax_url, {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                searchResults.innerHTML = data;
            });
        });
    }
});
