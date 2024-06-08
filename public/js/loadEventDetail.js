document.addEventListener('DOMContentLoaded', function() {
    const eventDetailContainer = document.getElementById('event-detail-container');
    let selectedTickets = [];
    let eventId = getEventIdFromUrl();
    let subtotal = 0;

    function getEventIdFromUrl() {
        const url = window.location.pathname;
        const segments = url.split('/');
        const eventIndex = segments.indexOf('event');
        return segments[eventIndex + 1];
    }

    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    if (isNaN(eventId)) {
        console.error('Error: Event ID is not a numeric value.');
        return;
    }

    function fetchEventDetails() {
        fetch(`/api/event/${eventId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status !== 'success') {
                    console.error('Error fetching event details:', data.message);
                    return;
                }
                const event = data.data;
                const ticketCategories = event.event_ticket_categories;
                renderTicketCategories(event, ticketCategories);
            })
            .catch(error => console.error('Error fetching event details:', error));
    }

    function renderTicketCategories(event, ticketCategories) {
        const ticketListHtml = ticketCategories.map(category => `
            <div class="ticket-category" data-id="${category.id}" data-stock="${category.ticket_stock}">
                <div class="ticket-color-bar" style="background-color: ${getRandomColor()};"></div>
                <span class="ticket-name">${category.name}</span>
                <span class="ticket-price">Rp${category.price.toLocaleString('id-ID')}</span>
                ${category.ticket_stock > 0 ? `
                    <div class="ticket-controls">
                        <button class="ticket-add-btn">Add</button>
                        <div class="ticket-quantity-controls" style="display: none;">
                            <button class="ticket-btn decrease">-</button>
                            <span class="ticket-quantity">1</span>
                            <button class="ticket-btn increase">+</button>
                        </div>
                    </div>
                ` : `
                    <button class="sold-out">Out of stock</button>
                `}
            </div>
        `).join('');

        const ticketSummaryHtml = `
            <div class="ticket-summary">
                <span class="subtotal-label">Subtotal</span>
                <span class="subtotal-amount">Rp${subtotal.toLocaleString('id-ID')}</span>
                <button class="checkout-btn" disabled>Checkout</button>
            </div>
        `;

        eventDetailContainer.innerHTML = `
            <h1>${event.title}</h1>
            <div class="event-image">
                <img src="${event.image}" alt="${event.title}">
            </div>
            <div class="event-info">
                <p><strong>Start date:</strong> ${new Date(event.start_date).toLocaleString()}</p>
                <p><strong>End date:</strong> ${new Date(event.end_date).toLocaleString()}</p>
                <p><strong>Location:</strong> <a href="${event.google_maps_url}" target="_blank">${event.location}</a></p>
                <p><strong>Description:</strong> ${event.description}</p>
            </div>
            <div id="ticket-categories" class="ticket-categories">
                <h2>Ticket Categories</h2>
                <div class="ticket-list">
                    ${ticketListHtml}
                </div>
                ${ticketSummaryHtml}
            </div>
        `;

        // Add event listeners for add, increase and decrease buttons
        document.querySelectorAll('.ticket-category').forEach(categoryElement => {
            const addButton = categoryElement.querySelector('.ticket-add-btn');
            const quantityControls = categoryElement.querySelector('.ticket-quantity-controls');
            const decreaseButton = quantityControls.querySelector('.decrease');
            const increaseButton = quantityControls.querySelector('.increase');
            const quantityElement = quantityControls.querySelector('.ticket-quantity');
            const priceElement = categoryElement.querySelector('.ticket-price');
            const categoryId = categoryElement.getAttribute('data-id');
            const stock = parseInt(categoryElement.getAttribute('data-stock'), 10);
            const price = parseInt(priceElement.textContent.replace('Rp', '').replace(/\./g, ''), 10);

            let quantity = 0;

            addButton.addEventListener('click', () => {
                if (stock > 0) {
                    quantity = 1;
                    addButton.style.display = 'none';
                    quantityControls.style.display = 'flex';
                    subtotal += price;
                    selectedTickets.push({ event_ticket_category_id: categoryId, quantity, price });
                    updateSubtotal();
                    updateIncreaseButtonState();
                    updateCheckoutButtonState();
                } else {
                    alert('No tickets available.');
                }
            });

            decreaseButton.addEventListener('click', () => {
                if (quantity > 1) {
                    quantity--;
                    quantityElement.textContent = quantity;
                    subtotal -= price;
                    updateTicketSelection(categoryId, quantity);
                    updateSubtotal();
                    updateIncreaseButtonState();
                } else {
                    quantity = 0;
                    addButton.style.display = 'block';
                    quantityControls.style.display = 'none';
                    subtotal -= price;
                    removeTicketSelection(categoryId);
                    updateSubtotal();
                    updateIncreaseButtonState();
                    updateCheckoutButtonState();
                }
            });

            increaseButton.addEventListener('click', () => {
                if (quantity < stock && quantity < 5) {
                    quantity++;
                    quantityElement.textContent = quantity;
                    subtotal += price;
                    updateTicketSelection(categoryId, quantity);
                    updateSubtotal();
                    updateIncreaseButtonState();
                }
            });

            const updateIncreaseButtonState = () => {
                if (quantity >= stock || quantity >= 5) {
                    increaseButton.disabled = true;
                    increaseButton.style.backgroundColor = 'grey';
                } else {
                    increaseButton.disabled = false;
                    increaseButton.style.backgroundColor = '';
                }
            };
        });

        document.querySelector('.checkout-btn').addEventListener('click', () => {
            checkout();
        });

        updateSubtotal();
        updateCheckoutButtonState(); // Initial check for the checkout button state
    }

    const updateSubtotal = () => {
        document.querySelector('.subtotal-amount').textContent = `Rp${subtotal.toLocaleString('id-ID')}`;
    };

    const updateTicketSelection = (categoryId, quantity) => {
        const ticket = selectedTickets.find(t => t.event_ticket_category_id === categoryId);
        if (ticket) {
            ticket.quantity = quantity;
        }
    };

    const removeTicketSelection = (categoryId) => {
        selectedTickets = selectedTickets.filter(t => t.event_ticket_category_id !== categoryId);
    };

    const updateCheckoutButtonState = () => {
        const checkoutButton = document.querySelector('.checkout-btn');
        if (selectedTickets.length === 0) {
            checkoutButton.disabled = true;
            checkoutButton.style.backgroundColor = 'grey';
        } else {
            checkoutButton.disabled = false;
            checkoutButton.style.backgroundColor = '';
        }
    };

    const checkout = () => {
        const orderData = {
            event_id: eventId,
            items: selectedTickets
        };

        const token = sessionStorage.getItem('authToken');

        fetch('/api/order', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify(orderData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Order placed successfully!');
                fetchEventDetails(); // Re-fetch event details to synchronize ticket stock
                resetUI(); // Reset the UI after a successful checkout

                // TODO: 
                // 1. Redirect to a payment page or clear the selection
                // 2. Add sweetalert to success and error alert
            } else {
                alert('Failed to place order: ' + data.message);
            }
        })
        .catch(error => console.error('Error placing order:', error));
    };

    const resetUI = () => {
        selectedTickets = [];
        subtotal = 0;
        updateSubtotal();
        updateCheckoutButtonState();

        document.querySelectorAll('.ticket-category').forEach(categoryElement => {
            const addButton = categoryElement.querySelector('.ticket-add-btn');
            const quantityControls = categoryElement.querySelector('.ticket-quantity-controls');
            const quantityElement = quantityControls.querySelector('.ticket-quantity');

            addButton.style.display = 'block';
            quantityControls.style.display = 'none';
            quantityElement.textContent = '1';
        });
    };

    fetchEventDetails();
});
