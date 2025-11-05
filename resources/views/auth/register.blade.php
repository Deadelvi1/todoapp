<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FocusFlow | Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-blue-50 font-sans">
    <form method="POST" action="{{ route('register') }}"
        class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md space-y-6 border border-gray-100">
        @csrf

        <h1 class="text-3xl font-bold text-center text-blue-700">Buat Akun FocusFlow</h1>

        @if($errors->any())
            <div class="bg-red-50 text-red-700 p-3 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="space-y-3">
            <input type="text" name="name" placeholder="Nama Lengkap"
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none" required>

            <input type="email" name="email" placeholder="Email"
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none" required>

            <input type="password" name="password" placeholder="Password"
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none" required>

            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
        </div>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
            Daftar
        </button>

        <p class="text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Login</a>
        </p>
    </form>
</body>
</html>
