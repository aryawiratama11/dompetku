<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Keuangan Pribadi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Custom CSS untuk sedikit penyesuaian */
        body {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid var(--bs-border-color);
            color: var(--bs-secondary-color);
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary rounded-3 mb-4 shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">Keuangan Pribadi</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('banks.index') }}">Bank/Sumber</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('incomes.index') }}">Pemasukan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('expenses.index') }}">Pengeluaran</a>
                            </li>
                        @endauth
                    </ul>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-link nav-link text-decoration-none me-3" id="theme-toggle" type="button"
                            aria-label="Toggle dark mode">
                            <i class="fas fa-moon d-none"></i> <i class="fas fa-sun d-none"></i> </button>
                        @auth
                            <span class="navbar-text me-3">
                                Halo, {{ Auth::user()->name }}
                            </span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm me-2">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="footer text-center mt-5 py-3">
            <p>&copy; {{ date('Y') }} Aplikasi Keuangan Pribadi. Dibuat dengan ❤️.</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement; // the <html> tag
        const sunIcon = themeToggle.querySelector('.fa-sun');
        const moonIcon = themeToggle.querySelector('.fa-moon');

        // Function to set the theme
        const setTheme = (theme) => {
            htmlElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme); // Save preference
            updateThemeIcons(theme);
        };

        // Function to update the icons based on the current theme
        const updateThemeIcons = (currentTheme) => {
            if (currentTheme === 'dark') {
                sunIcon.classList.remove('d-none');
                moonIcon.classList.add('d-none');
            } else {
                sunIcon.classList.add('d-none');
                moonIcon.classList.remove('d-none');
            }
        };

        // On page load, apply the stored theme or default to light
        document.addEventListener('DOMContentLoaded', () => {
            const storedTheme = localStorage.getItem('theme');
            if (storedTheme) {
                setTheme(storedTheme);
            } else {
                // Check user's system preference (optional)
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    setTheme('dark');
                } else {
                    setTheme('light');
                }
            }
        });

        // Toggle theme on button click
        themeToggle.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            setTheme(newTheme);
        });
    </script>
</body>

</html>
