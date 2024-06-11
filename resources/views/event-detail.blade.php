<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SonicTIX - Event Detail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
</head>
<body class="bg-brightWhite font-lato">
    @include('navbar')
    <div class="p-10 m-0 h-screen">
        <div class="flex flex-col lg:flex-row">

            <!-- event detail card -->
            <div class="flex basis-1/2 lg:basis-2/3 flex-col mx-auto max-w-3xl bg-white rounded-lg py-5 px-12 shadow-eventDetail">
                <div class="text-2xl font-bold">Event Detail</div>
                
                <div class="flex flex-col lg:flex-row mt-5">
                    <div class="flex basis-1/2">
                        <img src="" alt="" id="event-image" class="object-contain rounded-lg">
                    </div>
                    <div class="basis-1/2">
                        <h1 id="event-title" class="basis-1/4 py-3 px-0 font-bold lg:pl-2 lg:pt-0 text-xl lg:text-base"></h1>
                        <div class="basis-1/4 py-1">
                            <div class="basis-0 flex flex-row justify-center pl-0 lg:pl-2">
                                <div class="basis-1/6 flex items-"><img src="{{ asset('icons/calendar-lines.svg') }}" alt="" class="h-5"></div>
                                <div class="basis-5/6"><span id="event-date"></span></div>
                            </div>
                        </div>
                        <div class="basis-1/4 py-1">
                            <div class="basis-0 flex flex-row justify-center pl-0 lg:pl-2">
                                <div class="basis-1/6 flex items-"><img src="{{ asset('icons/clock-five.svg') }}" alt="" class="h-5"></div>
                                <div class="basis-5/6"><span id="event-start-time"></span> - <span id="event-end-time"></span></div>
                            </div>
                        </div>
                        <div class="basis-1/4 py-1">
                            <div class="basis-0 flex flex-row pl-0 lg:pl-2">
                                <div class="basis-1/6 flex-none"><img src="{{ asset('icons/marker.svg') }}" alt="" class="h-5"></div>
                                <div class="basis-5/6 flex-1"><a id="event-location" href="" target="_blank"></a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col mt-4">
                    <div class="basis-1/2 font-semibold">
                        Description:
                    </div>
                    <div class="basis-1/2 text-justify">
                        <span id="event-description"></span>
                    </div>
                </div>
            </div>

            <!-- ticket categories card -->
            <div class="flex basis-1/2 lg:basis-1/3 flex-col my-5 lg:my-0 lg:ml-2.5 mx-auto bg-white rounded-lg py-5 px-12 shadow-eventDetail w-full lg:w-auto">
                <div id="ticket-categories" class="ticket-categories mt-4 flex flex-wrap lg:flex-col w-full">
                    <h2 class="text-xl font-bold mb-2 w-full">Ticket Categories</h2>
                    <div class="ticket-list bg-white rounded-lg overflow-y-auto max-h-96 flex flex-wrap lg:flex-col w-full"></div>
                </div>
            </div>

        </div>
    </div>

    <template id="ticket-category-template">
        <div class="ticket-category flex justify-between items-center p-2 border border-gray-300 rounded-lg relative mb-2 w-full lg:w-auto">
            <div class="ticket-color-bar absolute left-0 top-0 bottom-0 w-1 rounded-l-lg"></div>
            <span class="ticket-name font-bold text-gray-800 flex-1 mx-2"></span>
            <span class="ticket-price text-blue-500 font-bold flex-1 mx-2 text-center"></span>
            <div class="ticket-controls flex items-center flex-1 mx-2 justify-end">
                <button class="ticket-add-btn bg-blue-500 text-white py-1 px-3 rounded transition duration-300 hover:bg-blue-700">Add</button>
                <div class="ticket-quantity-controls flex items-center" style="display: none;">
                    <button class="ticket-btn decrease bg-blue-500 text-white py-1 px-3 rounded transition duration-300 hover:bg-blue-700">-</button>
                    <span class="ticket-quantity mx-2 font-bold">1</span>
                    <button class="ticket-btn increase bg-blue-500 text-white py-1 px-3 rounded transition duration-300 hover:bg-blue-700">+</button>
                </div>
            </div>
            <button class="sold-out bg-gray-300 text-gray-600 py-1 px-3 rounded cursor-not-allowed hidden">Sold Out</button>
        </div>
    </template>


    <template id="ticket-summary-template">
        <div class="ticket-summary flex justify-between items-center mt-4 p-2 border-t border-gray-300 bg-gray-100 rounded w-full lg:w-auto">
            <div class="flex flex-col">
                <span class="subtotal-label font-bold text-gray-800">Subtotal</span>
                <span class="subtotal-amount text-blue-500 font-bold"></span>
            </div>
            <button class="checkout-btn bg-blue-500 text-white py-2 px-4 rounded font-bold transition duration-300 hover:bg-blue-700">Checkout</button>
        </div>
    </template>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/loadEventDetail.js') }}"></script>
</body>
</html>
