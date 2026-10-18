<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f7f8f3">
    <title>Daftar Akun - MeowMap</title>

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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
            background: var(--background);
        }

        button,
        input {
            font: inherit;
        }

        .register-container {
            width: 100%;
            max-width: 440px;
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
            justify-content: center;
            align-items: center;
            width: 64px;
            height: 64px;
            margin-bottom: 16px;
            border-radius: 20px;
            background: var(--green-light);
            font-size: 34px;
        }

        .brand h1 {
            margin-bottom: 8px;
            font-size: 27px;
            font-weight: 800;
            letter-spacing: -0.8px;
        }

        .brand h1 span {
            color: var(--green);
        }

        .brand p {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
        }

        .form-group input {
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

        .form-group input::placeholder {
            color: #a0a39b;
        }

        .form-group input:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(71, 115, 76, 0.12);
        }

        .form-group input:disabled {
            background: #f5f6f2;
            cursor: not-allowed;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 48px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
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

        .field-error {
            display: block;
            margin-top: 6px;
            color: var(--danger);
            font-size: 12px;
            line-height: 1.5;
        }

        .alert {
            display: none;
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .alert.error {
            display: block;
            color: #991b1b;
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .alert.success {
            display: block;
            color: #26713a;
            background: var(--green-light);
            border: 1px solid #cdddc9;
        }

        .register-button {
            width: 100%;
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

        .register-button:hover {
            background: var(--green-dark);
        }

        .register-button:active {
            transform: scale(0.99);
        }

        .register-button:disabled {
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

        .login-link {
            margin-top: 24px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
            text-align: center;
        }

        .login-link a {
            color: var(--green);
            font-weight: 700;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .back-link {
            display: block;
            margin-top: 18px;
            color: var(--muted);
            font-size: 12px;
            text-align: center;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--green);
        }

        @media (max-width: 480px) {
            body {
                padding: 16px;
            }

            .register-container {
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

    <main class="register-container">
        <header class="brand">
            <div class="brand-icon" aria-hidden="true">🐱</div>

            <h1>Meow<span>Map.</span></h1>

            <p>
                Buat akun dan bergabunglah untuk membantu
                kucing di sekitar kita.
            </p>
        </header>

        <div
            id="alertMessage"
            class="alert"
            role="alert"
            aria-live="polite"
        ></div>

        <form id="registerForm">
            <div class="form-group">
                <label for="name">Nama lengkap</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Masukkan nama lengkap"
                    autocomplete="name"
                    maxlength="255"
                    required
                >
                <small class="field-error" id="nameError"></small>
            </div>

            <div class="form-group">
                <label for="email">Alamat email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="nama@email.com"
                    autocomplete="email"
                    maxlength="255"
                    required
                >
                <small class="field-error" id="emailError"></small>
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <div class="password-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        data-target="password"
                        aria-label="Tampilkan password"
                        aria-pressed="false"
                    >
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>

                <small class="field-error" id="passwordError"></small>
            </div>

            <div class="form-group">
                <label for="password_confirmation">
                    Konfirmasi password
                </label>

                <div class="password-wrapper">
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Masukkan ulang password"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        data-target="password_confirmation"
                        aria-label="Tampilkan konfirmasi password"
                        aria-pressed="false"
                    >
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>

                <small
                    class="field-error"
                    id="password_confirmationError"
                ></small>
            </div>

            <button
                type="submit"
                id="registerButton"
                class="register-button"
            >
                Buat Akun
            </button>
        </form>

        <div class="divider">ATAU DAFTAR DENGAN</div>

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

        <p class="login-link">
            Sudah memiliki akun?
            <a href="{{ url('/login') }}">Masuk di sini</a>
        </p>

        <a href="{{ url('/') }}" class="back-link">
            ← Kembali ke halaman utama
        </a>
    </main>

    <script>
        const API_BASE = @json(url('/api'));

        const registerForm = document.getElementById('registerForm');
        const registerButton = document.getElementById('registerButton');
        const alertMessage = document.getElementById('alertMessage');

        const fields = [
            'name',
            'email',
            'password',
            'password_confirmation'
        ];

        // Tampilkan atau sembunyikan password.
        document.querySelectorAll('.password-toggle').forEach(function (button) {
            button.addEventListener('click', function () {
                const input = document.getElementById(button.dataset.target);
                const isPassword = input.type === 'password';

                input.type = isPassword ? 'text' : 'password';
                button.setAttribute('aria-pressed', String(isPassword));

                if (input.id === 'password_confirmation') {
                    button.setAttribute(
                        'aria-label',
                        isPassword
                            ? 'Sembunyikan konfirmasi password'
                            : 'Tampilkan konfirmasi password'
                    );
                } else {
                    button.setAttribute(
                        'aria-label',
                        isPassword
                            ? 'Sembunyikan password'
                            : 'Tampilkan password'
                    );
                }
            });
        });

        function clearErrors() {
            fields.forEach(function (field) {
                document.getElementById(field + 'Error').textContent = '';
            });

            alertMessage.textContent = '';
            alertMessage.className = 'alert';
        }

        function showAlert(message, type) {
            alertMessage.textContent = message;
            alertMessage.className = 'alert ' + type;
        }

        function showValidationErrors(errors) {
            let firstError = null;

            fields.forEach(function (field) {
                if (errors[field] && errors[field].length > 0) {
                    const errorElement =
                        document.getElementById(field + 'Error');

                    errorElement.textContent = errors[field][0];

                    if (!firstError) {
                        firstError = document.getElementById(field);
                    }
                }
            });

            if (firstError) {
                firstError.focus();
            }
        }

        registerForm.addEventListener('submit', async function (event) {
            event.preventDefault();
            clearErrors();

            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const passwordConfirmation =
                document.getElementById('password_confirmation').value;

            if (password !== passwordConfirmation) {
                showValidationErrors({
                    password_confirmation: [
                        'Konfirmasi password tidak cocok.'
                    ]
                });
                return;
            }

            registerButton.disabled = true;
            registerButton.textContent = 'Memproses...';

            try {
                const response = await fetch(API_BASE + '/register', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        name: name,
                        email: email,
                        password: password,
                        password_confirmation: passwordConfirmation
                    })
                });

                const result = await response.json().catch(function () {
                    return {};
                });

                if (response.status === 422) {
                    if (result.errors) {
                        showValidationErrors(result.errors);
                    }

                    showAlert(
                        result.message ||
                        'Periksa kembali data registrasi kamu.',
                        'error'
                    );
                    return;
                }

                if (!response.ok) {
                    showAlert(
                        result.message ||
                        'Registrasi gagal. Silakan coba lagi.',
                        'error'
                    );
                    return;
                }

                showAlert(
                    'Registrasi berhasil! Kamu akan diarahkan ke halaman login.',
                    'success'
                );

                registerForm.reset();

                window.setTimeout(function () {
                    window.location.href = @json(url('/login'));
                }, 1500);

            } catch (error) {
                showAlert(
                    'Tidak dapat terhubung ke server. Pastikan Laravel sedang berjalan.',
                    'error'
                );
            } finally {
                registerButton.disabled = false;
                registerButton.textContent = 'Buat Akun';
            }
        });
    </script>

</body>
</html>
