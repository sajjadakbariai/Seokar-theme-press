document.addEventListener("DOMContentLoaded", function () {
    const saveButton = document.getElementById("seokar-save-settings");
    const colorPicker = document.getElementById("seokar-primary-color");
    const previewBox = document.getElementById("seokar-preview");
    const messageBox = document.getElementById("seokar-save-message");

    // تغییر رنگ پیش‌نمایش هنگام انتخاب رنگ جدید
    colorPicker.addEventListener("input", function () {
        previewBox.style.background = colorPicker.value;
    });

    // ذخیره تنظیمات قالب با AJAX
    saveButton.addEventListener("click", function () {
        let formData = new FormData();
        formData.append("action", "seokar_save_theme_options");
        formData.append("security", seokar_ajax.security);
        formData.append("seokar_primary_color", colorPicker.value);

        fetch(seokar_ajax.ajax_url, {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            messageBox.textContent = data.message;
            messageBox.style.color = data.success ? "green" : "red";
            messageBox.style.display = "block";
        })
        .catch(() => {
            messageBox.textContent = "⛔ خطایی رخ داد!";
            messageBox.style.color = "red";
            messageBox.style.display = "block";
        });
    });
});
