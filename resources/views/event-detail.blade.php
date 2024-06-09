<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SonicTIX - Event Detail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/event-detail.css') }}">
</head>
<body>
    @include('navbar')
    <div class="container">
        <div id="event-detail-container" class="event-detail-container">
            <h1 id="event-title"></h1>
            <div class="event-image">
                <img id="event-image" src="" alt="">
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
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('js/loadEventDetail.js') }}"></script>
</html>
