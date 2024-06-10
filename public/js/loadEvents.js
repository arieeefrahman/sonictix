document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    const eventsContainer = document.getElementById('events-container');
    const loadMoreButton = document.getElementById('load-more-button');
    const eventCardTemplate = document.getElementById('event-card-template').content;

    loadMoreButton.addEventListener('click', () => {
        loadEvents(currentPage + 1);
    });

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
                const link = document.createElement('link');
                link.rel = 'preload';
                link.as = 'image';
                link.href = event.image;
                document.head.appendChild(link);

                let minPrice = Math.min(...event.event_ticket_categories.map(category => category.price));
                
                const card = document.importNode(eventCardTemplate, true);

                card.querySelector('.event-image').src = event.image;
                card.querySelector('.event-image').alt = event.title;
                card.querySelector('.event-date').textContent = new Date(event.start_date).toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                });
                card.querySelector('.event-title').textContent = event.title;
                card.querySelector('.event-location').textContent = event.location;
                card.querySelector('.event-price').textContent = `Rp${minPrice.toLocaleString('id-ID')}`;

                card.querySelector('.cursor-pointer').addEventListener('click', () => {
                    window.location.href = `/event/${event.id}`;
                });

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
