// Mobile navigation toggle — shared by every page.
document.addEventListener('DOMContentLoaded', function () {
    var toggleBtn = document.getElementById('togleBtn');
    var menu = document.getElementById('menus');
    if (toggleBtn && menu) {
        toggleBtn.addEventListener('click', function () {
            menu.classList.toggle('show');
        });
    }
});
