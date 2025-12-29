<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password | Warung App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background:#f4f5fa;
            display:flex;
            align-items:center;
            justify-content:center;
            min-height:100vh;
            font-family:system-ui;
        }
        .card {
            background:#fff;
            padding:28px;
            border-radius:16px;
            width:100%;
            max-width:380px;
            box-shadow:0 10px 30px rgba(0,0,0,.08);
        }
        h2 { margin:0 0 6px; }
        p { color:#777;font-size:14px }
        input {
            width:100%;
            padding:12px;
            margin-top:14px;
            border-radius:10px;
            border:1px solid #ddd;
        }
        button {
            margin-top:16px;
            width:100%;
            padding:12px;
            background:#7367f0;
            color:#fff;
            border:none;
            border-radius:10px;
            font-weight:600;
        }
        .msg {
            background:#e9e7fd;
            color:#4b4b4b;
            padding:10px;
            border-radius:10px;
            margin-bottom:14px;
            font-size:14px;
        }
        .error {
            background:#fff1f1;
            color:#ea5455;
            padding:10px;
            border-radius:10px;
            margin-bottom:14px;
            font-size:14px;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Lupa Password</h2>
    <p>Masukkan email akun Anda</p>

    @if(session('status'))
        <div class="msg">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="email" name="email" required placeholder="email@example.com">
        <button>Kirim Link Reset</button>
    </form>
</div>

</body>
</html>
