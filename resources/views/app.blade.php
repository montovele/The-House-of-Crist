<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
        <title>Scaling Places</title>
    </head>
    <body class="bg-gray-50 h-screen antialiased leading-none font-sans">

        <div id="app"></div>

        <script src="{{mix('js/app.js')}}"></script>
        
    </body>
</html>
