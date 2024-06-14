<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SonicTIX - Your Tickets</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
</head>
<body class="body-setup-home font-lato">
    @include('navbar')
    <div class="container mx-auto my-10">
        <h1 class="text-center text-xl font-semibold mb-10">Your Tickets</h1>
        <div id="tickets-container" class="flex flex-col">
            <div id="ticket-template" class="hidden shadow-xl rounded-lg p-10 flex flex-row mb-3 bg-white">
                <img src="" alt="Event Image" class="basis-1/4 h-auto w-3 rounded-lg event-image">
                <div class="basis-3/4 pl-11 flex flex-col justify-between ">
                    <div class="basis-2/3">
                        <h2 class="text-xl font-semibold event-title"></h2>
                    </div>
                    <div class="basis-1/3 flex flex-col mt-5">
                        <p class="text-gray-600 total-tickets"></p>
                        <div class="flex flex-col md:flex-row justify-between items-center">
                            <p class="text-gray-600 subtotal pt-5"></p>
                            <button class="bg-brightBlue text-white px-10 py-2 rounded-lg font-semibold hover:bg-brightBlueHover">Pay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('js/fetchOrder.js') }}"></script>
</html>
