document.addEventListener('DOMContentLoaded', function() {
    const token = sessionStorage.getItem('authToken');

    function fetchUserOrder() {
        fetch('/api/user/orders', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const orders = data.data.data;

                const container = document.getElementById('tickets-container');
                const template = document.getElementById('ticket-template');

                orders.forEach(order => {
                    const clone = template.cloneNode(true);
                    clone.classList.remove('hidden');
                    clone.querySelector('.event-image').src = order.event.image;
                    clone.querySelector('.event-title').innerText = order.event.title;
                    clone.querySelector('.total-tickets').innerText = `Total Tickets: ${order.order_details.length}`;
                    clone.querySelector('.subtotal').innerText = `Subtotal: Rp${order.total_amount.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

                    container.appendChild(clone);
                });
            }
        })
        .catch(error => console.error('Error fetching data:', error));
    }

    fetchUserOrder();
});