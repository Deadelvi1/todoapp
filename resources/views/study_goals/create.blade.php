<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tambah Goal</title>
</head>
<body>
    <h1>Tambah Goal</h1>
    <p><a href="{{ route('study-goals.index') }}">Kembali</a></p>

    @if($errors->any())
        <div style="color:red">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('study-goals.store') }}" method="POST">
        @csrf
        <div>
            <label>Title</label>
            <input type="text" name="title" required>
        </div>
        <div>
            <label>Target Hours</label>
            <input type="number" name="target_hours" min="0">
        </div>
        <div>
            <button type="submit">Simpan</button>
        </div>
    </form>
</body>
</html>
