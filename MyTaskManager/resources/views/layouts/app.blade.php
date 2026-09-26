<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'My Tasks') | Task Desk</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <header class="site-header">
            <div class="header-inner">
                <a class="brand" href="{{ route('tasks.index', absolute: false) }}">
                    <span class="brand-mark" aria-hidden="true">&#10003;</span>
                    <span>Task <strong>Desk</strong></span>
                </a>
                <nav class="main-nav" aria-label="Main navigation">
                    <a class="nav-link nav-link-active" href="{{ route('tasks.index', absolute: false) }}">My Tasks</a>
                </nav>
            </div>
        </header>

        <div class="page-shell">
            <main>
                @if (session('success'))
                    <p class="flash-message" role="status">{{ session('success') }}</p>
                @endif

                @yield('content')
            </main>
        </div>
    </body>
</html>