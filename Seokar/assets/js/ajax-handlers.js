document.addEventListener("DOMContentLoaded", function () {
    console.log("Seokar AJAX Handlers Loaded");

    // **۱. فرم تماس با AJAX**
    const contactForm = document.querySelector("#contact-form");
    if (contactForm) {
        contactForm.addEventListener("submit", function (event) {
            event.preventDefault();
            
            let formData = new FormData(contactForm);
            formData.append("action", "seokar_contact_form");

            fetch(seokar_ajax.ajax_url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) contactForm.reset();
            })
            .catch(error => console.error("Error:", error));
        });
    }

    // **۲. لایک کردن پست**
    document.querySelectorAll(".like-button").forEach(button => {
        button.addEventListener("click", function () {
            let postId = this.dataset.postid;

            fetch(seokar_ajax.ajax_url, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `action=seokar_like_post&post_id=${postId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.innerText = `❤️ ${data.likes}`;
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
});
