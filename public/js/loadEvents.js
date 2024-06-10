document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    const eventsContainer = document.getElementById('events-container');
    const loadMoreButton = document.createElement('button');
    loadMoreButton.className = 'font-bold block mx-auto my-5 py-2.5 px-5 bg-blue-600 text-white border-none rounded-md cursor-pointer transition-transform duration-300 ease-in-out hover:-translate-y-1.5';
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
                    card.className = 'cursor-pointer bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-200 hover:-translate-y-2 relative';
                    card.innerHTML = `
                        <img src="${event.image}" alt="${event.title}" class="w-full h-36 object-cover">
                        <div class="p-4">
                            <div class="absolute top-2.5 right-2.5 bg-gray-800 text-white px-2.5 py-1.5 rounded-md text-xs font-bold">${new Date(event.start_date).toLocaleDateString('en-GB', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            })}</div>
                            <h3 class="text-lg font-bold mb-2.5 whitespace-nowrap overflow-hidden text-ellipsis">${event.title}</h3>
                            <p class="text-sm text-gray-500 mb-2.5"><i class="fas fa-map-marker-alt"></i>&ensp;${event.location}</p>
                            <p class="text-base font-bold text-orange-600 mb-2.5">Start from: Rp${minPrice.toLocaleString('id-ID')}</p>
                        </div>
                    `;
                    
                    card.addEventListener('click', () => {
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