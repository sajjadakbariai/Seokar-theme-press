document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ Seokar Admin Scripts Loaded");

    // **۱. ذخیره تنظیمات قالب با AJAX**
    const saveButton = document.querySelector("#seokar-save-settings");
    if (saveButton) {
        saveButton.addEventListener("click", function (event) {
            event.preventDefault();

            let formData = new FormData(document.querySelector("#seokar-settings-form"));
            formData.append("action", "seokar_save_theme_options");
            formData.append("security", seokar_admin.nonce); // ارسال nonce برای افزایش امنیت

            fetch(seokar_admin.ajax_url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("✅ تنظیمات با موفقیت ذخیره شد!");
                } else {
                    alert("❌ خطایی رخ داد: " + data.message);
                }
            })
            .catch(error => console.error("❌ خطا در AJAX:", error));
        });
    }

    // **۲. تغییر رنگ پیش‌نمایش در تنظیمات قالب**
    const colorInput = document.querySelector("#seokar-primary-color");
    if (colorInput) {
        colorInput.addEventListener("input", function () {
            document.querySelector("#seokar-preview").style.backgroundColor = this.value;
        });
    }

    // **۳. نمایش هشدار قبل از خروج بدون ذخیره تغییرات**
    let formChanged = false;
    const settingsForm = document.querySelector("#seokar-settings-form");
    if (settingsForm) {
        settingsForm.addEventListener("input", () => {
            formChanged = true;
        });

        window.addEventListener("beforeunload", (event) => {
            if (formChanged) {
                event.preventDefault();
                event.returnValue = "⚠️ تغییراتی ذخیره نشده‌اند. آیا مطمئن هستید که می‌خواهید صفحه را ترک کنید؟";
            }
        });
    }
});
