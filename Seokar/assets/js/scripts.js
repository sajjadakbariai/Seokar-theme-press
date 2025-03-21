document.addEventListener("DOMContentLoaded", function () {
    console.log("Seokar Theme Scripts Loaded");

    // **۱. منوی موبایل**
    const menuToggle = document.querySelector(".menu-toggle");
    const menu = document.querySelector(".nav-menu");

    if (menuToggle && menu) {
        menuToggle.addEventListener("click", function () {
            menu.classList.toggle("active");
        });
    }

    // **۲. دکمه بازگشت به بالا**
    const backToTop = document.createElement("button");
    backToTop.innerText = "↑";
    backToTop.id = "back-to-top";
    document.body.appendChild(backToTop);

    window.addEventListener("scroll", function () {
        if (window.scrollY > 200) {
            backToTop.classList.add("visible");
        } else {
            backToTop.classList.remove("visible");
        }
    });

    backToTop.addEventListener("click", function () {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });

    // **۳. تغییر به حالت تاریک**
    const darkModeToggle = document.querySelector(".dark-mode-toggle");
    if (darkModeToggle) {
        darkModeToggle.addEventListener("click", function () {
            document.body.classList.toggle("dark-mode");
            localStorage.setItem("darkMode", document.body.classList.contains("dark-mode") ? "enabled" : "disabled");
        });

        // بررسی ذخیره‌شده در localStorage
        if (localStorage.getItem("darkMode") === "enabled") {
            document.body.classList.add("dark-mode");
        }
    }
});
