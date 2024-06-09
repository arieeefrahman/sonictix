document.addEventListener('DOMContentLoaded', () => {
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
                renderEventDetails(event);
                renderTicketCategories(ticketCategories);
            })
            .catch(error => console.error('Error fetching event details:', error));
    }

    function renderEventDetails(event) {
        document.getElementById('event-title').textContent = event.title;
        const eventImage = document.getElementById('event-image');
        eventImage.src = event.image;
        eventImage.alt = event.title;
        document.getElementById('event-start-date').textContent = new Date(event.start_date).toLocaleString();
        document.getElementById('event-end-date').textContent = new Date(event.end_date).toLocaleString();
        const eventLocation = document.getElementById('event-location');
        eventLocation.href = event.google_maps_url;
        eventLocation.textContent = event.location;
        document.getElementById('event-description').textContent = event.description;
    }

    function renderTicketCategories(ticketCategories) {
        const ticketList = document.getElementById('ticket-list');
        ticketList.innerHTML = ''; // Clear previous ticket categories if any

        ticketCategories.forEach(category => {
            const ticketCategoryDiv = document.createElement('div');
            ticketCategoryDiv.className = 'ticket-category';
            ticketCategoryDiv.dataset.id = category.id;
            ticketCategoryDiv.dataset.stock = category.ticket_stock;

            const colorBarDiv = document.createElement('div');
            colorBarDiv.className = 'ticket-color-bar';
            colorBarDiv.style.backgroundColor = getRandomColor();

            const nameSpan = document.createElement('span');
            nameSpan.className = 'ticket-name';
            nameSpan.textContent = category.name;

            const priceSpan = document.createElement('span');
            priceSpan.className = 'ticket-price';
            priceSpan.textContent = `Rp${category.price.toLocaleString('id-ID')}`;

            ticketCategoryDiv.appendChild(colorBarDiv);
            ticketCategoryDiv.appendChild(nameSpan);
            ticketCategoryDiv.appendChild(priceSpan);

            if (category.ticket_stock > 0) {
                const controlsDiv = document.createElement('div');
                controlsDiv.className = 'ticket-controls';

                const addButton = document.createElement('button');
                addButton.className = 'ticket-add-btn';
                addButton.textContent = 'Add';

                const quantityControlsDiv = document.createElement('div');
                quantityControlsDiv.className = 'ticket-quantity-controls';
                quantityControlsDiv.style.display = 'none';

                const decreaseButton = document.createElement('button');
                decreaseButton.className = 'ticket-btn decrease';
                decreaseButton.textContent = '-';

                const quantitySpan = document.createElement('span');
                quantitySpan.className = 'ticket-quantity';
                quantitySpan.textContent = '1';

                const increaseButton = document.createElement('button');
                increaseButton.className = 'ticket-btn increase';
                increaseButton.textContent = '+';

                quantityControlsDiv.appendChild(decreaseButton);
                quantityControlsDiv.appendChild(quantitySpan);
                quantityControlsDiv.appendChild(increaseButton);

                controlsDiv.appendChild(addButton);
                controlsDiv.appendChild(quantityControlsDiv);

                ticketCategoryDiv.appendChild(controlsDiv);

                addButton.addEventListener('click', () => handleAddButtonClick(category, addButton, quantityControlsDiv, increaseButton));
                decreaseButton.addEventListener('click', () => handleDecreaseButtonClick(category, decreaseButton, quantitySpan, addButton, quantityControlsDiv, increaseButton));
                increaseButton.addEventListener('click', () => handleIncreaseButtonClick(category, quantitySpan, increaseButton));
            } else {
                const soldOutButton = document.createElement('button');
                soldOutButton.className = 'sold-out';
                soldOutButton.textContent = 'Out of stock';
                ticketCategoryDiv.appendChild(soldOutButton);
            }

            ticketList.appendChild(ticketCategoryDiv);
        });

        document.querySelector('.checkout-btn').addEventListener('click', checkout);
        updateSubtotal();
        updateCheckoutButtonState();
    }

    function handleAddButtonClick(category, addButton, quantityControlsDiv, increaseButton) {
        if (category.ticket_stock > 0) {
            let quantity = 1;
            addButton.style.display = 'none';
            quantityControlsDiv.style.display = 'flex';
            subtotal += category.price;
            selectedTickets.push({ event_ticket_category_id: category.id, quantity, price: category.price });
            updateSubtotal();
            updateIncreaseButtonState(quantity, category.ticket_stock, increaseButton);
            updateCheckoutButtonState();
        } else {
            alert('No tickets available.');
        }
    }

    function handleDecreaseButtonClick(category, decreaseButton, quantitySpan, addButton, quantityControlsDiv, increaseButton) {
        let quantity = parseInt(quantitySpan.textContent, 10);
        if (quantity > 1) {
            quantity--;
            quantitySpan.textContent = quantity;
            subtotal -= category.price;
            updateTicketSelection(category.id, quantity);
            updateSubtotal();
            updateIncreaseButtonState(quantity, category.ticket_stock, increaseButton);
        } else {
            quantity = 0;
            addButton.style.display = 'block';
            quantityControlsDiv.style.display = 'none';
            subtotal -= category.price;
            removeTicketSelection(category.id);
            updateSubtotal();
            updateIncreaseButtonState(quantity, category.ticket_stock, increaseButton);
            updateCheckoutButtonState();
        }
    }

    function handleIncreaseButtonClick(category, quantitySpan, increaseButton) {
        let quantity = parseInt(quantitySpan.textContent, 10);
        if (quantity < category.ticket_stock && quantity < 5) {
            quantity++;
            quantitySpan.textContent = quantity;
            subtotal += category.price;
            updateTicketSelection(category.id, quantity);
            updateSubtotal();
            updateIncreaseButtonState(quantity, category.ticket_stock, increaseButton);
        }
    }

    function updateIncreaseButtonState(quantity, stock, increaseButton) {
        if (quantity >= stock || quantity >= 5) {
            increaseButton.disabled = true;
            increaseButton.style.backgroundColor = 'grey';
        } else {
            increaseButton.disabled = false;
            increaseButton.style.backgroundColor = '';
        }
    }

    function updateSubtotal() {
        const subtotalAmountElement = document.getElementById('subtotal-amount');
        subtotalAmountElement.textContent = `Rp${subtotal.toLocaleString('id-ID')}`;
    }

    function updateTicketSelection(categoryId, quantity) {
        const ticket = selectedTickets.find(t => t.event_ticket_category_id === categoryId);
        if (ticket) {
            ticket.quantity = quantity;
        }
    }

    function removeTicketSelection(categoryId) {
        selectedTickets = selectedTickets.filter(t => t.event_ticket_category_id !== categoryId);
    }

    function updateCheckoutButtonState() {
        const checkoutButton = document.querySelector('.checkout-btn');
        if (selectedTickets.length === 0) {
            checkoutButton.disabled = true;
            checkoutButton.style.backgroundColor = 'grey';
        } else {
            checkoutButton.disabled = false;
            checkoutButton.style.backgroundColor = '';
        }
    }

    function checkout() {
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
    }

    function resetUI() {
        selectedTickets = [];
        subtotal = 0;
        updateSubtotal();
        updateCheckoutButtonState();

        document.querySelectorAll('.ticket-category').forEach(categoryElement => {
            const addButton = categoryElement.querySelector('.ticket-add-btn');
            const quantityControls = categoryElement.querySelector('.ticket-quantity-controls');
            const quantityElement = quantityControls ? quantityControls.querySelector('.ticket-quantity') : null;

            if (addButton) addButton.style.display = 'block';
            if (quantityControls) quantityControls.style.display = 'none';
            if (quantityElement) quantityElement.textContent = '1';
        });
    }

    fetchEventDetails();
});
