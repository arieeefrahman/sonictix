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
        document.getElementById('event-date').textContent = new Date(event.start_date).toLocaleDateString('en-US');
        document.getElementById('event-start-time').textContent = new Date(event.start_date).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        document.getElementById('event-end-time').textContent = new Date(event.end_date).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        const eventLocation = document.getElementById('event-location');
        eventLocation.href = event.google_maps_url;
        eventLocation.textContent = event.location;
        document.getElementById('event-description').textContent = event.description;
    }

    function renderTicketCategories(ticketCategories) {
        const ticketList = document.querySelector('.ticket-list');
        ticketList.innerHTML = ''; // Clear previous ticket categories if any

        const template = document.getElementById('ticket-category-template');

        ticketCategories.forEach(category => {
            const ticketCategoryDiv = template.content.cloneNode(true).querySelector('.ticket-category');
            ticketCategoryDiv.dataset.id = category.id;
            ticketCategoryDiv.dataset.stock = category.ticket_stock;

            const colorBarDiv = ticketCategoryDiv.querySelector('.ticket-color-bar');
            colorBarDiv.style.backgroundColor = getRandomColor();

            const nameSpan = ticketCategoryDiv.querySelector('.ticket-name');
            nameSpan.textContent = category.name;

            const priceSpan = ticketCategoryDiv.querySelector('.ticket-price');
            priceSpan.textContent = `Rp${category.price.toLocaleString('id-ID')}`;

            if (category.ticket_stock > 0) {
                const addButton = ticketCategoryDiv.querySelector('.ticket-add-btn');
                const quantityControlsDiv = ticketCategoryDiv.querySelector('.ticket-quantity-controls');
                const decreaseButton = ticketCategoryDiv.querySelector('.decrease');
                const increaseButton = ticketCategoryDiv.querySelector('.increase');
                const quantitySpan = ticketCategoryDiv.querySelector('.ticket-quantity');

                addButton.addEventListener('click', () => handleAddButtonClick(category, addButton, quantityControlsDiv, increaseButton));
                decreaseButton.addEventListener('click', () => handleDecreaseButtonClick(category, decreaseButton, quantitySpan, addButton, quantityControlsDiv, increaseButton));
                increaseButton.addEventListener('click', () => handleIncreaseButtonClick(category, quantitySpan, increaseButton));
            } else {
                ticketCategoryDiv.querySelector('.ticket-add-btn').style.display = 'none';
                ticketCategoryDiv.querySelector('.sold-out').style.display = 'block';
                priceSpan.style.display = 'none'; 
            }

            ticketList.appendChild(ticketCategoryDiv);
        });

        renderCheckoutSummary();
        updateSubtotal();
        updateCheckoutButtonState();
    }

    function renderCheckoutSummary() {
        const ticketCategoriesDiv = document.getElementById('ticket-categories');
        const existingSummary = document.querySelector('.ticket-summary');
        if (existingSummary) {
            existingSummary.remove();
        }

        const summaryTemplate = document.getElementById('ticket-summary-template').content.cloneNode(true);
        ticketCategoriesDiv.appendChild(summaryTemplate);

        // Add event listener to the checkout button
        document.querySelector('.checkout-btn').addEventListener('click', checkout);
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
        const subtotalAmountElement = document.querySelector('.subtotal-amount');
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

        if (!token) {
            Swal.fire({
                title: 'Login Required',
                text: 'You need to login first to proceed with the checkout.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Login',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/login'; // Adjust this URL to your login page
                }
            });
            return;
        }

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
                    Swal.fire({
                        title: "Order has been placed!",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500,
                        showClass: {
                          popup: `
                            animate__animated
                            animate__fadeInUp
                            animate__faster
                          `
                        },
                        hideClass: {
                          popup: `
                            animate__animated
                            animate__fadeOutDown
                            animate__faster
                          `
                        }
                    });
                    fetchEventDetails(); // Re-fetch event details to synchronize ticket stock
                    resetUI(); // Reset the UI after a successful checkout
                    // TODO: 
                    // 1. Redirect to a payment page or clear the selection
                    // 2. Add sweetalert to success and error alert
                } else {
                    Swal.fire({
                        title: "Failed to place order:",
                        icon: "error",
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500,
                        showClass: {
                          popup: `
                            animate__animated
                            animate__fadeInUp
                            animate__faster
                          `
                        },
                        hideClass: {
                          popup: `
                            animate__animated
                            animate__fadeOutDown
                            animate__faster
                          `
                        }
                    });
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
