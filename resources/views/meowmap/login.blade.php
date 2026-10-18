<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f7f8f3">
    <title>Login — MeowMap</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --green: #47734c;
            --green-dark: #365b3b;
            --green-light: #f0f5ec;
            --background: #f7f8f3;
            --text: #292b27;
            --muted: #777b72;
            --border: #e8e9e2;
            --input-border: #d9ded5;
            --danger: #b91c1c;
        }

        body {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
            background: var(--background);
        }

        button,
        input {
            font: inherit;
        }

        .card {
            width: 100%;
            max-width: 420px;
            padding: 36px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: 0 16px 45px rgba(41, 43, 39, 0.07);
        }

        .brand {
            margin-bottom: 28px;
            text-align: center;
        }

        .brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 62px;
            height: 62px;
            margin-bottom: 16px;
            border-radius: 19px;
            background: var(--green-light);
            font-size: 33px;
        }

        .brand h1 {
            margin-bottom: 8px;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.7px;
        }

        .brand h1 span {
            color: var(--green);
        }

        .brand p {
            margin-top: 10px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
        }

        .input-wrapper {
            position: relative;
        }

        input {
            display: block;
            width: 100%;
            min-width: 0;
            padding: 13px 14px;
            border: 1px solid var(--input-border);
            border-radius: 10px;
            outline: none;
            color: var(--text);
            background: #fff;
            font-size: 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input::placeholder {
            color: #a0a39b;
        }

        input:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(71, 115, 76, 0.12);
        }

        .input-wrapper input {
            padding-right: 48px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            transform: translateY(-50%);
            border: none;
            border-radius: 6px;
            color: var(--muted);
            background: transparent;
            cursor: pointer;
        }

        .password-toggle:hover {
            color: var(--green);
            background: var(--green-light);
        }

        .password-toggle:focus-visible {
            outline: 2px solid var(--green);
            outline-offset: 2px;
        }

        .password-toggle svg {
            width: 19px;
            height: 19px;
        }

        .login-button {
            width: 100%;
            margin-top: 4px;
            padding: 14px;
            border: none;
            border-radius: 10px;
            color: #fff;
            background: var(--green);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }

        .login-button:hover {
            background: var(--green-dark);
        }

        .login-button:active {
            transform: scale(0.99);
        }

        .login-button:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0;
            color: var(--muted);
            font-size: 11px;
            font-weight: 600;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .google-auth-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            padding: 13px 16px;
            border: 1px solid var(--input-border);
            border-radius: 10px;
            color: var(--text);
            background: #fff;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: background 0.2s, border-color 0.2s;
        }

        .google-auth-button:hover {
            background: var(--background);
            border-color: var(--green);
        }

        .google-auth-button:focus-visible {
            outline: 2px solid var(--green);
            outline-offset: 3px;
        }

        .google-auth-button svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        #message {
            margin-top: 14px;
            white-space: pre-line;
            overflow-wrap: anywhere;
            font-size: 13px;
            line-height: 1.6;
        }

        .error {
            color: var(--danger);
        }

        .success {
            color: #26713a;
        }

        .auth-links {
            margin-top: 24px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
            text-align: center;
        }

        .auth-links a {
            color: var(--green);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

        .back-link {
            display: block;
            margin-top: 18px;
            color: var(--muted) !important;
            font-size: 12px;
            font-weight: 400 !important;
        }

        @media (max-width: 480px) {
            body {
                padding: 16px;
            }

            .card {
                padding: 28px 22px;
                border-radius: 18px;
            }

            .brand h1 {
                font-size: 24px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>

    <main class="card">
        <header class="brand">
            <div class="brand-icon" aria-hidden="true">🐱</div>

            <h1>Meow<span>Map.</span></h1>

            <p>
                Selamat datang kembali! Login untuk melaporkan
                kucing dan membantu komunitas di sekitar kita.
            </p>
        </header>

        @if (session('error'))
            <div
                style="margin-bottom:18px;padding:12px 14px;border-radius:10px;background:#fef2f2;border:1px solid #fecaca;color:#991b1b;font-size:13px;line-height:1.6;"
                role="alert"
            >
                {{ session('error') }}
            </div>
        @endif

        <form id="login-form">
            <div class="form-group">
                <label for="email">Alamat email</label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="username"
                    maxlength="255"
                    required
                    placeholder="nama@email.com"
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <div class="input-wrapper">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        placeholder="Masukkan password"
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        id="password-toggle"
                        aria-label="Tampilkan password"
                        aria-pressed="false"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button
                type="submit"
                id="login-button"
                class="login-button"
            >
                Login
            </button>

            <p id="message" role="status" aria-live="polite"></p>
        </form>

        <div class="divider">ATAU LOGIN DENGAN</div>

        <a
            href="{{ route('google.redirect') }}"
            class="google-auth-button"
        >
            <svg viewBox="0 0 48 48" aria-hidden="true">
                <path fill="#EA4335"
                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                <path fill="#4285F4"
                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.76 7.18l7.73 6C44.42 37.98 46.98 31.9 46.98 24.55z"/>
                <path fill="#FBBC05"
                    d="M10.53 28.59A14.4 14.4 0 0 1 9.75 24c0-1.59.27-3.13.76-4.59l-7.98-6.19A23.9 23.9 0 0 0 0 24c0 3.87.93 7.55 2.56 10.78l7.97-6.19z"/>
                <path fill="#34A853"
                    d="M24 48c6.48 0 11.93-2.13 15.91-5.8l-7.73-6c-2.14 1.44-4.89 2.3-8.18 2.3-6.26 0-11.57-4.22-13.46-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
            </svg>
            Lanjutkan dengan Google
        </a>

        <div class="auth-links">
            <p>
                Belum memiliki akun?
                <a href="{{ url('/register') }}">Daftar sekarang</a>
            </p>

            <a href="{{ url('/') }}" class="back-link">
                ← Kembali ke peta MeowMap
            </a>
        </div>
    </main>

    <script>
        const form = document.getElementById('login-form');
        const button = document.getElementById('login-button');
        const message = document.getElementById('message');
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('password-toggle');

        // Tampilkan atau sembunyikan password.
        passwordToggle.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';

            passwordInput.type = isHidden ? 'text' : 'password';

            passwordToggle.setAttribute(
                'aria-pressed',
                String(isHidden)
            );

            passwordToggle.setAttribute(
                'aria-label',
                isHidden ? 'Sembunyikan password' : 'Tampilkan password'
            );
        });

        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            message.textContent = '';
            message.className = '';

            button.disabled = true;
            button.textContent = 'Memproses...';

            try {
                const response = await fetch(
                    @json(url('/api/login')),
                    {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            email: document
                                .getElementById('email')
                                .value
                                .trim(),

                            password: passwordInput.value
                        })
                    }
                );

                const result = await response.json().catch(function () {
                    return {};
                });

                if (!response.ok) {
                    const errors = Object.values(
                        result.errors || {}
                    ).flat();

                    throw new Error(
                        errors.join('\n') ||
                        result.message ||
                        `Login gagal (${response.status}).`
                    );
                }

                const token = result.data?.token;

                if (!token) {
                    throw new Error(
                        'Login berhasil, tetapi token tidak ditemukan dalam respons API.'
                    );
                }

                // Key harus sama dengan yang digunakan halaman utama.
                localStorage.setItem('meowmap_token', token);

                message.textContent =
                    'Login berhasil! Mengalihkan ke MeowMap...';

                message.className = 'success';

                window.location.assign(@json(url('/')));

            } catch (error) {
                message.textContent =
                    error.message ||
                    'Tidak dapat terhubung ke server.';

                message.className = 'error';

            } finally {
                button.disabled = false;
                button.textContent = 'Login';
            }
        });
    </script>

</body>
</html>
