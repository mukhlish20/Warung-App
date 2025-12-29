<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Warung App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --primary: #7367f0;
            --primary-soft: #e9e7fd;
            --bg: #f4f5fa;
            --card: #ffffff;
            --text: #4b4b4b;
            --muted: #9e9e9e;
            --danger: #ea5455;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text);
        }

        .login-wrapper {
            width: 100%;
            max-width: 380px;
            padding: 16px;
        }

        .login-card {
            background: var(--card);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .brand {
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 6px;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 24px;
        }

        label {
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
            display: block;
        }

        .input-group {
            position: relative;
            margin-bottom: 14px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 44px 12px 12px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: var(--muted);
            user-select: none;
        }

        .remember-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--muted);
        }

        .remember input {
            accent-color: var(--primary);
        }

        .forgot {
            text-decoration: none;
            color: var(--primary);
            font-size: 13px;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn:hover {
            opacity: 0.95;
        }

        .error {
            background: #fff1f1;
            border: 1px solid #f3c1c1;
            color: var(--danger);
            padding: 10px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 16px;
            text-align: center;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: var(--muted);
            margin-top: 18px;
        }
    </style>
</head>

<body>

<div class="login-wrapper">
    <div class="login-card">

        <div class="brand">Warung App</div>
        <div class="subtitle">Login ke dashboard</div>

        {{-- ERROR MESSAGE --}}
        @if($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label>Email</label>
            <div class="input-group">
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="email@example.com"
                >
            </div>

            <label>Password</label>
            <div class="input-group">
                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    placeholder="••••••••"
                >
                <span class="toggle-password" onclick="togglePassword()">👁</span>
            </div>

            {{-- REMEMBER + FORGOT --}}
            <div class="remember-row">
                <label class="remember">
                    <input
                        type="checkbox"
                        name="remember"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    Ingat saya
                </label>

                {{-- UI ONLY (backend bisa menyusul) --}}
                <a href="{{ route('password.request') }}" class="forgot">
    Lupa password?</a>
            </div>

            <button class="btn">Login</button>
        </form>

        <div class="footer">
            © {{ date('Y') }} Warung App
        </div>

    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>

</body>
</html>
