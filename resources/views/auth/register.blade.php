<!doctype html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng ký — TechXpress</title>
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
            <h1 class="auth-title">Tạo tài khoản</h1>
            <p class="auth-subtitle">Đăng ký miễn phí và mua sắm ngay hôm nay!</p>

            @if (session('error'))
                <div class="alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Họ tên --}}
                <div class="form-group">
                    <label class="form-label">Họ và tên</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-user input-icon"></i>
                        <input type="text" name="name"
                            class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            value="{{ old('name') }}" placeholder="Họ và tên" autocomplete="name" />
                    </div>
                    @error('name')
                        <div class="invalid-feedback">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

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
                            placeholder="Tối thiểu 6 ký tự" autocomplete="new-password"
                            oninput="checkStrength(this.value)" />
                        <button type="button" class="toggle-pw" onclick="togglePw('password','pwIcon')">
                            <i class="fa-solid fa-eye" id="pwIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                    <div class="pw-strength" id="pwStrength">
                        <div class="pw-bar-wrap">
                            <div class="pw-bar" id="pwBar"></div>
                        </div>
                        <div class="pw-label" id="pwLabel"></div>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label class="form-label">Xác nhận mật khẩu</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-input {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                            placeholder="Nhập lại mật khẩu" autocomplete="new-password" />
                        <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation','pwIcon2')">
                            <i class="fa-solid fa-eye" id="pwIcon2"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Terms -- tách checkbox và text ra để tránh vỡ layout --}}
                <div class="terms-wrap">
                    <input type="checkbox" name="terms" id="terms" required />
                    <label for="terms" class="terms-text">
                        Tôi đồng ý với <a href="#">Điều khoản sử dụng</a> và <a href="#">Chính sách bảo
                            mật</a> của TechXpress.
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-user-plus"></i> Tạo tài khoản
                </button>
            </form>

            <div class="divider">đã có tài khoản?</div>

            <div class="auth-switch">
                <a href="{{ route('login') }}">
                    <i class="fa-solid fa-right-to-bracket"></i> Đăng nhập ngay
                </a>
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

        function checkStrength(val) {
            const wrap = document.getElementById('pwStrength');
            const bar = document.getElementById('pwBar');
            const label = document.getElementById('pwLabel');
            if (!val) {
                wrap.classList.remove('show');
                return;
            }
            wrap.classList.add('show');
            let score = 0;
            if (val.length >= 6) score++;
            if (val.length >= 10) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            const levels = [{
                    w: '20%',
                    color: '#ef4444',
                    text: 'Rất yếu'
                },
                {
                    w: '40%',
                    color: '#f97316',
                    text: 'Yếu'
                },
                {
                    w: '60%',
                    color: '#eab308',
                    text: 'Trung bình'
                },
                {
                    w: '80%',
                    color: '#22c55e',
                    text: 'Mạnh'
                },
                {
                    w: '100%',
                    color: '#16a34a',
                    text: 'Rất mạnh'
                },
            ];
            const lv = levels[Math.min(score - 1, 4)] || levels[0];
            bar.style.width = lv.w;
            bar.style.background = lv.color;
            label.style.color = lv.color;
            label.textContent = lv.text;
        }
    </script>
</body>

</html>
