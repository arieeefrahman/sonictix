document.addEventListener("DOMContentLoaded", function() {
    var authToken = sessionStorage.getItem("authToken");
    var loginLink = document.getElementById("login-link");
    var logoutLink = document.getElementById("logout-link");
    var registerLink = document.getElementById("register-link");

    if (!authToken) {
        // authToken is null, undefined, or an empty string
        loginLink.classList.remove("hidden");
        registerLink.classList.remove("hidden");
        registerLink.classList.add("md:block");
        logoutLink.classList.add("hidden");
    } else {
        // authToken is valid
        loginLink.classList.add("hidden");
        registerLink.classList.add("hidden");
        registerLink.classList.remove("md:block");
        logoutLink.classList.remove("hidden");
    }
});

function confirmLogout(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure to logout?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0365b5',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, log out!'
    }).then((result) => {
        if (result.isConfirmed) {
            logout();
        }
    })
}

async function logout() {
    try {
        const response = await fetch('/api/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${sessionStorage.getItem('authToken')}`
            }
        });
        
        if (response.ok) {
            sessionStorage.removeItem('authToken');
            window.location.href = "/home";
        } else {
            console.error('Logout failed');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}