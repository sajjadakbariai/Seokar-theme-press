document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ Seokar Dark Mode Switcher Loaded");

    const darkModeToggle = document.getElementById("dark-mode-toggle");
    const body = document.body;

    // **۱. بررسی تنظیمات ذخیره‌شده در localStorage یا تنظیمات سیستم**
    function initializeDarkMode() {
        const darkModeSetting = localStorage.getItem("seokar_dark_mode");

        if (darkModeSetting === "enabled" || 
           (darkModeSetting === null && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
            body.classList.add("dark-mode");
        }
    }

    initializeDarkMode();

    // **۲. تغییر حالت تاریک / روشن هنگام کلیک بر روی دکمه**
    if (darkModeToggle) {
        darkModeToggle.addEventListener("click", function () {
            if (body.classList.contains("dark-mode")) {
                body.classList.remove("dark-mode");
                localStorage.setItem("seokar_dark_mode", "disabled");
            } else {
                body.classList.add("dark-mode");
                localStorage.setItem("seokar_dark_mode", "enabled");
            }
        });
    }
});
