document.addEventListener('DOMContentLoaded', function() {
    const eventDetailContainer = document.getElementById('event-detail-container');
    
    function getEventIdFromUrl() {
        const url = window.location.pathname;
        const segments = url.split('/');
        const eventIndex = segments.indexOf('event');
        return segments[eventIndex + 1]; // Get the segment after 'event'
    }

    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    const eventId = getEventIdFromUrl();
    if (isNaN(eventId)) {
        console.error('Error: Event ID is not a numeric value.');
        return;
    }    

    fetch(`/api/event/${eventId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'success') {
                console.error('Error fetching event details:', data.message);
                return;
            }

            const event = data.data; // Adjust according to the API response structure
            const ticketCategories = event.event_ticket_categories;
            let subtotal = 0;

            const renderTicketCategories = () => {
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
                            <button class="sold-out">Sold Out</button>
                        `}
                    </div>
                `).join('');

                const ticketSummaryHtml = `
                    <div class="ticket-summary">
                        <span class="subtotal-label">Subtotal</span>
                        <span class="subtotal-amount">Rp${subtotal.toLocaleString('id-ID')}</span>
                        <button class="checkout-btn">Checkout</button>
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
                    const decreaseButton = categoryElement.querySelector('.decrease');
                    const increaseButton = categoryElement.querySelector('.increase');
                    const quantityElement = categoryElement.querySelector('.ticket-quantity');
                    const priceElement = categoryElement.querySelector('.ticket-price');
                    const stock = parseInt(categoryElement.getAttribute('data-stock'), 10);
                    const price = parseInt(priceElement.textContent.replace('Rp', '').replace('.', ''));

                    let quantity = 0;

                    addButton.addEventListener('click', () => {
                        if (stock > 0) {
                            quantity = 1;
                            addButton.style.display = 'none';
                            quantityControls.style.display = 'flex';
                            subtotal += price;
                            updateSubtotal();
                            updateIncreaseButtonState();
                        } else {
                            alert('No tickets available.');
                        }
                    });

                    decreaseButton.addEventListener('click', () => {
                        if (quantity > 1) {
                            quantity--;
                            quantityElement.textContent = quantity;
                            subtotal -= price;
                            updateSubtotal();
                            updateIncreaseButtonState();
                        } else {
                            quantity = 0;
                            addButton.style.display = 'block';
                            quantityControls.style.display = 'none';
                            subtotal -= price;
                            updateSubtotal();
                            updateIncreaseButtonState();
                        }
                    });

                    increaseButton.addEventListener('click', () => {
                        if (quantity < stock) {
                            quantity++;
                            quantityElement.textContent = quantity;
                            subtotal += price;
                            updateSubtotal();
                            updateIncreaseButtonState();
                        }
                    });

                    const updateIncreaseButtonState = () => {
                        if (quantity >= stock) {
                            increaseButton.disabled = true;
                            increaseButton.style.backgroundColor = 'grey'; // Optional: Style to indicate disabled state
                        } else {
                            increaseButton.disabled = false;
                            increaseButton.style.backgroundColor = ''; // Reset to default style
                        }
                    };
                });

                updateSubtotal();
            };

            const updateSubtotal = () => {
                document.querySelector('.subtotal-amount').textContent = `Rp${subtotal.toLocaleString('id-ID')}`;
            };

            renderTicketCategories();
        })
        .catch(error => console.error('Error fetching event details:', error));
});
