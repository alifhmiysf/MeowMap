```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Google - MeowMap</title>
</head>
<body>
    <p id="status">Menyelesaikan autentikasi Google...</p>

    <script>
        const token = @json($token);

        if (typeof token === 'string' && token.length > 0) {
            localStorage.setItem('meowmap_token', token);

            document.getElementById('status').textContent =
                'Login berhasil. Mengalihkan...';

            window.location.replace('/');
        } else {
            document.getElementById('status').textContent =
                'Login gagal. Token autentikasi tidak ditemukan.';
        }
    </script>
</body>
</html>
```