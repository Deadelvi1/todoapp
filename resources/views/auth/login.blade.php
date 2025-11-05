<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FocusFlow | Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-blue-50 font-sans">
    <form method="POST" action="{{ route('login') }}"
        class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md space-y-6 border border-gray-100">
        @csrf

        <h1 class="text-3xl font-bold text-center text-blue-700">Masuk ke FocusFlow</h1>

        @if(session('error') || $errors->any())
            <div class="bg-red-50 text-red-700 p-3 rounded text-sm">
                {{ session('error') ?? $errors->first() }}
            </div>
        @endif

        <div class="space-y-3">
            <input type="email" name="email" placeholder="Email"
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none" required>

            <input type="password" name="password" placeholder="Password"
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
        </div>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
            Login
        </button>

        <p class="text-center text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-600 font-medium hover:underline">Daftar</a>
        </p>
    </form>
</body>
</html>
