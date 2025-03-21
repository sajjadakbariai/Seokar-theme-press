document.addEventListener("DOMContentLoaded", function () {
    console.log("Seokar Admin Scripts Loaded");

    // **۱. نمایش پیام ذخیره شدن تنظیمات قالب**
    const saveButton = document.querySelector("#seokar-save-settings");
    if (saveButton) {
        saveButton.addEventListener("click", function (event) {
            event.preventDefault();

            let formData = new FormData(document.querySelector("#seokar-settings-form"));
            formData.append("action", "seokar_save_theme_options");

            fetch(seokar_admin.ajax_url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            })
            .catch(error => console.error("Error:", error));
        });
    }

    // **۲. تغییر رنگ پیش‌نمایش در تنظیمات قالب**
    const colorInput = document.querySelector("#seokar-primary-color");
    if (colorInput) {
        colorInput.addEventListener("input", function () {
            document.querySelector("#seokar-preview").style.backgroundColor = this.value;
        });
    }
});
