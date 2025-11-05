<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>FocusFlow | Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center">
    <div class="bg-white p-8 shadow rounded-xl w-[400px] text-center space-y-3">
        <h1 class="text-xl font-bold text-indigo-600">Selamat datang, {{ session('user')->name }}</h1>
        <p class="text-gray-600">Kamu berhasil login ke FocusFlow 🚀</p>
        <a href="/logout" class="block bg-red-500 text-white py-2 rounded hover:bg-red-600">Logout</a>
    </div>
</body>
</html>
