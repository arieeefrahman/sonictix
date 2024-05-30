window.addEventListener('load', function() {
    const authToken = sessionStorage.getItem('authToken');
    if (authToken && authToken !== 'null') {
        // Redirect to the home page if the user is already logged in
        window.location.href = '/home';
    }
});

document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    let username = document.getElementById('username').value;
    let password = document.getElementById('password').value;

    fetch('/api/login', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            username: username,
            password: password
        })
    })
    .then(response => response.json().then(data => ({ status: response.status, body: data })))
    .then(({ status, body }) => {
        if (status === 200) {
            const token = body.data.token;
            console.log("login success");
            sessionStorage.setItem('authToken', token); // Store the token in sessionStorage
            Swal.fire({
                title: 'Login Successful!',
                text: 'You have successfully logged in. Redirecting you to homepage ...',
                icon: 'success',
                timer: 3000,
                showConfirmButton: false,
                willClose: () => {
                    // Redirect to the desired page after login
                    window.location.href = '/home'; // Adjust the redirect URL as needed
                }
            });
        } else if (status === 400 || status === 401) {
            let errorMessages = body.message;
            if (body.errors) {
                errorMessages += '\n' + Object.entries(body.errors).map(([field, messages]) => `${field}: ${messages.join(', ')}`).join('\n');
            }
            Swal.fire({
                title: 'Login Failed!',
                text: errorMessages,
                icon: 'error'
            });
        } else {
            throw body;
        }
    })
    .catch(error => {
        console.error('Error details:', error);

        Swal.fire({
            title: 'An Error Occurred!',
            text: error.message || 'An unknown error occurred',
            icon: 'error'
        });
    });
});

// Toggle password visibility
document.getElementById('toggle-password').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});