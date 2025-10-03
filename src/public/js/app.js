document.addEventListener("DOMContentLoaded", () => {
    const header = document.getElementById("appHeader");
    if (header) {
        const onScroll = () => header.classList.toggle("scrolled", window.scrollY > 4);
        document.addEventListener("scroll", onScroll);
        onScroll();
    }
});
