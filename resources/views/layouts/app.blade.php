<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
            rel="stylesheet"
        />
        <title>{{ "Qio Coffee | " . ($title ?? "App") }}</title>
        @vite(["resources/css/app.css", "resources/js/app.js"])
        @livewireStyles
    </head>
    <body class="antialiased bg-gray-50 font-Rubik">
        <div x-data="{ isSidebarOpen: false }">
            <livewire:components.navbar />
            <livewire:components.sidebar />
        </div>
        <main class="pt-16 sm:ml-64">
            <div class="p-4">
                {{ $slot }}
            </div>
        </main>

        @livewireScripts
    </body>
</html>
