<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Qio Coffee | {{ $title ?? "Welcome" }}</title>
        @vite(["resources/css/app.css", "resources/js/app.js"])
        @livewireStyles
    </head>
    <body class="antialiased font-Rubik">
        {{ $slot }}
        @livewireScripts
    </body>
</html>
