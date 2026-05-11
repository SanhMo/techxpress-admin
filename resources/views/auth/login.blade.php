<!doctype html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng nhập — TechXpress</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;700&family=Be+Vietnam+Pro:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
</head>

<body>
    <div class="auth-wrap">

        <a href="{{ route('home') }}" class="auth-logo">
            <div class="logo-icon">T<span style="font-size:11px">X</span></div>
            <div class="logo-text">Tech<span>Xpress</span></div>
        </a>

        <div class="auth-card">
            <h1 class="auth-title">Đăng nhập</h1>
            <p class="auth-subtitle">Chào mừng trở lại! Nhập thông tin để tiếp tục.</p>

            @if (session('error'))
                <div class="alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-envelope input-icon"></i>
                        <input type="email" name="email"
                            class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            value="{{ old('email') }}" placeholder="example@email.com" autocomplete="email" />
                    </div>
                    @error('email')
                        <div class="invalid-feedback">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label">Mật khẩu</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" name="password" id="password"
                            class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="Nhập mật khẩu" autocomplete="current-password" />
                        <button type="button" class="toggle-pw" onclick="togglePw('password','pwIcon')">
                            <i class="fa-solid fa-eye" id="pwIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="form-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} />
                        Ghi nhớ đăng nhập
                    </label>
                    <a href="#" class="forgot-link">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-right-to-bracket"></i> Đăng nhập
                </button>
            </form>

            <div class="divider">hoặc</div>

            <div class="auth-switch">
                Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
            </div>
        </div>

        <a href="{{ route('home') }}" class="back-home">
            <i class="fa-solid fa-arrow-left"></i> Quay về trang chủ
        </a>
    </div>

    <script>
        function togglePw(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.className = input.type === 'text' ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
        }
    </script>
</body>

</html>
