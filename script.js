function toggleMenu() {
    const menu = document.querySelector(".menu-links");
    const icon = document.querySelector(".hamburger-icon");
    menu.classList.toggle("open");
    icon.classList.toggle("open");
}

document.addEventListener('DOMContentLoaded', function () {

    // Event listener for desktop navigation links
    document.querySelectorAll('nav a').forEach(link => {
        link.addEventListener('click', function (event) {
            const sectionId = this.getAttribute('href').substring(1);
            scrollToSection(sectionId);
        });
    });

    // Adjusted event listener for mobile navigation links
    const mobileNavLinks = document.querySelectorAll('#mobile-nav .menu-links a');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const sectionId = this.getAttribute('href').substring(1);
            // Navigate directly to the new page
            window.location.href = this.getAttribute('href');
            // No need to call toggleMenu() here since we're navigating away
        });
    });

});
