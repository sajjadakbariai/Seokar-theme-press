document.addEventListener("DOMContentLoaded", function () {
    console.log("Seokar Custom JS Loaded");

    // **۱. افکت‌های اسکرول برای بخش‌های مختلف**
    const sections = document.querySelectorAll(".fade-in");
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });

    sections.forEach(section => observer.observe(section));

    // **۲. نمایش و بستن پاپ‌آپ سفارشی**
    const popupTrigger = document.querySelector(".popup-trigger");
    const popup = document.querySelector(".popup");
    const popupClose = document.querySelector(".popup-close");

    if (popupTrigger && popup && popupClose) {
        popupTrigger.addEventListener("click", () => popup.classList.add("show"));
        popupClose.addEventListener("click", () => popup.classList.remove("show"));

        // بستن پاپ‌آپ با کلیک خارج از آن
        document.addEventListener("click", (event) => {
            if (popup.classList.contains("show") && !popup.contains(event.target) && !popupTrigger.contains(event.target)) {
                popup.classList.remove("show");
            }
        });
    }

    // **۳. تغییر رنگ هدر در هنگام اسکرول**
    const header = document.querySelector("header");
    window.addEventListener("scroll", function () {
        if (window.scrollY > 50) {
            header.classList.add("scrolled");
        } else {
            header.classList.remove("scrolled");
        }
    });
});
