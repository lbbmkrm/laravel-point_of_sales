<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ "Qio Coffee | " . $title ?? 'App' }}</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="antialiased bg-gray-50">

    
    <div x-data="{isSidebarOpen: false}">
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
