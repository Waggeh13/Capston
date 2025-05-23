document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    
    menuToggle.addEventListener('click', function() {
        sidebar.classList.toggle('active');
    });
    
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768 && !sidebar.contains(event.target)) {
            sidebar.classList.remove('active');
        }
    });
});