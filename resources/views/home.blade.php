<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SonicTIX - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/event.css') }}">
</head>
<body>
    @include('navbar')
    <div class="container">
        <h1>Popular Events</h1>
        <div class="card-grid" id="events-container">
            <!-- Event cards will be inserted here by JavaScript -->
        </div>
    </div>
</body>
<script src="{{ asset('js/loadEvents.js') }}"></script>
</html>
