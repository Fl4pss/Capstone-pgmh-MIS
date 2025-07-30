document.addEventListener('DOMContentLoaded', function () {
    console.log("DOMContentLoaded event fired");

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

    // Initialize event listeners for image buttons
    var imageButtons = document.querySelectorAll('.view-image-btn');
    imageButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var imageSrc = this.getAttribute('data-image-src');
            showImage(imageSrc);
        });
    });
});