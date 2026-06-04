<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>MentorCampus</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        body {
            font-family: 'Lexend', sans-serif;
        }
    </style>

</head>

<body class="bg-gray-100">

    {{-- NAVBAR --}}
    @extends('components.admin-navbar')
    
    {{ $slot ?? '' }}
    @yield('content')

</body>
</html>