<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SonicTIX - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
</head>
<body class="body-setup-home font-lato">
    @include('navbar')
    <div class="container mx-auto my-5 p-5 md:p-2.5">
        <h1 class="text-xl font-bold mb-5">Popular Events</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-12" id="events-container">
            <!-- Event cards will be inserted here by JavaScript -->
        </div>
        <button id="load-more-button" class="font-bold block mx-auto my-5 py-2.5 px-5 bg-blue-600 text-white border-none rounded-md cursor-pointer transition-transform duration-300 ease-in-out hover:-translate-y-1.5">
            Load More
        </button>
    </div>

    <template id="event-card-template">
        <div class="cursor-pointer bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-200 hover:-translate-y-2 relative">
            <img src="" alt="" class="w-full h-36 object-cover event-image">
            <div class="p-4">
                <div class="absolute top-2.5 right-2.5 bg-gray-800 text-white px-2.5 py-1.5 rounded-md text-xs font-bold event-date"></div>
                <h3 class="text-lg font-bold mb-2.5 whitespace-nowrap overflow-hidden text-ellipsis event-title"></h3>
                <p class="text-sm text-gray-500 mb-2.5"><i class="fas fa-map-marker-alt"></i>&ensp;<span class="event-location"></span></p>
                <p class="text-base font-bold text-orange-600 mb-2.5">Start from: <span class="event-price"></span></p>
            </div>
        </div>
    </template>
</body>
<script src="{{ asset('js/loadEvents.js') }}"></script>
</html>
