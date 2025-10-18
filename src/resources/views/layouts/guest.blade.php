<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ "Qio Coffee" . ' | ' . $title ?? env('APP_NAME') }} </title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="antialiased">
    {{ $slot }}
    @livewireScripts
</body>
</html>
