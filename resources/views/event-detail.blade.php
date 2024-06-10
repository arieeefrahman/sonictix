<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SonicTIX - Event Detail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
</head>
<body>
    @include('navbar')
    <div class="p-0 m-0 bg-brightWhite font-lato">
        <div class="flex flex-col mx-auto max-w-3xl bg-white rounded-lg py-5 px-12 shadow-eventDetail">
            <!-- <h1 id="event-title"></h1>
            <div class="flex items-center justify-center mb-5">
                <img src="" alt="" id="event-image" class="max-w-xs h-1/2 rounded-lg">
            </div>

            <div class="event-info">
                <p><strong>Start date:</strong> <span id="event-start-date"></span></p>
                <p><strong>End date:</strong> <span id="event-end-date"></span></p>
                <p><strong>Location:</strong> <a id="event-location" href="" target="_blank"></a></p>
                <p><strong>Description:</strong> <span id="event-description"></span></p>
            </div>

            <div id="ticket-categories" class="ticket-categories">
                <h2>Ticket Categories</h2>
                <div class="ticket-list" id="ticket-list"></div>
                <div class="ticket-summary">
                    <span class="subtotal-label">Subtotal</span>
                    <span class="subtotal-amount" id="subtotal-amount">Rp0</span>
                    <button class="checkout-btn" disabled>Checkout</button>
                </div>
            </div> -->
            <div class="text-2xl font-bold">Event Detail</div>

            <div class="flex flex-col md:flex-row mt-5">
                <div class="flex basis-1/2 border border-black">
                    <img src="" alt="" id="event-image" class="object-contain rounded-lg">
                </div>
                <div class="basis-1/2 border border-black">
                    <h1 id="event-title" class="basis-1/4 border border-red-500 py-3 px-0 font-bold md:pl-2 md:pt-0"></h1>
                    <div class="basis-1/4 border border-red-500 py-1">
                        <div class="basis-0 flex flex-row justify-center border border-green-500 pl-0 md:pl-2">
                            <div class="basis-1/6 border border-blue-500 flex items-"><img src="{{ asset('icons/calendar-lines.svg') }}" alt="" class="h-5"></div>
                            <div class="basis-5/6 border border-blue-500"><span id="event-date"></span></div>
                        </div>
                    </div>
                    <div class="basis-1/4 border border-red-500 py-1">
                        <div class="basis-0 flex flex-row justify-center border border-green-500 pl-0 md:pl-2">
                            <div class="basis-1/6 border border-blue-500 flex items-"><img src="{{ asset('icons/clock-five.svg') }}" alt="" class="h-5"></div>
                            <div class="basis-5/6 border border-blue-500"><span id="event-start-time"></span> - <span id="event-end-time"></span></div>
                        </div>
                    </div>
                    <div class="basis-1/4 border border-red-500 py-1">
                        <div class="basis-0 flex flex-row border border-green-500 pl-0 md:pl-2">
                            <div class="basis-1/6 flex-none border border-indigo-500"><img src="{{ asset('icons/marker.svg') }}" alt="" class="h-5"></div>
                            <div class="basis-5/6 flex-1 border border-indigo-500"><a id="event-location" href="" target="_blank"></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col mt-4">
                <div class="basis-1/2 border border-black font-semibold">
                    Description:
                </div>
                <div class="basis-1/2 border border-black text-justify">
                    <span id="event-description"></span>
                </div>
            </div>

            <div class="text-2xl font-bold mt-10">Event Ticket Categories</div>

        </div>
        </div>

    </div>
</body>
<script src="{{ asset('js/loadEventDetail.js') }}"></script>
</html>
