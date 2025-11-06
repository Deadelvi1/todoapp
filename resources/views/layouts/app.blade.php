<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Timer App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
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
<body class="bg-light">
    @include('layouts.header')
    
    <div class="main-content">
        <div class="container mt-4">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
