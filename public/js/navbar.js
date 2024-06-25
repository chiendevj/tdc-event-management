//_______________________Navbar___________________________________//
const navbar = document.getElementById("navbar");
let lastScrollTop = 0;

window.addEventListener("scroll", function () {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    if (scrollTop > lastScrollTop) {
        // Downscroll
        navbar.classList.add("show");
    } else if (scrollTop === 0) {
        // Reached top of the page
        navbar.classList.remove("show");
    }
    lastScrollTop = scrollTop;
});

function onToggleMenu() {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    if (sidebar.classList.contains("open")) {
        sidebar.classList.remove("open");
        overlay.classList.remove("open");
    } else {
        sidebar.classList.add("open");
        overlay.classList.add("open");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const closeButton = document.querySelector("#sidebar .close-btn");
    closeButton.addEventListener("click", onToggleMenu);
});
//_______________________End Navbar___________________________________//