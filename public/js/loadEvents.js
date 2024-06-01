document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    const eventsContainer = document.getElementById('events-container');
    const loadMoreButton = document.createElement('button');
    loadMoreButton.id = 'load-more-button';
    loadMoreButton.textContent = 'Load More';

    loadMoreButton.addEventListener('click', () => {
        loadEvents(currentPage + 1);
    });

    document.body.appendChild(loadMoreButton);

    function loadEvents(page) {
        fetch(`/api/events?page=${page}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.status !== 'success') {
                    console.error('Error fetching events:', data.message);
                    return;
                }

                data.data.data.forEach(event => {
                    // Preload the event image
                    const link = document.createElement('link');
                    link.rel = 'preload';
                    link.as = 'image';
                    link.href = event.image;
                    document.head.appendChild(link);

                    // Find the lowest price from event_ticket_categories
                    let minPrice = Math.min(...event.event_ticket_categories.map(category => category.price));
                    
                    const card = document.createElement('div');
                    card.className = 'card';
                    imgURL = 'https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg'
                    card.innerHTML = `
                        <img src="${imgURL}" alt="${event.title}">
                        <div class="card-body">
                            <div class="card-date">${new Date(event.start_date).toLocaleDateString('en-GB', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            })}</div>
                            <h3 class="card-title">${event.title}</h3>
                            <p class="card-location"><i class="fas fa-map-marker-alt"></i> ${event.location}</p>
                            <p class="card-price">Start from: Rp${minPrice.toLocaleString('id-ID')}</p>
                        </div>
                    `;

                    eventsContainer.appendChild(card);
                });

                currentPage = page;

                if (!data.data.next_page_url) {
                    loadMoreButton.style.display = 'none';
                }
            })
            .catch(error => console.error('Error fetching events:', error));
    }

    loadEvents(currentPage);
});