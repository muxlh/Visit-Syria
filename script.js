document.addEventListener("DOMContentLoaded", function () {
    
    const menuBtn = document.getElementById("menu-btn");
    const mobileMenu = document.getElementById("mobile-menu");

    menuBtn.addEventListener("click", function () {
        mobileMenu.classList.toggle("hidden");
        mobileMenu.classList.toggle("animate-slide-down");
    });

    
    const slideshow = document.getElementById("slideshow");
    const next = document.getElementById("next");
    const prev = document.getElementById("prev");

    let index = 0;

    const slideImages = () => {
        slideshow.style.transform = `translateX(-${index * 100}%)`;
        slideshow.style.transition = "transform 0.5s ease-in-out"; 
    };

    next.addEventListener("click", () => {
        index = (index + 1) % slideshow.children.length;
        slideImages();
    });

    prev.addEventListener("click", () => {
        index = (index - 1 + slideshow.children.length) % slideshow.children.length;
        slideImages();
    });

    
    AOS.init();
});