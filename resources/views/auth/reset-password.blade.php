<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password | Warung App</title>
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
        input {
            width:100%;
            padding:12px;
            margin-top:12px;
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
    <h2>Reset Password</h2>

    @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="email" name="email" value="{{ $email }}" required>
        <input type="password" name="password" placeholder="Password baru" required>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi password" required>
        <button>Reset Password</button>
    </form>
</div>

</body>
</html>
