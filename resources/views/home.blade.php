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
    <div class="container mx-auto p-5 md:p-2.5">
        <h1 class="text-3xl font-bold mb-5">Popular Events</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-12" id="events-container">
            <!-- Event cards will be inserted here by JavaScript -->
        </div>
    </div>
</body>
<script src="{{ asset('js/loadEvents.js') }}"></script>
</html>
