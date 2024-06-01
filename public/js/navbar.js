document.addEventListener('DOMContentLoaded', function () {
    var authToken = sessionStorage.getItem('authToken');
    var guestLinks = document.querySelectorAll('#guest-links');
    var authLinks = document.getElementById('auth-links');

    if (authToken) {
        guestLinks.forEach(function(link) {
            link.classList.add('d-none');
        });
        authLinks.classList.remove('d-none');
    } else {
        guestLinks.forEach(function(link) {
            link.classList.remove('d-none');
        });
        authLinks.classList.add('d-none');
    }
});

function logout() {
    sessionStorage.removeItem('authToken');
    window.location.href = "{{ url('/home') }}";
}