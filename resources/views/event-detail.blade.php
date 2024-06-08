<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SonicTIX - Event Detail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/event-detail.css') }}">
</head>
<body>
    @include('navbar')
    <div class="container">
        <div id="event-detail-container" class="event-detail-container">
            <!-- Event details will be dynamically inserted here by JavaScript -->
        </div>
    </div>
</body>
<script src="{{ asset('js/loadEventDetail.js') }}"></script>
</html>
