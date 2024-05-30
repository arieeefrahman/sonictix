// Function to refresh the token
function refreshAuthToken() {
    const token = sessionStorage.getItem('authToken');

    fetch('/api/refresh', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        }
    })
    .then(response => response.json().then(data => ({ status: response.status, body: data })))
    .then(({ status, body }) => {
        if (status === 200) {
            const newToken = body.data.token;
            sessionStorage.setItem('authToken', newToken);
            console.log('Token refreshed successfully');
        } else {
            throw new Error('Failed to refresh token');
        }
    })
    .catch(error => {
        console.error('Token refresh error:', error);
        logout();       // Logout user if token refresh fails
    });
}

// Function to start the token refresh schedule
function startTokenRefresh() {
    setInterval(refreshAuthToken, 3300000);     // Refresh the token every 55 minutes (3300000 milliseconds)
}

// Function to log out the user
function logout() {
    sessionStorage.removeItem('authToken');
    window.location.href = '/login';
}

// Start the token refresh process if not on login or register page
document.addEventListener('DOMContentLoaded', function() {
    const path = window.location.pathname;
    if (path !== '/login' && path !== '/register') {
        startTokenRefresh();
    }
});