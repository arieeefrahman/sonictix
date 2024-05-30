document.getElementById('register-form').addEventListener('submit', function(event) {
    event.preventDefault();

    let username = document.getElementById('username').value;
    let password = document.getElementById('password').value;
    let email = document.getElementById('email').value;
    let fullName = document.getElementById('full-name').value;

    fetch('/api/register', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            username: username,
            password: password,
            email: email,
            full_name: fullName
        })
    })
    .then(response => response.json().then(data => ({ status: response.status, body: data })))
    .then(({ status, body }) => {
        if (status === 201) {
            Swal.fire({
                title: 'Registration Successful!',
                text: 'You have successfully registered. Redirecting to login page...',
                icon: 'success',
                timer: 3000,
                showConfirmButton: false,
                willClose: () => {
                    window.location.href = '/login';
                }
            });
        } else {
            throw body;
        }
    })
    .catch(error => {
        console.error('Error details:', error);

        // Display detailed validation errors
        let errorMessages = '';
        if (error.errors) {
            for (let [field, messages] of Object.entries(error.errors)) {
                errorMessages += `${field}: ${messages.join(', ')}\n`;
            }
        } else {
            errorMessages = error.message || 'An unknown error occurred';
        }

        Swal.fire({
            title: 'Registration Failed!',
            text: errorMessages,
            icon: 'error'
        });
    });
});
