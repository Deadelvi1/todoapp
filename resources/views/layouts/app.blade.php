<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Timer App</title>
    <link href="./output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>
<body class="bg-light min-h-screen">
    @include('layouts.header')

    <div class="main-content mt-20">
        <div class="container mx-auto" style="margin-top: 0; padding-top: 20px;">
            @if(session('success'))
                <div class="alert alert-success" style="color: #0a7a18; background: #eafbe7; border: 1px solid #b8e4b0; border-radius: 8px; padding: 10px 15px; margin-bottom: 15px; font-size: 14px;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" style="color: #721c24; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; padding: 10px 15px; margin-bottom: 15px; font-size: 14px;">
                    ❌ {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" style="color: #721c24; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; padding: 12px 15px; margin-bottom: 15px; font-size: 14px;">
                    <strong>Terjadi kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @include('layouts.footer')
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('mobileMenuBtn');
    const menu = document.getElementById('mobileMenu');

    menuBtn.addEventListener('click', () => {
        // Toggle hidden and slide animation
        menu.classList.toggle('hidden');
        if (!menu.classList.contains('hidden')) {
            menu.classList.add('animate-slideDown');
        } else {
            menu.classList.remove('animate-slideDown');
        }
    });
});
    </script>
</body>
</html>
